// Package tokens reads the Velyx design tokens (tokens/tokens.json) and turns
// them into the artifacts other parts of the monorepo consume: a Tailwind v4
// stylesheet for components and the site, and a Go palette for the CLI.
package tokens

import (
	"bytes"
	"encoding/json"
	"fmt"
	"os"
	"regexp"
)

// File is the subset of tokens.json that the generators read.
type File struct {
	Name    string      `json:"name"`
	Color   ColorFamily `json:"color"`
	Type    TypeFamily  `json:"type"`
	Spacing ScaleFamily `json:"spacing"`
	Radius  ScaleFamily `json:"radius"`
	Shadow  ThemedScale `json:"shadow"`
}

// Theme is one color theme, such as light or dark.
type Theme struct {
	ID   string `json:"id"`
	Name string `json:"name"`
}

// ColorFamily holds the themes and the flat list of color tokens.
type ColorFamily struct {
	Themes []Theme       `json:"themes"`
	Tokens []ThemedToken `json:"tokens"`
}

// ThemedScale is a family whose values may differ per theme (shadows).
type ThemedScale struct {
	Tokens []ThemedToken `json:"tokens"`
}

// ThemedToken is a token whose value is either one string or one per theme.
type ThemedToken struct {
	Name  string      `json:"name"`
	Value ThemedValue `json:"value"`
	Usage string      `json:"usage"`
}

// ThemedValue is a plain string (same in every theme) or a map of theme id to value.
type ThemedValue struct {
	Single  string
	ByTheme map[string]string
}

// UnmarshalJSON accepts both the string and the per-theme object forms.
func (v *ThemedValue) UnmarshalJSON(data []byte) error {
	data = bytes.TrimSpace(data)
	if len(data) > 0 && data[0] == '"' {
		return json.Unmarshal(data, &v.Single)
	}

	return json.Unmarshal(data, &v.ByTheme)
}

// In returns the value for a theme, falling back to the first theme's value.
func (v ThemedValue) In(themeID, firstThemeID string) string {
	if v.Single != "" {
		return v.Single
	}
	if value, ok := v.ByTheme[themeID]; ok {
		return value
	}

	return v.ByTheme[firstThemeID]
}

// ScaleFamily is a family with one value per token (spacing, radius).
type ScaleFamily struct {
	Tokens []ScaleToken `json:"tokens"`
}

// ScaleToken is a single length token.
type ScaleToken struct {
	Name  string `json:"name"`
	Value string `json:"value"`
	Usage string `json:"usage"`
}

// TypeFamily holds font stacks and grouped text styles.
type TypeFamily struct {
	Families map[string]string `json:"families"`
	Groups   []TypeGroup       `json:"groups"`
}

// TypeGroup is a set of text styles sharing a default font family.
type TypeGroup struct {
	Name   string      `json:"name"`
	Family string      `json:"family"`
	Styles []TypeStyle `json:"styles"`
}

// TypeStyle is one named text style.
type TypeStyle struct {
	Name          string `json:"name"`
	FontSize      string `json:"fontSize"`
	LineHeight    string `json:"lineHeight"`
	FontWeight    int    `json:"fontWeight"`
	LetterSpacing string `json:"letterSpacing"`
}

var aliasPattern = regexp.MustCompile(`^\{([A-Za-z0-9][A-Za-z0-9_.-]*)\}$`)

// Load reads and validates a tokens.json file.
func Load(path string) (*File, error) {
	data, err := os.ReadFile(path)
	if err != nil {
		return nil, err
	}

	return Parse(data)
}

// Parse decodes tokens.json content and checks the parts the generators rely on.
func Parse(data []byte) (*File, error) {
	var file File
	if err := json.Unmarshal(data, &file); err != nil {
		return nil, fmt.Errorf("decode tokens: %w", err)
	}
	if len(file.Color.Themes) == 0 {
		return nil, fmt.Errorf("tokens: color.themes is empty")
	}

	known := map[string]bool{}
	for _, token := range file.Color.Tokens {
		if known[token.Name] {
			return nil, fmt.Errorf("tokens: duplicate color token %q", token.Name)
		}
		known[token.Name] = true
	}
	for _, token := range file.Color.Tokens {
		for _, theme := range file.Color.Themes {
			value := token.Value.In(theme.ID, file.firstTheme())
			if value == "" {
				return nil, fmt.Errorf("tokens: color %q has no value for theme %q", token.Name, theme.ID)
			}
			if match := aliasPattern.FindStringSubmatch(value); match != nil && !known[match[1]] {
				return nil, fmt.Errorf("tokens: color %q aliases unknown token %q", token.Name, match[1])
			}
		}
	}

	return &file, nil
}

func (f *File) firstTheme() string {
	return f.Color.Themes[0].ID
}

func (f *File) darkTheme() (string, bool) {
	for _, theme := range f.Color.Themes {
		if theme.ID == "dark" {
			return theme.ID, true
		}
	}

	return "", false
}

// resolveColor follows aliases until it reaches a literal color for a theme.
func (f *File) resolveColor(name, themeID string, depth int) (string, error) {
	if depth > 16 {
		return "", fmt.Errorf("tokens: alias chain too deep at %q", name)
	}
	for _, token := range f.Color.Tokens {
		if token.Name != name {
			continue
		}
		value := token.Value.In(themeID, f.firstTheme())
		if match := aliasPattern.FindStringSubmatch(value); match != nil {
			return f.resolveColor(match[1], themeID, depth+1)
		}

		return value, nil
	}

	return "", fmt.Errorf("tokens: unknown color %q", name)
}
