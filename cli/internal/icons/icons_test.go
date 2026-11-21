package icons

import (
	"strings"
	"testing"
)

const repoIcons = "../../../registry/icons/icons.json"

func TestRepoMapIsComplete(t *testing.T) {
	m, err := Load(repoIcons)
	if err != nil {
		t.Fatalf("Load: %v", err)
	}
	if !m.Has("check") || !m.Has("loader") {
		t.Fatal("expected core icons check and loader")
	}
	if got := m.Component("x", "heroicons"); got != "heroicon-o-x-mark" {
		t.Fatalf("Component(x, heroicons) = %q", got)
	}
}

func TestBladeUsesTheChosenSet(t *testing.T) {
	m, err := Load(repoIcons)
	if err != nil {
		t.Fatal(err)
	}
	blade, err := m.Blade("tabler")
	if err != nil {
		t.Fatal(err)
	}
	for _, want := range []string{
		"'set' => 'tabler',",
		"'check' => ['heroicons' => 'heroicon-o-check', 'lucide' => 'lucide-check', 'phosphor' => 'phosphor-check', 'tabler' => 'tabler-check'],",
		"<x-dynamic-component :component=\"$component\"",
		"'aria-hidden' => 'true'",
	} {
		if !strings.Contains(blade, want) {
			t.Errorf("blade is missing %q", want)
		}
	}
	if _, err := m.Blade("feather"); err == nil {
		t.Fatal("expected an error for an unknown set")
	}
}

func TestValidateRejectsMissingNames(t *testing.T) {
	m := &Map{
		Default:   "lucide",
		Libraries: map[string]Library{"lucide": {Component: "lucide-{name}"}, "tabler": {Component: "tabler-{name}"}},
		Icons:     map[string]map[string]string{"check": {"lucide": "check"}},
	}
	if err := m.Validate(); err == nil || !strings.Contains(err.Error(), `"check" has no name for set "tabler"`) {
		t.Fatalf("expected a missing-name error, got %v", err)
	}
}
