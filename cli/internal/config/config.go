// Package config reads and writes velyx.json, the file `velyx init` creates at the project root.
package config

import (
	"encoding/json"
	"errors"
	"fmt"
	"os"
	"path/filepath"
)

// FileName is the config file at the root of a Laravel project.
const FileName = "velyx.json"

// SchemaURL documents the file for editors.
const SchemaURL = "https://velyx.dev/schema/velyx.json"

var (
	// ErrNotInitialized means the project has no velyx.json yet.
	ErrNotInitialized = errors.New("this project has no velyx.json; run `velyx init` first")
	// ErrV2Config means velyx.json was written by Velyx v2.
	ErrV2Config = errors.New("this velyx.json was written by Velyx v2; run `velyx migrate` to upgrade it")
)

// Theme records the choices used to generate velyx.css.
type Theme struct {
	Base   string `json:"base"`
	Accent string `json:"accent"`
	Radius string `json:"radius"`
	Font   string `json:"font"`
}

// Config is the content of velyx.json.
type Config struct {
	Schema     string            `json:"$schema,omitempty"`
	Components string            `json:"components"`
	CSS        string            `json:"css"`
	AppCSS     string            `json:"appCss"`
	Icons      string            `json:"icons"`
	Theme      Theme             `json:"theme"`
	Registry   string            `json:"registry,omitempty"`
	Installed  map[string]string `json:"installed"`
}

// Default returns the config `velyx init` proposes.
func Default() Config {
	return Config{
		Schema:     SchemaURL,
		Components: "resources/views/components/ui",
		CSS:        "resources/css/velyx.css",
		AppCSS:     "resources/css/app.css",
		Icons:      "lucide",
		Theme:      Theme{Base: "neutral", Accent: "neutral", Radius: "0.625", Font: "Hanken Grotesk"},
		Installed:  map[string]string{},
	}
}

// Load reads velyx.json from a project root.
func Load(root string) (*Config, error) {
	data, err := os.ReadFile(filepath.Join(root, FileName))
	if errors.Is(err, os.ErrNotExist) {
		return nil, ErrNotInitialized
	}
	if err != nil {
		return nil, err
	}

	var probe map[string]json.RawMessage
	if err := json.Unmarshal(data, &probe); err != nil {
		return nil, fmt.Errorf("read %s: %w", FileName, err)
	}
	if raw, ok := probe["components"]; ok && len(raw) > 0 && raw[0] == '{' {
		return nil, ErrV2Config
	}

	var cfg Config
	if err := json.Unmarshal(data, &cfg); err != nil {
		return nil, fmt.Errorf("read %s: %w", FileName, err)
	}
	if cfg.Installed == nil {
		cfg.Installed = map[string]string{}
	}

	return &cfg, nil
}

// Exists reports whether a project already has velyx.json.
func Exists(root string) bool {
	_, err := os.Stat(filepath.Join(root, FileName))
	return err == nil
}

// Save writes velyx.json with stable formatting.
func (c *Config) Save(root string) error {
	data, err := json.MarshalIndent(c, "", "  ")
	if err != nil {
		return err
	}

	return os.WriteFile(filepath.Join(root, FileName), append(data, '\n'), 0o644)
}
