// Package theme builds the user's resources/css/velyx.css from
// registry/themes/themes.json: a base (greys), an accent, a radius and a font.
package theme

import (
	"encoding/json"
	"fmt"
	"os"
	"sort"
	"strings"
)

// Source is the content of themes.json.
type Source struct {
	Defaults Options                      `json:"defaults"`
	Bases    map[string]Base              `json:"bases"`
	Accents  map[string]string            `json:"accents"`
	Status   map[string]map[string]string `json:"status"`
	Radii    []string                     `json:"radii"`
	Fonts    map[string]string            `json:"fonts"`
}

// Base holds the light and dark values of one base color.
type Base struct {
	Swatch string            `json:"swatch"`
	Light  map[string]string `json:"light"`
	Dark   map[string]string `json:"dark"`
}

// Options are the choices a user makes at init or with `velyx theme set`.
type Options struct {
	Base   string `json:"base"`
	Accent string `json:"accent"`
	Radius string `json:"radius"`
	Font   string `json:"font"`
}

// Order is the order tokens are written in, matching shadcn/ui plus the Velyx status colors.
var Order = []string{
	"background", "foreground", "card", "card-foreground", "popover", "popover-foreground",
	"primary", "primary-foreground", "secondary", "secondary-foreground", "muted", "muted-foreground",
	"accent", "accent-foreground", "destructive", "destructive-foreground",
	"success", "success-foreground", "warning", "warning-foreground", "info", "info-foreground",
	"border", "input", "ring",
}

const (
	white = "oklch(0.985 0 0)"
	ink   = "oklch(0.145 0 0)"
)

// Load reads themes.json.
func Load(path string) (*Source, error) {
	data, err := os.ReadFile(path)
	if err != nil {
		return nil, err
	}

	return Parse(data)
}

// Parse decodes themes.json content.
func Parse(data []byte) (*Source, error) {
	var s Source
	if err := json.Unmarshal(data, &s); err != nil {
		return nil, fmt.Errorf("decode themes.json: %w", err)
	}

	return &s, nil
}

// Resolve fills empty options from the defaults and rejects unknown values.
func (s *Source) Resolve(o Options) (Options, error) {
	if o.Base == "" {
		o.Base = s.Defaults.Base
	}
	if o.Accent == "" {
		o.Accent = s.Defaults.Accent
	}
	if o.Radius == "" {
		o.Radius = s.Defaults.Radius
	}
	if o.Font == "" {
		o.Font = s.Defaults.Font
	}
	if _, ok := s.Bases[o.Base]; !ok {
		return o, fmt.Errorf("unknown base %q (choose from %s)", o.Base, strings.Join(keys(s.Bases), ", "))
	}
	if _, ok := s.Accents[o.Accent]; !ok && o.Accent != "neutral" {
		return o, fmt.Errorf("unknown accent %q (choose neutral or %s)", o.Accent, strings.Join(keys(s.Accents), ", "))
	}
	if _, ok := s.Fonts[o.Font]; !ok {
		return o, fmt.Errorf("unknown font %q", o.Font)
	}

	return o, nil
}

// Tokens returns every color token for one mode ("light" or "dark").
func (s *Source) Tokens(o Options, mode string) map[string]string {
	base := s.Bases[o.Base].Light
	if mode == "dark" {
		base = s.Bases[o.Base].Dark
	}
	status := s.Status[mode]
	onStatus := white
	if mode == "dark" {
		onStatus = ink
	}

	t := map[string]string{}
	for k, v := range base {
		t[k] = v
	}
	t["card-foreground"] = base["foreground"]
	t["popover"] = base["card"]
	t["popover-foreground"] = base["foreground"]
	t["accent"] = base["muted"]
	t["accent-foreground"] = base["secondary-foreground"]
	t["input"] = base["border"]
	if mode == "dark" {
		t["input"] = "oklch(1 0 0 / 15%)"
	}
	if accent, ok := s.Accents[o.Accent]; ok {
		t["primary"], t["primary-foreground"], t["ring"] = accent, white, accent
	}
	t["destructive"], t["destructive-foreground"] = status["destructive"], white
	t["success"], t["success-foreground"] = status["success"], onStatus
	t["warning"], t["warning-foreground"] = status["warning"], status["warning-foreground"]
	t["info"], t["info-foreground"] = status["info"], onStatus

	return t
}

// CSS renders velyx.css for Tailwind CSS v4.
func (s *Source) CSS(o Options) (string, error) {
	o, err := s.Resolve(o)
	if err != nil {
		return "", err
	}

	var b strings.Builder
	fmt.Fprintf(&b, "/* Velyx theme · base %s · accent %s · radius %srem. Edit freely: the CLI keeps your changes. */\n\n", o.Base, o.Accent, o.Radius)
	b.WriteString("@custom-variant dark (&:where(.dark, .dark *));\n\n")

	writeBlock := func(selector string, tokens map[string]string, extra []string) {
		fmt.Fprintf(&b, "%s {\n", selector)
		for _, line := range extra {
			fmt.Fprintf(&b, "  %s\n", line)
		}
		for _, k := range Order {
			fmt.Fprintf(&b, "  --%s: %s;\n", k, tokens[k])
		}
		b.WriteString("}\n\n")
	}
	writeBlock(":root", s.Tokens(o, "light"), []string{
		fmt.Sprintf("--radius: %srem;", o.Radius),
		fmt.Sprintf("--font-body: %s;", s.Fonts[o.Font]),
	})
	writeBlock(".dark", s.Tokens(o, "dark"), nil)

	b.WriteString("@theme inline {\n")
	for _, k := range Order {
		fmt.Fprintf(&b, "  --color-%s: var(--%s);\n", k, k)
	}
	b.WriteString("  --radius-sm: calc(var(--radius) - 4px);\n")
	b.WriteString("  --radius-md: calc(var(--radius) - 2px);\n")
	b.WriteString("  --radius-lg: var(--radius);\n")
	b.WriteString("  --radius-xl: calc(var(--radius) + 4px);\n")
	b.WriteString("  --font-sans: var(--font-body);\n")
	b.WriteString("}\n\n")
	b.WriteString("@layer base {\n  * {\n    @apply border-border outline-ring/50;\n  }\n  body {\n    @apply bg-background text-foreground;\n  }\n}\n")

	return b.String(), nil
}

func keys[V any](m map[string]V) []string {
	out := make([]string, 0, len(m))
	for k := range m {
		out = append(out, k)
	}
	sort.Strings(out)

	return out
}

// ScopedCSS renders the theme under a CSS selector instead of :root, so it can
// live next to another design system (the Velyx site previews its components
// this way). Tokens listed in fallbacks resolve to the given CSS value outside
// the scope, because the host already uses those utility names.
func (s *Source) ScopedCSS(o Options, scope string, fallbacks map[string]string) (string, error) {
	o, err := s.Resolve(o)
	if err != nil {
		return "", err
	}

	var b strings.Builder
	fmt.Fprintf(&b, "/* Generated by velyx-site-theme · base %s · accent %s · radius %srem. Do not edit. */\n\n", o.Base, o.Accent, o.Radius)

	radii := [][2]string{
		{"sm", "calc(var(--radius) - 4px)"},
		{"md", "calc(var(--radius) - 2px)"},
		{"lg", "var(--radius)"},
		{"xl", "calc(var(--radius) + 4px)"},
	}

	writeBlock := func(selector string, tokens map[string]string, extra []string) {
		fmt.Fprintf(&b, "%s {\n", selector)
		for _, line := range extra {
			fmt.Fprintf(&b, "  %s\n", line)
		}
		for _, k := range Order {
			fmt.Fprintf(&b, "  --%s: %s;\n", k, tokens[k])
		}
		b.WriteString("}\n\n")
	}
	extra := []string{fmt.Sprintf("--radius: %srem;", o.Radius)}
	for _, r := range radii {
		extra = append(extra, fmt.Sprintf("--ui-radius-%s: %s;", r[0], r[1]))
	}
	writeBlock(scope, s.Tokens(o, "light"), extra)
	writeBlock(".dark "+scope, s.Tokens(o, "dark"), nil)

	b.WriteString("@theme inline {\n")
	for _, k := range Order {
		if fallback, ok := fallbacks["color-"+k]; ok {
			fmt.Fprintf(&b, "  --color-%s: var(--%s, %s);\n", k, k, fallback)
		} else {
			fmt.Fprintf(&b, "  --color-%s: var(--%s);\n", k, k)
		}
	}
	for _, r := range radii {
		if fallback, ok := fallbacks["radius-"+r[0]]; ok {
			fmt.Fprintf(&b, "  --radius-%s: var(--ui-radius-%s, %s);\n", r[0], r[0], fallback)
		} else {
			fmt.Fprintf(&b, "  --radius-%s: var(--ui-radius-%s);\n", r[0], r[0])
		}
	}
	b.WriteString("}\n\n")

	fmt.Fprintf(&b, "@layer base {\n  %s {\n    background-color: var(--background);\n    color: var(--foreground);\n  }\n\n", scope)
	fmt.Fprintf(&b, "  :where(%s, %s *) {\n    border-color: var(--border);\n    outline-color: color-mix(in oklab, var(--ring) 50%%, transparent);\n  }\n}\n", scope, scope)

	return b.String(), nil
}
