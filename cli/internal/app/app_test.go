package app

import (
	"bytes"
	"os"
	"path/filepath"
	"strings"
	"testing"

	"github.com/velyx-labs/velyx/cli/internal/config"
)

// The real registry, built by `make registry`.
var localRegistry, _ = filepath.Abs("../../../registry/build")

type harness struct {
	app      *App
	out, err *bytes.Buffer
	root     string
	ran      []string
}

func newHarness(t *testing.T) *harness {
	t.Helper()
	root := t.TempDir()
	files := map[string]string{
		"composer.json":         `{"require":{"laravel/framework":"^12.0","livewire/livewire":"^3.6"}}`,
		"composer.lock":         `{"packages":[{"name":"laravel/framework","version":"v12.4.1"}]}`,
		"package.json":          `{"devDependencies":{"tailwindcss":"^4.1.0"}}`,
		"resources/css/app.css": "@import \"tailwindcss\";\n\n@source '../views';\n",
	}
	for name, body := range files {
		path := filepath.Join(root, name)
		os.MkdirAll(filepath.Dir(path), 0o755)
		os.WriteFile(path, []byte(body), 0o644)
	}

	h := &harness{out: &bytes.Buffer{}, err: &bytes.Buffer{}, root: root}
	h.app = &App{
		Version: "test", Out: h.out, Err: h.err, Interactive: false,
		Getwd: func() (string, error) { return root, nil },
		Run: func(dir, name string, args ...string) error {
			h.ran = append(h.ran, name+" "+strings.Join(args, " "))
			return nil
		},
	}

	return h
}

func (h *harness) run(t *testing.T, args ...string) {
	t.Helper()
	if code := h.app.Main(args); code != 0 {
		t.Fatalf("velyx %s exited %d\nstdout:\n%s\nstderr:\n%s", strings.Join(args, " "), code, h.out, h.err)
	}
}

func (h *harness) read(t *testing.T, rel string) string {
	t.Helper()
	data, err := os.ReadFile(filepath.Join(h.root, rel))
	if err != nil {
		t.Fatalf("read %s: %v", rel, err)
	}
	return string(data)
}

func TestInitSetsUpTheProject(t *testing.T) {
	h := newHarness(t)
	h.run(t, "init", "--registry", localRegistry, "--yes", "--icons", "tabler", "--base", "zinc", "--accent", "blue")

	cfg, err := config.Load(h.root)
	if err != nil {
		t.Fatal(err)
	}
	if cfg.Icons != "tabler" || cfg.Theme.Base != "zinc" || cfg.Installed["icon"] != "3.0.0" {
		t.Fatalf("unexpected config: %+v", cfg)
	}
	if css := h.read(t, "resources/css/velyx.css"); !strings.Contains(css, "base zinc · accent blue") || !strings.Contains(css, ".dark {") {
		t.Fatalf("velyx.css not generated as expected:\n%s", css)
	}
	app := h.read(t, "resources/css/app.css")
	if !strings.HasPrefix(app, "@import \"tailwindcss\";\n@import \"./velyx.css\";") {
		t.Fatalf("import not added right after tailwindcss:\n%s", app)
	}
	if icon := h.read(t, "resources/views/components/ui/icon.blade.php"); !strings.Contains(icon, "'set' => 'tabler',") {
		t.Fatalf("icon component not set to tabler:\n%s", icon)
	}
	if len(h.ran) != 1 || h.ran[0] != "composer require secondnetwork/blade-tabler-icons" {
		t.Fatalf("composer calls = %v", h.ran)
	}
}

func TestInitRefusesToRunTwice(t *testing.T) {
	h := newHarness(t)
	h.run(t, "init", "--registry", localRegistry, "--yes", "--no-composer")
	if code := h.app.Main([]string{"init", "--registry", localRegistry, "--yes"}); code == 0 {
		t.Fatal("second init should fail without --force")
	}
	if !strings.Contains(h.err.String(), "already exists") {
		t.Fatalf("stderr = %s", h.err)
	}
}

func TestAddInstallsComponentsWithDependencies(t *testing.T) {
	h := newHarness(t)
	h.run(t, "init", "--registry", localRegistry, "--yes", "--no-composer")
	h.out.Reset()
	h.run(t, "add", "card", "button")

	for _, rel := range []string{"button.blade.php", "card/card.blade.php", "card/title.blade.php", "icon.blade.php"} {
		h.read(t, "resources/views/components/ui/"+rel)
	}
	cfg, _ := config.Load(h.root)
	if cfg.Installed["button"] != "3.0.0" || cfg.Installed["card"] != "3.0.0" {
		t.Fatalf("installed = %v", cfg.Installed)
	}
	if !strings.Contains(h.out.String(), "Added 3 components.") {
		t.Fatalf("stdout = %s", h.out)
	}
}

func TestAddStopsOnLocalEdits(t *testing.T) {
	h := newHarness(t)
	h.run(t, "init", "--registry", localRegistry, "--yes", "--no-composer")
	h.run(t, "add", "badge")
	path := filepath.Join(h.root, "resources/views/components/ui/badge.blade.php")
	os.WriteFile(path, []byte("my badge"), 0o644)

	if code := h.app.Main([]string{"add", "badge"}); code == 0 {
		t.Fatal("add should refuse to overwrite local edits")
	}
	if got, _ := os.ReadFile(path); string(got) != "my badge" {
		t.Fatal("local edit was overwritten")
	}
	h.run(t, "add", "badge", "--overwrite")
	if got, _ := os.ReadFile(path); string(got) == "my badge" {
		t.Fatal("--overwrite did not replace the file")
	}
}

func TestAddWithoutInitExplainsWhatToDo(t *testing.T) {
	h := newHarness(t)
	if code := h.app.Main([]string{"add", "button"}); code == 0 || !strings.Contains(h.err.String(), "velyx init") {
		t.Fatalf("code=%d stderr=%s", code, h.err)
	}
}

func TestListMarksInstalledComponents(t *testing.T) {
	h := newHarness(t)
	h.run(t, "init", "--registry", localRegistry, "--yes", "--no-composer")
	h.out.Reset()
	h.run(t, "list")
	out := h.out.String()
	if !strings.Contains(out, "✓ icon") || !strings.Contains(out, "· button") {
		t.Fatalf("list output:\n%s", out)
	}
}

func TestEnsureImportFollowsQuoteStyleAndRunsOnce(t *testing.T) {
	dir := t.TempDir()
	app := filepath.Join(dir, "app.css")
	os.WriteFile(app, []byte("@import 'tailwindcss';\n\n@source '../views';\n"), 0o644)

	for i := 0; i < 2; i++ {
		if _, err := ensureImport(app, filepath.Join(dir, "velyx.css")); err != nil {
			t.Fatal(err)
		}
	}
	got, _ := os.ReadFile(app)
	if string(got) != "@import 'tailwindcss';\n@import './velyx.css';\n\n@source '../views';\n" {
		t.Fatalf("app.css:\n%s", got)
	}
}
