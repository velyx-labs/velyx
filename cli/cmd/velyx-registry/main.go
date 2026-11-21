// Command velyx-registry regenerates the icon component from the icon map,
// validates every component and writes the static registry the CLI downloads.
// Run it from the repository root with `make registry`.
package main

import (
	"flag"
	"fmt"
	"io"
	"os"
	"path/filepath"

	"github.com/velyx-labs/velyx/cli/internal/icons"
	"github.com/velyx-labs/velyx/cli/internal/registry"
)

func main() {
	root := flag.String("root", "registry", "path to the registry folder")
	flag.Parse()

	if err := run(*root); err != nil {
		fmt.Fprintln(os.Stderr, "velyx-registry:", err)
		os.Exit(1)
	}
}

func run(root string) error {
	iconMap, err := icons.Load(filepath.Join(root, "icons", "icons.json"))
	if err != nil {
		return err
	}
	blade, err := iconMap.Blade(iconMap.Default)
	if err != nil {
		return err
	}
	if err := os.WriteFile(filepath.Join(root, "components", "icon", "icon.blade.php"), []byte(blade), 0o644); err != nil {
		return err
	}

	items, err := registry.Load(filepath.Join(root, "components"), iconMap)
	if err != nil {
		return err
	}

	out := filepath.Join(root, "build")
	if err := registry.Write(out, items); err != nil {
		return err
	}
	for _, name := range []string{"themes/themes.json", "icons/icons.json"} {
		if err := copyFile(filepath.Join(root, name), filepath.Join(out, filepath.Base(name))); err != nil {
			return err
		}
	}
	fmt.Printf("velyx-registry: %d components written to %s\n", len(items), out)

	return nil
}

func copyFile(from, to string) error {
	src, err := os.Open(from)
	if err != nil {
		return err
	}
	defer src.Close()
	dst, err := os.Create(to)
	if err != nil {
		return err
	}
	defer dst.Close()
	_, err = io.Copy(dst, src)

	return err
}
