package registry

import (
	"encoding/json"
	"os"
	"reflect"
	"strings"
	"testing"
)

func TestParseManifestAcceptsExample(t *testing.T) {
	data, err := os.ReadFile("testdata/dialog.json")
	if err != nil {
		t.Fatal(err)
	}

	manifest, err := ParseManifest(data)
	if err != nil {
		t.Fatalf("ParseManifest: %v", err)
	}
	if manifest.Name != "dialog" || manifest.Dependencies.Components[0] != "button" {
		t.Fatalf("unexpected manifest: %+v", manifest)
	}
}

func TestParseManifestRejectsUnknownKeys(t *testing.T) {
	_, err := ParseManifest([]byte(`{"name":"a","version":"1.0.0","description":"x","files":[{"path":"a","target":"a"}],"extra":true}`))
	if err == nil || !strings.Contains(err.Error(), "unknown field") {
		t.Fatalf("expected unknown field error, got %v", err)
	}
}

func TestValidateReportsEveryProblem(t *testing.T) {
	manifest := Manifest{
		Name:         "Bad Name",
		Version:      "1.0",
		Files:        []File{{Path: "../escape.php", Target: "/abs.php"}},
		Dependencies: Dependencies{Components: []string{"Bad Name"}},
	}

	err := manifest.Validate()
	if err == nil {
		t.Fatal("expected validation errors")
	}
	for _, want := range []string{"name", "version", "description is required", "files[0].path", "files[0].target", "itself"} {
		if !strings.Contains(err.Error(), want) {
			t.Errorf("error is missing %q:\n%v", want, err)
		}
	}
}

func TestSchemaRequiredMatchesGo(t *testing.T) {
	data, err := os.ReadFile("../../../registry/schema/component.schema.json")
	if err != nil {
		t.Fatal(err)
	}

	var schema struct {
		Required []string `json:"required"`
	}
	if err := json.Unmarshal(data, &schema); err != nil {
		t.Fatalf("schema is not valid JSON: %v", err)
	}
	if !reflect.DeepEqual(schema.Required, RequiredFields) {
		t.Fatalf("schema required %v != Go RequiredFields %v", schema.Required, RequiredFields)
	}
}
