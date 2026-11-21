package app

import (
	"errors"
	"flag"
	"fmt"
	"os"
	"path/filepath"
	"strings"

	"github.com/charmbracelet/huh"

	"github.com/velyx-labs/velyx/cli/internal/config"
	"github.com/velyx-labs/velyx/cli/internal/icons"
	"github.com/velyx-labs/velyx/cli/internal/install"
	"github.com/velyx-labs/velyx/cli/internal/project"
	"github.com/velyx-labs/velyx/cli/internal/registry"
	"github.com/velyx-labs/velyx/cli/internal/source"
	"github.com/velyx-labs/velyx/cli/internal/theme"
	"github.com/velyx-labs/velyx/cli/internal/ui"
)

// Init sets up velyx.json, the theme stylesheet and the icon component.
func (a *App) Init(args []string) error {
	fs := flag.NewFlagSet("init", flag.ContinueOnError)
	fs.SetOutput(a.Err)
	cwd := fs.String("cwd", "", "project root (default: current folder)")
	registryLoc := fs.String("registry", "", "registry URL or local folder")
	yes := fs.Bool("yes", false, "accept the defaults and run composer without asking")
	force := fs.Bool("force", false, "overwrite an existing velyx.json")
	noComposer := fs.Bool("no-composer", false, "do not run composer require")
	defaults := config.Default()
	components := fs.String("components", defaults.Components, "where components are written")
	iconSet := fs.String("icons", defaults.Icons, "icon set: lucide, heroicons, tabler or phosphor")
	base := fs.String("base", defaults.Theme.Base, "base color: neutral, zinc, stone, slate or gray")
	accent := fs.String("accent", defaults.Theme.Accent, "primary color: neutral, blue, green, orange, rose or violet")
	radius := fs.String("radius", defaults.Theme.Radius, "base radius in rem")
	if _, err := parse(fs, args); err != nil {
		return err
	}

	root, err := a.root(*cwd)
	if err != nil {
		return err
	}
	info, err := project.Detect(root)
	if err != nil {
		return err
	}
	if config.Exists(root) && !*force {
		return errors.New("velyx.json already exists. Use --force to start over")
	}
	a.header(fmt.Sprintf("Laravel %s · Livewire %s · Tailwind %s", orDash(info.Laravel), orDash(info.Livewire), orDash(info.Tailwind)))
	for _, p := range info.Problems() {
		fmt.Fprintln(a.Out, "  "+ui.Bad.Render("!")+" "+p)
	}

	src := source.New(*registryLoc)
	themes, err := src.Themes()
	if err != nil {
		return err
	}
	iconMap, err := src.Icons()
	if err != nil {
		return err
	}

	cfg := config.Default()
	cfg.Components, cfg.Icons = *components, *iconSet
	cfg.Theme = config.Theme{Base: *base, Accent: *accent, Radius: *radius, Font: defaults.Theme.Font}
	if info.AppCSS != "" {
		cfg.AppCSS = info.AppCSS
	}
	if *registryLoc != "" {
		cfg.Registry = *registryLoc
	}

	if a.Interactive && !*yes {
		if err := a.askInit(&cfg, iconMap); err != nil {
			return err
		}
	}
	if _, ok := iconMap.Libraries[cfg.Icons]; !ok {
		return fmt.Errorf("unknown icon set %q (choose from %s)", cfg.Icons, strings.Join(iconMap.Sets(), ", "))
	}
	opts, err := themes.Resolve(theme.Options(cfg.Theme))
	if err != nil {
		return err
	}
	css, err := themes.CSS(opts)
	if err != nil {
		return err
	}

	// Theme stylesheet and its import.
	if err := writeText(filepath.Join(root, cfg.CSS), css); err != nil {
		return err
	}
	fmt.Fprintln(a.Out, "  "+ui.Ok.Render("+")+" "+cfg.CSS)
	if changed, err := ensureImport(filepath.Join(root, cfg.AppCSS), cfg.CSS); err != nil {
		return err
	} else if changed {
		fmt.Fprintln(a.Out, "  "+ui.Ok.Render("~")+" "+cfg.AppCSS+ui.Faint.Render("  imports velyx.css"))
	}

	// Icon component.
	items, err := install.Resolve(src, []string{"icon"})
	if err != nil {
		return err
	}
	if err := a.write(root, &cfg, items, *force); err != nil {
		return err
	}
	if err := cfg.Save(root); err != nil {
		return err
	}
	fmt.Fprintln(a.Out, "  "+ui.Ok.Render("+")+" "+config.FileName)

	if err := a.composer(root, []string{iconMap.Libraries[cfg.Icons].Composer}, *yes, *noComposer); err != nil {
		return err
	}
	fmt.Fprintf(a.Out, "\n%s Add your first component: %s\n", ui.Bold.Render("Ready."), ui.Mono.Render("npx velyx add button"))

	return nil
}

func (a *App) askInit(cfg *config.Config, iconMap *icons.Map) error {
	var setOptions []huh.Option[string]
	for _, s := range iconMap.Sets() {
		setOptions = append(setOptions, huh.NewOption(iconMap.Libraries[s].Label, s))
	}
	baseOptions := huh.NewOptions("neutral", "zinc", "stone", "slate", "gray")
	accentOptions := huh.NewOptions("neutral", "blue", "green", "orange", "rose", "violet")

	return huh.NewForm(huh.NewGroup(
		huh.NewInput().Title("Components folder").Value(&cfg.Components),
		huh.NewInput().Title("Main stylesheet").Value(&cfg.AppCSS),
		huh.NewSelect[string]().Title("Icon set").Options(setOptions...).Value(&cfg.Icons),
		huh.NewSelect[string]().Title("Base color").Options(baseOptions...).Value(&cfg.Theme.Base),
		huh.NewSelect[string]().Title("Primary color").Options(accentOptions...).Value(&cfg.Theme.Accent),
	)).Run()
}

// Add copies components and their dependencies into the project.
func (a *App) Add(args []string) error {
	fs := flag.NewFlagSet("add", flag.ContinueOnError)
	fs.SetOutput(a.Err)
	cwd := fs.String("cwd", "", "project root (default: current folder)")
	registryLoc := fs.String("registry", "", "registry URL or local folder")
	overwrite := fs.Bool("overwrite", false, "replace files that have local changes")
	yes := fs.Bool("yes", false, "run composer without asking")
	noComposer := fs.Bool("no-composer", false, "do not run composer require")
	dryRun := fs.Bool("dry-run", false, "show what would change without writing")
	names, err := parse(fs, args)
	if err != nil {
		return err
	}
	if len(names) == 0 {
		return errors.New("name at least one component, for example: velyx add button")
	}

	root, err := a.root(*cwd)
	if err != nil {
		return err
	}
	cfg, err := config.Load(root)
	if err != nil {
		return err
	}
	loc := *registryLoc
	if loc == "" {
		loc = cfg.Registry
	}
	src := source.New(loc)
	a.header("")

	items, err := install.Resolve(src, names)
	if err != nil {
		return err
	}
	if *dryRun {
		plan, err := install.NewPlan(items, install.Options{Root: root, Components: cfg.Components, IconSet: cfg.Icons})
		if err != nil {
			return err
		}
		for _, f := range plan.Files {
			fmt.Fprintln(a.Out, "  "+status(f)+" "+f.Target)
		}
		fmt.Fprintln(a.Out, "\n"+ui.Faint.Render("Dry run: nothing was written."))
		return nil
	}
	if err := a.write(root, cfg, items, *overwrite); err != nil {
		return err
	}
	if err := cfg.Save(root); err != nil {
		return err
	}

	var composerPkgs []string
	for _, it := range items {
		composerPkgs = append(composerPkgs, it.Dependencies.Composer...)
	}
	if err := a.composer(root, composerPkgs, *yes, *noComposer); err != nil {
		return err
	}
	fmt.Fprintf(a.Out, "\n%s %s\n", ui.Bold.Render(fmt.Sprintf("Added %d %s.", len(items), plural(len(items), "component"))), ui.Faint.Render("Review the diff, then commit."))

	return nil
}

func (a *App) write(root string, cfg *config.Config, items []*registry.Item, overwrite bool) error {
	plan, err := install.NewPlan(items, install.Options{Root: root, Components: cfg.Components, IconSet: cfg.Icons})
	if err != nil {
		return err
	}
	if conflicts := plan.Conflicts(); len(conflicts) > 0 && !overwrite {
		fmt.Fprintln(a.Out, "  "+ui.Bad.Render("!")+" These files have local changes:")
		for _, f := range conflicts {
			fmt.Fprintln(a.Out, "    "+f.Target)
		}
		if !a.Interactive {
			return errors.New("nothing was written. Re-run with --overwrite to replace them, or keep your versions")
		}
		var ok bool
		if err := huh.NewConfirm().Title("Replace them with the registry version?").Value(&ok).Run(); err != nil {
			return err
		}
		if !ok {
			return errors.New("nothing was written; your files are unchanged")
		}
		overwrite = true
	}

	written, err := plan.Apply(overwrite)
	if err != nil {
		return err
	}
	changed := map[string]bool{}
	for _, f := range written {
		changed[f.Path] = true
	}
	for _, f := range plan.Files {
		mark := ui.Faint.Render("=")
		if changed[f.Path] {
			mark = ui.Ok.Render("+")
			if f.Exists {
				mark = ui.Ok.Render("~")
			}
		}
		fmt.Fprintln(a.Out, "  "+mark+" "+f.Target)
	}
	for _, it := range items {
		cfg.Installed[it.Name] = it.Version
	}

	return nil
}

func (a *App) composer(root string, pkgs []string, yes, skip bool) error {
	pkgs = unique(pkgs)
	if len(pkgs) == 0 {
		return nil
	}
	command := "composer require " + strings.Join(pkgs, " ")
	if skip {
		fmt.Fprintln(a.Out, "  "+ui.Faint.Render("Skipped. Run it yourself: "+command))
		return nil
	}
	if !yes {
		if !a.Interactive {
			fmt.Fprintln(a.Out, "  "+ui.Faint.Render("Next, run: ")+ui.Mono.Render(command))
			return nil
		}
		ok := true
		if err := huh.NewConfirm().Title("Run " + command + "?").Value(&ok).Run(); err != nil {
			return err
		}
		if !ok {
			fmt.Fprintln(a.Out, "  "+ui.Faint.Render("Skipped. Run it yourself: "+command))
			return nil
		}
	}
	if err := a.Run(root, "composer", append([]string{"require"}, pkgs...)...); err != nil {
		return fmt.Errorf("%s failed: %w", command, err)
	}
	fmt.Fprintln(a.Out, "  "+ui.Ok.Render("✓")+" "+command)

	return nil
}

// List shows the components in the registry and which ones are installed.
func (a *App) List(args []string) error {
	fs := flag.NewFlagSet("list", flag.ContinueOnError)
	fs.SetOutput(a.Err)
	cwd := fs.String("cwd", "", "project root (default: current folder)")
	registryLoc := fs.String("registry", "", "registry URL or local folder")
	if _, err := parse(fs, args); err != nil {
		return err
	}
	root, err := a.root(*cwd)
	if err != nil {
		return err
	}
	installed := map[string]string{}
	loc := *registryLoc
	if cfg, err := config.Load(root); err == nil {
		installed = cfg.Installed
		if loc == "" {
			loc = cfg.Registry
		}
	}
	idx, err := source.New(loc).Index()
	if err != nil {
		return err
	}
	a.header(fmt.Sprintf("%d components", len(idx.Components)))
	width := 0
	for _, c := range idx.Components {
		width = max(width, len(c.Name))
	}
	for _, c := range idx.Components {
		mark := ui.Faint.Render("·")
		if v, ok := installed[c.Name]; ok {
			mark = ui.Ok.Render("✓")
			if v != c.Version {
				mark = ui.Bad.Render("↑")
			}
		}
		fmt.Fprintf(a.Out, "  %s %-*s  %s\n", mark, width, c.Name, ui.Faint.Render(c.Description))
	}

	return nil
}

func status(f install.File) string {
	switch {
	case f.Same:
		return ui.Faint.Render("=")
	case f.Exists:
		return ui.Bad.Render("~")
	default:
		return ui.Ok.Render("+")
	}
}

// ensureImport adds `@import "./velyx.css";` to the main stylesheet once.
func ensureImport(appCSS, themeCSS string) (bool, error) {
	data, err := os.ReadFile(appCSS)
	if errors.Is(err, os.ErrNotExist) {
		return false, nil
	}
	if err != nil {
		return false, err
	}
	rel, err := filepath.Rel(filepath.Dir(appCSS), themeCSS)
	if err != nil {
		rel = filepath.Base(themeCSS)
	}
	if !strings.HasPrefix(rel, ".") {
		rel = "./" + rel
	}
	text := string(data)
	quote := `"`
	if strings.Contains(text, "@import 'tailwindcss'") {
		quote = "'" // follow the file's own quote style
	}
	line := fmt.Sprintf("@import %s%s%s;", quote, filepath.ToSlash(rel), quote)
	if strings.Contains(text, `@import "`+filepath.ToSlash(rel)+`"`) || strings.Contains(text, "@import '"+filepath.ToSlash(rel)+"'") {
		return false, nil
	}

	lines := strings.Split(text, "\n")
	at := 0
	for i, l := range lines {
		if strings.HasPrefix(strings.TrimSpace(l), "@import \"tailwindcss\"") || strings.HasPrefix(strings.TrimSpace(l), "@import 'tailwindcss'") {
			at = i + 1
			break
		}
	}
	lines = append(lines[:at], append([]string{line}, lines[at:]...)...)

	return true, os.WriteFile(appCSS, []byte(strings.Join(lines, "\n")), 0o644)
}

func writeText(path, content string) error {
	if err := os.MkdirAll(filepath.Dir(path), 0o755); err != nil {
		return err
	}

	return os.WriteFile(path, []byte(content), 0o644)
}

func unique(in []string) []string {
	seen := map[string]bool{}
	var out []string
	for _, s := range in {
		if s != "" && !seen[s] {
			seen[s] = true
			out = append(out, s)
		}
	}

	return out
}

func plural(n int, word string) string {
	if n == 1 {
		return word
	}

	return word + "s"
}

func orDash(s string) string {
	if s == "" {
		return "—"
	}

	return s
}
