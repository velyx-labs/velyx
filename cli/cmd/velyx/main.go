// Command velyx is the Velyx CLI: it copies Laravel components into your project.
package main

import (
	"os"

	"github.com/velyx-labs/velyx/cli/internal/app"
)

// version is set at build time with -ldflags "-X main.version=...".
var version = "3.0.0-dev"

func main() {
	os.Exit(app.New(version).Main(os.Args[1:]))
}
