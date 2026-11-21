package registry

import (
	"encoding/json"
	"errors"
	"fmt"
	"os"
	"path/filepath"
	"regexp"
	"sort"
)

// BuiltFile is one component file with its content inlined, as the CLI downloads it.
type BuiltFile struct {
	Path    string `json:"path"`
	Target  string `json:"target"`
	Content string `json:"content"`
}

// Item is a component as served by the static registry: its manifest plus file contents.
type Item struct {
	Manifest
	Files []BuiltFile `json:"files"`
}

// IndexEntry is one row of build/index.json.
type IndexEntry struct {
	Name        string   `json:"name"`
	Version     string   `json:"version"`
	Description string   `json:"description"`
	Components  []string `json:"dependencies,omitempty"`
}

// Index is build/index.json.
type Index struct {
	Schema     int          `json:"schema"`
	Components []IndexEntry `json:"components"`
}

// IconChecker reports whether a Velyx icon name exists in the icon map.
type IconChecker interface {
	Has(name string) bool
}

var iconUse = regexp.MustCompile(`<x-ui\.icon\s+name="([a-z0-9-]+)"`)

// Load reads and validates every component under dir (registry/components).
func Load(dir string, icons IconChecker) ([]Item, error) {
	entries, err := os.ReadDir(dir)
	if err != nil {
		return nil, err
	}

	var items []Item
	var problems []error
	for _, entry := range entries {
		if !entry.IsDir() {
			continue
		}
		item, err := loadOne(filepath.Join(dir, entry.Name()), entry.Name(), icons)
		if err != nil {
			problems = append(problems, fmt.Errorf("%s: %w", entry.Name(), err))
		}
		// Keep components whose manifest parsed, so their dependencies are still checked.
		if item.Name != "" {
			items = append(items, item)
		}
	}

	known := map[string]bool{}
	for _, item := range items {
		known[item.Name] = true
	}
	for _, item := range items {
		for _, dep := range item.Dependencies.Components {
			if !known[dep] {
				problems = append(problems, fmt.Errorf("%s: depends on unknown component %q", item.Name, dep))
			}
		}
	}
	sort.Slice(items, func(i, j int) bool { return items[i].Name < items[j].Name })

	return items, errors.Join(problems...)
}

func loadOne(dir, folder string, icons IconChecker) (Item, error) {
	data, err := os.ReadFile(filepath.Join(dir, "component.json"))
	if err != nil {
		return Item{}, err
	}
	manifest, err := ParseManifest(data)
	if err != nil {
		return Item{}, err
	}
	if manifest.Name != folder {
		return Item{}, fmt.Errorf("name %q does not match its folder", manifest.Name)
	}

	item := Item{Manifest: *manifest}
	var problems []error
	for _, f := range manifest.Files {
		content, err := os.ReadFile(filepath.Join(dir, filepath.FromSlash(f.Path)))
		if err != nil {
			problems = append(problems, fmt.Errorf("file %s: %w", f.Path, err))
			continue
		}
		for _, m := range iconUse.FindAllStringSubmatch(string(content), -1) {
			if icons != nil && !icons.Has(m[1]) {
				problems = append(problems, fmt.Errorf("%s uses icon %q, which is not in registry/icons/icons.json", f.Path, m[1]))
			}
		}
		item.Files = append(item.Files, BuiltFile{Path: f.Path, Target: f.Target, Content: string(content)})
	}

	return item, errors.Join(problems...)
}

// Write renders the static registry: index.json plus <name>.json and <name>@<version>.json per component.
func Write(out string, items []Item) error {
	if err := os.MkdirAll(filepath.Join(out, "components"), 0o755); err != nil {
		return err
	}

	index := Index{Schema: 1}
	for _, item := range items {
		index.Components = append(index.Components, IndexEntry{
			Name: item.Name, Version: item.Version, Description: item.Description, Components: item.Dependencies.Components,
		})
		for _, name := range []string{item.Name, item.Name + "@" + item.Version} {
			if err := writeJSON(filepath.Join(out, "components", name+".json"), item); err != nil {
				return err
			}
		}
	}

	return writeJSON(filepath.Join(out, "index.json"), index)
}

func writeJSON(path string, v any) error {
	data, err := json.MarshalIndent(v, "", "  ")
	if err != nil {
		return err
	}

	return os.WriteFile(path, append(data, '\n'), 0o644)
}
