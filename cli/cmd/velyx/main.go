// Command velyx is the Velyx CLI. Commands land in later steps; for now it
// only reports its version so the build and release pipeline can be wired.
package main

import (
	"fmt"
	"os"
)

// version is set at build time with -ldflags "-X main.version=...".
var version = "3.0.0-dev"

func main() {
	if len(os.Args) > 1 && (os.Args[1] == "--version" || os.Args[1] == "version") {
		fmt.Println("velyx", version)
		return
	}

	fmt.Fprintln(os.Stderr, "velyx", version, "- commands are not implemented yet. Try `velyx --version`.")
	os.Exit(1)
}
