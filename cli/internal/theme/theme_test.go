package theme

import (
	"strings"
	"testing"
)

const repoThemes = "../../../registry/themes/themes.json"

func load(t *testing.T) *Source {
	t.Helper()
	s, err := Load(repoThemes)
	if err != nil {
		t.Fatalf("Load: %v", err)
	}

	return s
}

func TestDefaultCSS(t *testing.T) {
	css, err := load(t).CSS(Options{})
	if err != nil {
		t.Fatal(err)
	}
	for _, want := range []string{
		"@custom-variant dark (&:where(.dark, .dark *));",
		":root {\n  --radius: 0.625rem;",
		"--primary: oklch(0.205 0 0);",
		".dark {",
		"--primary: oklch(0.922 0 0);",
		"--success:",
		"--color-primary-foreground: var(--primary-foreground);",
		"--font-sans: var(--font-body);",
		"--radius-xl: calc(var(--radius) + 4px);",
	} {
		if !strings.Contains(css, want) {
			t.Errorf("CSS is missing %q", want)
		}
	}
}

func TestAccentOverridesPrimaryAndRing(t *testing.T) {
	s := load(t)
	light := s.Tokens(Options{Base: "zinc", Accent: "blue", Radius: "0.5", Font: "Inter"}, "light")
	if light["primary"] != s.Accents["blue"] || light["ring"] != s.Accents["blue"] {
		t.Fatalf("blue accent not applied: primary=%s ring=%s", light["primary"], light["ring"])
	}
}

func TestEveryBaseFillsEveryToken(t *testing.T) {
	s := load(t)
	for base := range s.Bases {
		for _, mode := range []string{"light", "dark"} {
			tokens := s.Tokens(Options{Base: base, Accent: "neutral"}, mode)
			for _, k := range Order {
				if tokens[k] == "" {
					t.Errorf("%s/%s: token %q is empty", base, mode, k)
				}
			}
		}
	}
}

func TestResolveRejectsUnknownValues(t *testing.T) {
	s := load(t)
	if _, err := s.Resolve(Options{Base: "purple"}); err == nil {
		t.Error("expected an error for an unknown base")
	}
	if _, err := s.Resolve(Options{Accent: "teal"}); err == nil {
		t.Error("expected an error for an unknown accent")
	}
}
