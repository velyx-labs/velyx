package registry

import (
	"encoding/json"
	"os"
	"path/filepath"
	"strings"
	"testing"
)

type fakeIcons map[string]bool

func (f fakeIcons) Has(name string) bool { return f[name] }

func TestRepoRegistryLoads(t *testing.T) {
	icons := fakeIcons{"check": true, "x": true, "chevron-down": true, "chevron-right": true, "loader": true, "info": true,
		"circle-check": true, "alert-triangle": true, "search": true, "copy": true}
	items, err := Load("../../../registry/components", icons)
	if err != nil {
		t.Fatalf("Load: %v", err)
	}
	names := []string{}
	for _, it := range items {
		names = append(names, it.Name)
	}
	if got := strings.Join(names, ","); !strings.Contains(got, "button") || !strings.Contains(got, "card") || !strings.Contains(got, "icon") {
		t.Fatalf("unexpected components: %s", got)
	}
}

func TestWriteProducesIndexAndVersionedFiles(t *testing.T) {
	out := t.TempDir()
	items := []Item{{Manifest: Manifest{Name: "badge", Version: "3.0.0", Description: "A badge."}, Files: []BuiltFile{{Path: "badge.blade.php", Target: "badge.blade.php", Content: "<span></span>"}}}}
	if err := Write(out, items); err != nil {
		t.Fatal(err)
	}

	var index Index
	data, _ := os.ReadFile(filepath.Join(out, "index.json"))
	if err := json.Unmarshal(data, &index); err != nil || len(index.Components) != 1 || index.Components[0].Name != "badge" {
		t.Fatalf("bad index: %s (%v)", data, err)
	}
	for _, name := range []string{"badge.json", "badge@3.0.0.json"} {
		body, err := os.ReadFile(filepath.Join(out, "components", name))
		if err != nil || !strings.Contains(string(body), `"content": "\u003cspan\u003e\u003c/span\u003e"`) {
			t.Fatalf("%s: %s (%v)", name, body, err)
		}
	}
}

func writeComponent(t *testing.T, root, folder, manifest string, files map[string]string) {
	t.Helper()
	dir := filepath.Join(root, folder)
	if err := os.MkdirAll(dir, 0o755); err != nil {
		t.Fatal(err)
	}
	if err := os.WriteFile(filepath.Join(dir, "component.json"), []byte(manifest), 0o644); err != nil {
		t.Fatal(err)
	}
	for name, body := range files {
		if err := os.WriteFile(filepath.Join(dir, name), []byte(body), 0o644); err != nil {
			t.Fatal(err)
		}
	}
}

func TestLoadReportsBrokenComponents(t *testing.T) {
	root := t.TempDir()
	writeComponent(t, root, "alert",
		`{"name":"alert","version":"3.0.0","description":"x","dependencies":{"components":["ghost"]},"files":[{"path":"alert.blade.php","target":"alert.blade.php"}]}`,
		map[string]string{"alert.blade.php": `<x-ui.icon name="rocket" />`})
	writeComponent(t, root, "mismatch",
		`{"name":"other","version":"3.0.0","description":"x","files":[{"path":"a.blade.php","target":"a.blade.php"}]}`,
		map[string]string{"a.blade.php": ""})
	writeComponent(t, root, "missing",
		`{"name":"missing","version":"3.0.0","description":"x","files":[{"path":"gone.blade.php","target":"gone.blade.php"}]}`, nil)

	_, err := Load(root, fakeIcons{"check": true})
	if err == nil {
		t.Fatal("expected errors")
	}
	for _, want := range []string{`uses icon "rocket"`, `does not match its folder`, `gone.blade.php`, `unknown component "ghost"`} {
		if !strings.Contains(err.Error(), want) {
			t.Errorf("error is missing %q:\n%v", want, err)
		}
	}
}
