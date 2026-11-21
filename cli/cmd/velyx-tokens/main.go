// Command velyx-tokens generates the token stylesheet and the CLI palette
// from tokens/tokens.json. Run it from the repository root with `make tokens`.
package main

import (
	"flag"
	"fmt"
	"os"
	"path/filepath"

	"github.com/velyx-labs/velyx/cli/internal/tokens"
)

func main() {
	in := flag.String("in", "tokens/tokens.json", "path to tokens.json")
	cssOut := flag.String("css", "tokens/build/velyx.css", "output path for the Tailwind v4 stylesheet")
	goOut := flag.String("go", "cli/internal/ui/palette_gen.go", "output path for the Go palette")
	flag.Parse()

	if err := run(*in, *cssOut, *goOut); err != nil {
		fmt.Fprintln(os.Stderr, "velyx-tokens:", err)
		os.Exit(1)
	}
}

func run(in, cssOut, goOut string) error {
	file, err := tokens.Load(in)
	if err != nil {
		return err
	}

	palette, err := file.GoPalette("ui")
	if err != nil {
		return err
	}

	if err := write(cssOut, []byte(file.CSS())); err != nil {
		return err
	}

	return write(goOut, palette)
}

func write(path string, data []byte) error {
	if err := os.MkdirAll(filepath.Dir(path), 0o755); err != nil {
		return err
	}

	return os.WriteFile(path, data, 0o644)
}
