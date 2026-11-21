package project

import (
	"errors"
	"os"
	"path/filepath"
	"strings"
	"testing"
)

func write(t *testing.T, root, name, body string) {
	t.Helper()
	path := filepath.Join(root, name)
	if err := os.MkdirAll(filepath.Dir(path), 0o755); err != nil {
		t.Fatal(err)
	}
	if err := os.WriteFile(path, []byte(body), 0o644); err != nil {
		t.Fatal(err)
	}
}

func TestDetectReadsLockedVersions(t *testing.T) {
	root := t.TempDir()
	write(t, root, "composer.json", `{"require":{"laravel/framework":"^12.0","livewire/livewire":"^3.6"}}`)
	write(t, root, "composer.lock", `{"packages":[{"name":"laravel/framework","version":"v12.4.1"},{"name":"livewire/livewire","version":"v3.6.2"}]}`)
	write(t, root, "package.json", `{"devDependencies":{"tailwindcss":"^4.1.0"}}`)
	write(t, root, "resources/css/app.css", `@import "tailwindcss";`)

	info, err := Detect(root)
	if err != nil {
		t.Fatal(err)
	}
	if info.Laravel != "12.4.1" || info.Livewire != "3.6.2" || info.Tailwind != "^4.1.0" || info.AppCSS != "resources/css/app.css" {
		t.Fatalf("unexpected info: %+v", info)
	}
	if p := info.Problems(); len(p) != 0 {
		t.Fatalf("expected no problems, got %v", p)
	}
}

func TestDetectRejectsNonLaravelFolders(t *testing.T) {
	root := t.TempDir()
	if _, err := Detect(root); !errors.Is(err, ErrNotLaravel) {
		t.Fatalf("empty folder: expected ErrNotLaravel, got %v", err)
	}
	write(t, root, "composer.json", `{"require":{"symfony/console":"^7.0"}}`)
	if _, err := Detect(root); !errors.Is(err, ErrNotLaravel) {
		t.Fatalf("symfony project: expected ErrNotLaravel, got %v", err)
	}
}

func TestProblemsFlagOldVersions(t *testing.T) {
	info := Info{Laravel: "10.48.0", Tailwind: "^3.4"}
	got := strings.Join(info.Problems(), " ")
	if !strings.Contains(got, "Laravel 10.48.0") || !strings.Contains(got, "Tailwind CSS ^3.4") {
		t.Fatalf("problems = %q", got)
	}
}
