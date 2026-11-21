// Package registry models the Velyx component registry: the per-component
// manifest (component.json) and, later, the built index the CLI downloads.
package registry

import (
	"bytes"
	"encoding/json"
	"errors"
	"fmt"
	"path"
	"regexp"
	"strings"
)

// Manifest is the content of registry/components/<name>/component.json.
// Keep it in sync with registry/schema/component.schema.json.
type Manifest struct {
	Schema       string       `json:"$schema,omitempty"`
	Name         string       `json:"name"`
	Version      string       `json:"version"`
	Description  string       `json:"description"`
	Requires     Requirements `json:"requires,omitempty"`
	Dependencies Dependencies `json:"dependencies,omitempty"`
	Files        []File       `json:"files"`
}

// Requirements are the minimum versions the user's project must meet.
type Requirements struct {
	PHP      string `json:"php,omitempty"`
	Laravel  string `json:"laravel,omitempty"`
	Livewire string `json:"livewire,omitempty"`
	Alpine   bool   `json:"alpine,omitempty"`
}

// Dependencies are installed alongside the component.
type Dependencies struct {
	Components []string `json:"components,omitempty"`
	Composer   []string `json:"composer,omitempty"`
	NPM        []string `json:"npm,omitempty"`
}

// File maps a file in the component folder to its destination in the project.
type File struct {
	Path   string `json:"path"`
	Target string `json:"target"`
}

// RequiredFields lists the manifest keys that must be present, mirroring the schema.
var RequiredFields = []string{"name", "version", "description", "files"}

var (
	namePattern    = regexp.MustCompile(`^[a-z][a-z0-9-]*$`)
	versionPattern = regexp.MustCompile(`^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)(-[0-9A-Za-z.-]+)?$`)
)

// ParseManifest decodes a manifest, rejecting unknown keys, and validates it.
func ParseManifest(data []byte) (*Manifest, error) {
	decoder := json.NewDecoder(bytes.NewReader(data))
	decoder.DisallowUnknownFields()

	var manifest Manifest
	if err := decoder.Decode(&manifest); err != nil {
		return nil, fmt.Errorf("decode component.json: %w", err)
	}
	if err := manifest.Validate(); err != nil {
		return nil, err
	}

	return &manifest, nil
}

// Validate reports every rule the manifest breaks, joined into one error.
func (m *Manifest) Validate() error {
	var problems []error

	if !namePattern.MatchString(m.Name) || len(m.Name) > 64 {
		problems = append(problems, fmt.Errorf("name %q must be lowercase letters, digits and hyphens", m.Name))
	}
	if !versionPattern.MatchString(m.Version) {
		problems = append(problems, fmt.Errorf("version %q is not a semantic version", m.Version))
	}
	if strings.TrimSpace(m.Description) == "" {
		problems = append(problems, errors.New("description is required"))
	}
	if len(m.Files) == 0 {
		problems = append(problems, errors.New("files must list at least one file"))
	}
	for i, file := range m.Files {
		if err := checkRelative("files[%d].path", i, file.Path); err != nil {
			problems = append(problems, err)
		}
		if err := checkRelative("files[%d].target", i, file.Target); err != nil {
			problems = append(problems, err)
		}
	}
	for _, dependency := range m.Dependencies.Components {
		if !namePattern.MatchString(dependency) {
			problems = append(problems, fmt.Errorf("dependency %q is not a valid component name", dependency))
		}
		if dependency == m.Name {
			problems = append(problems, errors.New("a component cannot depend on itself"))
		}
	}

	return errors.Join(problems...)
}

// checkRelative rejects empty, absolute and parent-escaping paths so a
// manifest can never write outside the folder it targets.
func checkRelative(field string, index int, value string) error {
	label := fmt.Sprintf(field, index)
	switch {
	case value == "":
		return fmt.Errorf("%s is empty", label)
	case strings.HasPrefix(value, "/") || strings.Contains(value, "\\"):
		return fmt.Errorf("%s %q must be a relative, slash-separated path", label, value)
	case path.Clean(value) != value || value == "." || strings.HasPrefix(value, "../") || value == "..":
		return fmt.Errorf("%s %q must be a clean path inside the component", label, value)
	}

	return nil
}
