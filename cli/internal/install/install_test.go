package install

import (
	"errors"
	"os"
	"path/filepath"
	"strings"
	"testing"

	"github.com/velyx-labs/velyx/cli/internal/registry"
)

type fakeSource map[string]*registry.Item

func (f fakeSource) Item(name, _ string) (*registry.Item, error) {
	if it, ok := f[name]; ok {
		return it, nil
	}
	return nil, errors.New("not found: " + name)
}

func item(name string, deps []string, files ...string) *registry.Item {
	it := &registry.Item{Manifest: registry.Manifest{Name: name, Version: "3.0.0", Dependencies: registry.Dependencies{Components: deps}}}
	for _, f := range files {
		it.Files = append(it.Files, registry.BuiltFile{Path: f, Target: f, Content: "<" + name + ">"})
	}
	return it
}

func TestResolveOrdersDependenciesFirst(t *testing.T) {
	src := fakeSource{
		"icon":   item("icon", nil, "icon.blade.php"),
		"button": item("button", []string{"icon"}, "button.blade.php"),
		"dialog": item("dialog", []string{"button", "icon"}, "dialog/dialog.blade.php"),
	}
	items, err := Resolve(src, []string{"dialog", "button"})
	if err != nil {
		t.Fatal(err)
	}
	var names []string
	for _, it := range items {
		names = append(names, it.Name)
	}
	if got := strings.Join(names, ","); got != "icon,button,dialog" {
		t.Fatalf("order = %s", got)
	}
}

func TestResolveDetectsCycles(t *testing.T) {
	src := fakeSource{"a": item("a", []string{"b"}), "b": item("b", []string{"a"})}
	if _, err := Resolve(src, []string{"a"}); err == nil || !strings.Contains(err.Error(), "cycle") {
		t.Fatalf("expected a cycle error, got %v", err)
	}
}

func TestPlanSetsIconSetAndSpotsConflicts(t *testing.T) {
	root := t.TempDir()
	icon := item("icon", nil)
	icon.Files = []registry.BuiltFile{{Path: "icon.blade.php", Target: "icon.blade.php", Content: "@props([\n    'name',\n    'set' => 'lucide',\n])"}}
	btn := item("button", []string{"icon"}, "button.blade.php")

	dir := filepath.Join(root, "ui")
	os.MkdirAll(dir, 0o755)
	os.WriteFile(filepath.Join(dir, "button.blade.php"), []byte("<my edited button>"), 0o644)

	plan, err := NewPlan([]*registry.Item{icon, btn}, Options{Root: root, Components: "ui", IconSet: "tabler"})
	if err != nil {
		t.Fatal(err)
	}
	if !strings.Contains(plan.Files[0].Content, "'set' => 'tabler',") {
		t.Fatalf("icon set not replaced: %s", plan.Files[0].Content)
	}
	if c := plan.Conflicts(); len(c) != 1 || c[0].Target != "ui/button.blade.php" {
		t.Fatalf("conflicts = %+v", c)
	}
	if _, err := plan.Apply(false); !errors.Is(err, ErrConflicts) {
		t.Fatalf("expected ErrConflicts, got %v", err)
	}
	if _, err := os.Stat(filepath.Join(dir, "icon.blade.php")); !os.IsNotExist(err) {
		t.Fatal("nothing should be written when there are conflicts")
	}
	if _, err := plan.Apply(true); err != nil {
		t.Fatal(err)
	}
	got, _ := os.ReadFile(filepath.Join(dir, "button.blade.php"))
	if string(got) != "<button>" {
		t.Fatalf("overwrite did not apply: %s", got)
	}
}

func TestApplyRollsBackOnFailure(t *testing.T) {
	root := t.TempDir()
	os.WriteFile(filepath.Join(root, "a.blade.php"), []byte("original a"), 0o644)
	plan, _ := NewPlan([]*registry.Item{item("x", nil, "a.blade.php", "b.blade.php", "c.blade.php")}, Options{Root: root})

	real := writeFile
	defer func() { writeFile = real }()
	calls := 0
	writeFile = func(path string, data []byte) error {
		calls++
		if calls == 3 {
			return errors.New("disk full")
		}
		return real(path, data)
	}

	if _, err := plan.Apply(true); err == nil || !strings.Contains(err.Error(), "disk full") {
		t.Fatalf("expected the write error, got %v", err)
	}
	a, _ := os.ReadFile(filepath.Join(root, "a.blade.php"))
	if string(a) != "original a" {
		t.Fatalf("a.blade.php not restored: %s", a)
	}
	if _, err := os.Stat(filepath.Join(root, "b.blade.php")); !os.IsNotExist(err) {
		t.Fatal("b.blade.php should have been removed")
	}
}

func TestPlanRejectsTargetsOutsideTheProject(t *testing.T) {
	bad := item("bad", nil)
	bad.Files = []registry.BuiltFile{{Path: "x", Target: "../../etc/passwd", Content: ""}}
	if _, err := NewPlan([]*registry.Item{bad}, Options{Root: t.TempDir(), Components: "ui"}); err == nil {
		t.Fatal("expected an error for a target outside the project")
	}
}
