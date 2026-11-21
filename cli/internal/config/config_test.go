package config

import (
	"errors"
	"os"
	"path/filepath"
	"testing"
)

func TestSaveAndLoadRoundTrip(t *testing.T) {
	root := t.TempDir()
	cfg := Default()
	cfg.Icons = "tabler"
	cfg.Installed["button"] = "3.0.0"
	if err := cfg.Save(root); err != nil {
		t.Fatal(err)
	}

	got, err := Load(root)
	if err != nil {
		t.Fatal(err)
	}
	if got.Icons != "tabler" || got.Installed["button"] != "3.0.0" || got.Theme.Base != "neutral" {
		t.Fatalf("round trip lost data: %+v", got)
	}
}

func TestLoadMissingFile(t *testing.T) {
	if _, err := Load(t.TempDir()); !errors.Is(err, ErrNotInitialized) {
		t.Fatalf("expected ErrNotInitialized, got %v", err)
	}
}

func TestLoadDetectsV2Config(t *testing.T) {
	root := t.TempDir()
	v2 := `{"version":"1.0.3","theme":"neutral","components":{"path":"resources/views/components/ui"}}`
	if err := os.WriteFile(filepath.Join(root, FileName), []byte(v2), 0o644); err != nil {
		t.Fatal(err)
	}
	if _, err := Load(root); !errors.Is(err, ErrV2Config) {
		t.Fatalf("expected ErrV2Config, got %v", err)
	}
}
