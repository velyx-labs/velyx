// Command velyx-site-theme writes the component theme used by the site's live
// previews, scoped to .velyx-preview so it does not replace the site identity.
package main

import (
	"flag"
	"fmt"
	"os"
	"regexp"

	"github.com/velyx-labs/velyx/cli/internal/theme"
)

func main() {
	themes := flag.String("themes", "../registry/themes/themes.json", "themes.json")
	site := flag.String("site-tokens", "../tokens/build/velyx.css", "the site stylesheet, to find utility names it already uses")
	out := flag.String("out", "../site/resources/css/ui-theme.css", "output file")
	flag.Parse()

	if err := run(*themes, *site, *out); err != nil {
		fmt.Fprintln(os.Stderr, "velyx-site-theme:", err)
		os.Exit(1)
	}
}

func run(themesPath, sitePath, out string) error {
	src, err := theme.Load(themesPath)
	if err != nil {
		return err
	}
	siteCSS, err := os.ReadFile(sitePath)
	if err != nil {
		return err
	}

	fallbacks := map[string]string{}
	for _, m := range regexp.MustCompile(`--((?:color|radius)-[a-z-]+): var\((--velyx-[a-z-]+)\);`).FindAllSubmatch(siteCSS, -1) {
		fallbacks[string(m[1])] = "var(" + string(m[2]) + ")"
	}

	css, err := src.ScopedCSS(theme.Options{}, ".velyx-preview", fallbacks)
	if err != nil {
		return err
	}

	return os.WriteFile(out, []byte(css), 0o644)
}
