# Velyx

Laravel components you own, line by line.

> **Velyx v3 is in progress on this branch.** The current release (v2) lives on the `2.x` branch.

## Repository layout

| Path | What |
| --- | --- |
| `registry/` | Components as data: one folder per component with a `component.json` manifest (`registry/schema/component.schema.json`). |
| `tokens/` | Design tokens (`tokens.json`) and the generated Tailwind v4 stylesheet (`build/velyx.css`). |
| `cli/` | The Go CLI (`velyx`), plus the token generator. |
| `site/` | The website: landing, docs and previews (coming next). |

## Development

Requires Go 1.24+.

```bash
make tokens   # regenerate tokens/build/velyx.css and the CLI palette
make test     # run the Go tests
make build    # build bin/velyx
```

## License

MIT
