// Package app wires the CLI commands: init, add, list and version.
package app

import (
	"errors"
	"flag"
	"fmt"
	"io"
	"os"
	"os/exec"
	"strings"

	"github.com/velyx-labs/velyx/cli/internal/ui"
)

// Runner runs an external command (composer) in a folder.
type Runner func(dir, name string, args ...string) error

// App holds everything a command needs, so tests can swap the terminal and the runner.
type App struct {
	Version     string
	Out         io.Writer
	Err         io.Writer
	Interactive bool
	Run         Runner
	Getwd       func() (string, error)
}

// New returns an App bound to the real terminal.
func New(version string) *App {
	stat, _ := os.Stdin.Stat()
	interactive := stat != nil && stat.Mode()&os.ModeCharDevice != 0

	return &App{
		Version:     version,
		Out:         os.Stdout,
		Err:         os.Stderr,
		Interactive: interactive,
		Run: func(dir, name string, args ...string) error {
			cmd := exec.Command(name, args...)
			cmd.Dir, cmd.Stdout, cmd.Stderr = dir, os.Stdout, os.Stderr
			return cmd.Run()
		},
		Getwd: os.Getwd,
	}
}

const usage = `Usage: velyx <command> [options]

Commands:
  init                 Set up Velyx in this Laravel project
  add <component>...   Copy components and their dependencies into the project
  list                 Show available components and what is installed
  version              Print the CLI version

Run velyx <command> --help for the options of a command.
`

// Main runs one command line and returns the exit code.
func (a *App) Main(args []string) int {
	if len(args) == 0 {
		fmt.Fprint(a.Out, usage)
		return 0
	}

	var err error
	switch args[0] {
	case "init":
		err = a.Init(args[1:])
	case "add":
		err = a.Add(args[1:])
	case "list", "ls":
		err = a.List(args[1:])
	case "version", "--version", "-v":
		fmt.Fprintf(a.Out, "velyx %s\n", a.Version)
	case "help", "--help", "-h":
		fmt.Fprint(a.Out, usage)
	default:
		err = fmt.Errorf("unknown command %q\n\n%s", args[0], usage)
	}

	if errors.Is(err, flag.ErrHelp) {
		return 0
	}
	if err != nil {
		fmt.Fprintln(a.Err, ui.Bad.Render("✕")+" "+err.Error())
		return 1
	}

	return 0
}

// parse lets flags appear before or after positional arguments.
func parse(fs *flag.FlagSet, args []string) ([]string, error) {
	var flags, rest []string
	for i := 0; i < len(args); i++ {
		arg := args[i]
		if !strings.HasPrefix(arg, "-") {
			rest = append(rest, arg)
			continue
		}
		flags = append(flags, arg)
		name := strings.TrimLeft(arg, "-")
		if f := fs.Lookup(name); f != nil && !strings.Contains(name, "=") {
			if _, isBool := f.Value.(interface{ IsBoolFlag() bool }); !isBool && i+1 < len(args) {
				flags = append(flags, args[i+1])
				i++
			}
		}
	}
	if err := fs.Parse(flags); err != nil {
		return nil, err
	}

	return rest, nil
}

func (a *App) header(detail string) {
	fmt.Fprintf(a.Out, "%s %s\n", ui.Bold.Render(ui.Mark+" velyx"), ui.Faint.Render(a.Version))
	if detail != "" {
		fmt.Fprintln(a.Out, "  "+ui.Faint.Render(detail))
	}
	fmt.Fprintln(a.Out)
}

func (a *App) root(dir string) (string, error) {
	if dir != "" {
		return dir, nil
	}

	return a.Getwd()
}
