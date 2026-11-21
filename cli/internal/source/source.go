// Package source fetches the static registry, over HTTP or from a local folder.
package source

import (
	"encoding/json"
	"errors"
	"fmt"
	"io"
	"net/http"
	"os"
	"path/filepath"
	"strings"
	"time"

	"github.com/velyx-labs/velyx/cli/internal/icons"
	"github.com/velyx-labs/velyx/cli/internal/registry"
	"github.com/velyx-labs/velyx/cli/internal/theme"
)

// DefaultURL is where the CLI reads the registry when nothing overrides it.
const DefaultURL = "https://raw.githubusercontent.com/velyx-labs/velyx/v3/registry/build"

// ErrNotFound means the registry has no such component or file.
var ErrNotFound = errors.New("not found in the registry")

// Source reads registry files from one location.
type Source struct {
	location string
	client   *http.Client
}

// New returns a source for an http(s) URL or a local folder (useful while developing components).
func New(location string) *Source {
	if location == "" {
		location = DefaultURL
	}

	return &Source{location: strings.TrimRight(location, "/"), client: &http.Client{Timeout: 20 * time.Second}}
}

// Location is the registry address in use.
func (s *Source) Location() string { return s.location }

func (s *Source) remote() bool {
	return strings.HasPrefix(s.location, "http://") || strings.HasPrefix(s.location, "https://")
}

func (s *Source) read(rel string) ([]byte, error) {
	if !s.remote() {
		data, err := os.ReadFile(filepath.Join(s.location, filepath.FromSlash(rel)))
		if errors.Is(err, os.ErrNotExist) {
			return nil, fmt.Errorf("%s: %w", rel, ErrNotFound)
		}
		return data, err
	}

	resp, err := s.client.Get(s.location + "/" + rel)
	if err != nil {
		return nil, fmt.Errorf("cannot reach the registry at %s: %w", s.location, err)
	}
	defer resp.Body.Close()
	if resp.StatusCode == http.StatusNotFound {
		return nil, fmt.Errorf("%s: %w", rel, ErrNotFound)
	}
	if resp.StatusCode != http.StatusOK {
		return nil, fmt.Errorf("registry answered %s for %s", resp.Status, rel)
	}

	return io.ReadAll(io.LimitReader(resp.Body, 10<<20))
}

// Index returns the list of components.
func (s *Source) Index() (*registry.Index, error) {
	data, err := s.read("index.json")
	if err != nil {
		return nil, err
	}
	var idx registry.Index
	if err := json.Unmarshal(data, &idx); err != nil {
		return nil, fmt.Errorf("read index.json: %w", err)
	}

	return &idx, nil
}

// Item returns one component, at a version or the latest when version is empty.
func (s *Source) Item(name, version string) (*registry.Item, error) {
	file := name
	if version != "" {
		file += "@" + version
	}
	data, err := s.read("components/" + file + ".json")
	if errors.Is(err, ErrNotFound) {
		return nil, fmt.Errorf("component %q: %w", file, ErrNotFound)
	}
	if err != nil {
		return nil, err
	}
	var item registry.Item
	if err := json.Unmarshal(data, &item); err != nil {
		return nil, fmt.Errorf("read %s.json: %w", file, err)
	}

	return &item, nil
}

// Themes returns the theme sources.
func (s *Source) Themes() (*theme.Source, error) {
	data, err := s.read("themes.json")
	if err != nil {
		return nil, err
	}

	return theme.Parse(data)
}

// Icons returns the icon map.
func (s *Source) Icons() (*icons.Map, error) {
	data, err := s.read("icons.json")
	if err != nil {
		return nil, err
	}

	return icons.Parse(data)
}
