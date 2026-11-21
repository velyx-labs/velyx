// Package project inspects a Laravel project: framework versions and the main stylesheet.
package project

import (
	"encoding/json"
	"errors"
	"fmt"
	"os"
	"path/filepath"
	"regexp"
	"strconv"
	"strings"
)

// Info is what `velyx init` needs to know about a project.
type Info struct {
	Root     string
	Laravel  string
	Livewire string
	Tailwind string
	AppCSS   string
}

// Minimum versions supported by Velyx 3.
const (
	MinLaravel  = 10
	MinTailwind = 4
)

// ErrNotLaravel means the folder is not the root of a Laravel project.
var ErrNotLaravel = errors.New("no Laravel project here: composer.json does not require laravel/framework. Run velyx from your project root")

// Detect reads composer.json, composer.lock and package.json in root.
func Detect(root string) (Info, error) {
	info := Info{Root: root}

	var composer struct {
		Require map[string]string `json:"require"`
	}
	if err := readJSON(filepath.Join(root, "composer.json"), &composer); err != nil {
		if errors.Is(err, os.ErrNotExist) {
			return info, ErrNotLaravel
		}
		return info, err
	}
	if _, ok := composer.Require["laravel/framework"]; !ok {
		return info, ErrNotLaravel
	}
	info.Laravel = composer.Require["laravel/framework"]
	info.Livewire = composer.Require["livewire/livewire"]

	var lock struct {
		Packages []struct {
			Name    string `json:"name"`
			Version string `json:"version"`
		} `json:"packages"`
	}
	if err := readJSON(filepath.Join(root, "composer.lock"), &lock); err == nil {
		for _, p := range lock.Packages {
			switch p.Name {
			case "laravel/framework":
				info.Laravel = strings.TrimPrefix(p.Version, "v")
			case "livewire/livewire":
				info.Livewire = strings.TrimPrefix(p.Version, "v")
			}
		}
	}

	var pkg struct {
		Dependencies    map[string]string `json:"dependencies"`
		DevDependencies map[string]string `json:"devDependencies"`
	}
	if err := readJSON(filepath.Join(root, "package.json"), &pkg); err == nil {
		info.Tailwind = pkg.DevDependencies["tailwindcss"]
		if info.Tailwind == "" {
			info.Tailwind = pkg.Dependencies["tailwindcss"]
		}
	}

	if _, err := os.Stat(filepath.Join(root, "resources", "css", "app.css")); err == nil {
		info.AppCSS = "resources/css/app.css"
	}

	return info, nil
}

// Problems lists the requirements the project does not meet, in plain words.
func (i Info) Problems() []string {
	var out []string
	if major(i.Laravel) > 0 && major(i.Laravel) < MinLaravel {
		out = append(out, fmt.Sprintf("Laravel %s found; Velyx 3 needs Laravel %d or newer.", i.Laravel, MinLaravel))
	}
	if i.Tailwind == "" {
		out = append(out, "Tailwind CSS is not in package.json; Velyx 3 needs Tailwind CSS 4.")
	} else if major(i.Tailwind) > 0 && major(i.Tailwind) < MinTailwind {
		out = append(out, fmt.Sprintf("Tailwind CSS %s found; Velyx 3 needs Tailwind CSS %d.", i.Tailwind, MinTailwind))
	}

	return out
}

var firstNumber = regexp.MustCompile(`\d+`)

// major extracts the major version from a version or constraint such as "^12.4" or "v4.1.0".
func major(v string) int {
	n, err := strconv.Atoi(firstNumber.FindString(v))
	if err != nil {
		return 0
	}

	return n
}

func readJSON(path string, v any) error {
	data, err := os.ReadFile(path)
	if err != nil {
		return err
	}
	if err := json.Unmarshal(data, v); err != nil {
		return fmt.Errorf("read %s: %w", filepath.Base(path), err)
	}

	return nil
}
