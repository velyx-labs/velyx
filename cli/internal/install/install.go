// Package install resolves components with their dependencies and writes their
// files into a project as one transaction: either every file lands or none does.
package install

import (
	"errors"
	"fmt"
	"os"
	"path/filepath"
	"regexp"
	"sort"
	"strings"

	"github.com/velyx-labs/velyx/cli/internal/registry"
)

// Fetcher returns a component from the registry; version "" means latest.
type Fetcher interface {
	Item(name, version string) (*registry.Item, error)
}

// Resolve returns the requested components and everything they depend on,
// dependencies first. Names may carry a version: "button@3.0.0".
func Resolve(src Fetcher, names []string) ([]*registry.Item, error) {
	var ordered []*registry.Item
	state := map[string]int{} // 0 new, 1 visiting, 2 done

	var visit func(name, version string, chain []string) error
	visit = func(name, version string, chain []string) error {
		switch state[name] {
		case 1:
			return fmt.Errorf("dependency cycle: %s", strings.Join(append(chain, name), " → "))
		case 2:
			return nil
		}
		state[name] = 1
		item, err := src.Item(name, version)
		if err != nil {
			return err
		}
		for _, dep := range item.Dependencies.Components {
			if err := visit(dep, "", append(chain, name)); err != nil {
				return err
			}
		}
		state[name] = 2
		ordered = append(ordered, item)

		return nil
	}

	for _, arg := range names {
		name, version, _ := strings.Cut(arg, "@")
		if err := visit(name, version, nil); err != nil {
			return nil, err
		}
	}

	return ordered, nil
}

// File is one file the plan writes.
type File struct {
	Component string
	Target    string // relative to the project root, for display
	Path      string // absolute
	Content   string
	Exists    bool
	Same      bool
}

// Plan is everything an install will change.
type Plan struct {
	Items    []*registry.Item
	Files    []File
	Composer []string
	NPM      []string
}

// Options shape how files are written.
type Options struct {
	Root       string // project root
	Components string // components folder, relative to Root
	IconSet    string // replaces the default set in the icon component
}

var iconSetProp = regexp.MustCompile(`'set' => '[a-z0-9-]+',`)

// NewPlan computes the files to write and whether each one already exists.
func NewPlan(items []*registry.Item, opts Options) (*Plan, error) {
	plan := &Plan{Items: items}
	composer, npm := map[string]bool{}, map[string]bool{}

	for _, item := range items {
		for _, f := range item.Files {
			rel := filepath.Join(opts.Components, filepath.FromSlash(f.Target))
			abs := filepath.Join(opts.Root, rel)
			if !strings.HasPrefix(abs, filepath.Clean(opts.Root)+string(os.PathSeparator)) {
				return nil, fmt.Errorf("%s: target %q leaves the project", item.Name, f.Target)
			}
			content := f.Content
			if item.Name == "icon" && opts.IconSet != "" {
				content = iconSetProp.ReplaceAllString(content, fmt.Sprintf("'set' => '%s',", opts.IconSet))
			}
			file := File{Component: item.Name, Target: filepath.ToSlash(rel), Path: abs, Content: content}
			if existing, err := os.ReadFile(abs); err == nil {
				file.Exists = true
				file.Same = string(existing) == content
			}
			plan.Files = append(plan.Files, file)
		}
		for _, p := range item.Dependencies.Composer {
			composer[p] = true
		}
		for _, p := range item.Dependencies.NPM {
			npm[p] = true
		}
	}
	plan.Composer = sortedKeys(composer)
	plan.NPM = sortedKeys(npm)

	return plan, nil
}

// Conflicts lists files that exist with different content (local edits).
func (p *Plan) Conflicts() []File {
	var out []File
	for _, f := range p.Files {
		if f.Exists && !f.Same {
			out = append(out, f)
		}
	}

	return out
}

// ErrConflicts means some files have local edits and overwrite was not allowed.
var ErrConflicts = errors.New("some files already exist with local changes")

// writeFile is swapped in tests to simulate a failing disk.
var writeFile = func(path string, data []byte) error {
	if err := os.MkdirAll(filepath.Dir(path), 0o755); err != nil {
		return err
	}
	tmp := path + ".velyx-tmp"
	if err := os.WriteFile(tmp, data, 0o644); err != nil {
		return err
	}

	return os.Rename(tmp, path)
}

// Apply writes the plan. Unchanged files are skipped. Files with local edits
// stop the install before anything is written, unless overwrite is true.
// If any write fails, every file already written is restored.
func (p *Plan) Apply(overwrite bool) (written []File, err error) {
	if !overwrite && len(p.Conflicts()) > 0 {
		return nil, ErrConflicts
	}

	type backup struct {
		path    string
		content []byte
		existed bool
	}
	var done []backup
	defer func() {
		if err == nil {
			return
		}
		for i := len(done) - 1; i >= 0; i-- {
			b := done[i]
			if b.existed {
				_ = os.WriteFile(b.path, b.content, 0o644)
			} else {
				_ = os.Remove(b.path)
			}
		}
		written = nil
	}()

	for _, f := range p.Files {
		if f.Same {
			continue
		}
		previous, readErr := os.ReadFile(f.Path)
		if err = writeFile(f.Path, []byte(f.Content)); err != nil {
			return nil, fmt.Errorf("write %s: %w", f.Target, err)
		}
		done = append(done, backup{path: f.Path, content: previous, existed: readErr == nil})
		written = append(written, f)
	}

	return written, nil
}

func sortedKeys(m map[string]bool) []string {
	out := make([]string, 0, len(m))
	for k := range m {
		out = append(out, k)
	}
	sort.Strings(out)

	return out
}
