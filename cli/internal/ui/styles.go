package ui

import "github.com/charmbracelet/lipgloss"

func adaptive(c Color) lipgloss.AdaptiveColor {
	return lipgloss.AdaptiveColor{Light: c.Light, Dark: c.Dark}
}

// Styles used by every command. Colors come from the Velyx tokens.
var (
	Bold  = lipgloss.NewStyle().Bold(true).Foreground(adaptive(Ink))
	Faint = lipgloss.NewStyle().Foreground(adaptive(InkSubtle))
	Mono  = lipgloss.NewStyle().Foreground(adaptive(Ink))
	Ok    = lipgloss.NewStyle().Foreground(adaptive(Success))
	Bad   = lipgloss.NewStyle().Foreground(adaptive(Danger))
)

// Mark is the Velyx glyph shown before the product name.
const Mark = "◆"
