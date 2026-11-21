package tokens

import (
	"strings"
	"testing"
)

const repoTokens = "../../../tokens/tokens.json"

func loadRepoTokens(t *testing.T) *File {
	t.Helper()
	file, err := Load(repoTokens)
	if err != nil {
		t.Fatalf("load %s: %v", repoTokens, err)
	}

	return file
}

func TestCSSHasLightDarkAndThemeBlocks(t *testing.T) {
	css := loadRepoTokens(t).CSS()

	for _, want := range []string{
		"--velyx-brand: #2e3beb;",
		"--velyx-brand: #8b93ff;",
		"--velyx-focus: var(--velyx-brand);",
		".dark,\n[data-theme=\"dark\"] {",
		"@media (prefers-color-scheme: dark)",
		"@theme inline {",
		"--color-brand: var(--velyx-brand);",
		"--radius-md: var(--velyx-radius-md);",
		"--font-display: var(--velyx-font-display);",
		"--text-heading-1: 36px;",
		"--text-heading-1--line-height: 42px;",
	} {
		if !strings.Contains(css, want) {
			t.Errorf("CSS is missing %q", want)
		}
	}
}

func TestDarkBlockOnlyOverridesChangedTokens(t *testing.T) {
	css := loadRepoTokens(t).CSS()
	dark := css[strings.Index(css, ".dark,"):strings.Index(css, "@theme inline")]

	if strings.Contains(dark, "--velyx-marker:") {
		t.Error("marker is the same in both themes and should not be overridden in dark")
	}
	if !strings.Contains(dark, "--velyx-ink: #eef0f6;") {
		t.Error("dark block should override ink")
	}
}

func TestCSSIsDeterministic(t *testing.T) {
	file := loadRepoTokens(t)
	if file.CSS() != file.CSS() {
		t.Fatal("CSS output changed between two runs")
	}
}

func TestGoPaletteResolvesAliases(t *testing.T) {
	source, err := loadRepoTokens(t).GoPalette("ui")
	if err != nil {
		t.Fatalf("GoPalette: %v", err)
	}

	got := string(source)
	for _, want := range []string{
		"package ui",
		`Brand = Color{Light: "#2e3beb", Dark: "#8b93ff"}`,
		`Focus = Color{Light: "#2e3beb", Dark: "#8b93ff"}`,
		`SurfaceRaised = Color{`,
	} {
		if !strings.Contains(got, want) {
			t.Errorf("palette is missing %q", want)
		}
	}
}

func TestParseRejectsUnknownAlias(t *testing.T) {
	_, err := Parse([]byte(`{"color":{"themes":[{"id":"light"}],"tokens":[{"name":"focus","value":"{missing}"}]}}`))
	if err == nil || !strings.Contains(err.Error(), "unknown token") {
		t.Fatalf("expected unknown alias error, got %v", err)
	}
}

func TestParseRejectsDuplicateColor(t *testing.T) {
	_, err := Parse([]byte(`{"color":{"themes":[{"id":"light"}],"tokens":[{"name":"ink","value":"#000"},{"name":"ink","value":"#111"}]}}`))
	if err == nil || !strings.Contains(err.Error(), "duplicate") {
		t.Fatalf("expected duplicate error, got %v", err)
	}
}
