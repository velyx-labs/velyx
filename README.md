# Velyx

Laravel components you own, line by line.

> **Velyx v3 is in progress on this branch.** The current release (v2) lives on the `2.x` branch.

## Repository layout

| Path | What |
| --- | --- |
| `registry/components/` | One folder per component: Blade files plus a `component.json` manifest (`registry/schema/component.schema.json`). |
| `registry/themes/`, `registry/icons/` | Theme sources for the user's `velyx.css`, and the map from Velyx icon names to each icon set. |
| `registry/build/` | Generated static registry the CLI downloads (`make registry`). |
| `registry/php/` | Pest + Testbench harness that renders every component in a real Laravel app. |
| `tokens/` | Design tokens (`tokens.json`) and the generated Tailwind v4 stylesheet (`build/velyx.css`). |
| `cli/` | The Go CLI (`velyx`), plus the token generator. |
| `site/` | The website (Laravel 13, Livewire 4): landing, docs and previews. Imports `tokens/build/velyx.css` and self-hosts the fonts. |

## Using the CLI (development build)

```bash
make build
cd path/to/your-laravel-app
/path/to/velyx/bin/velyx init --registry /path/to/velyx/registry/build
/path/to/velyx/bin/velyx add button card
/path/to/velyx/bin/velyx list
```

Without `--registry`, the CLI reads the registry from this repository's `v3` branch on GitHub.

## Development

Requires Go 1.24+, and PHP 8.2+ with Composer for the component tests.

```bash
make tokens   # regenerate tokens/build/velyx.css and the CLI palette
make registry # regenerate the icon component and registry/build
make test     # run the Go tests
make test-php # render every component in Laravel (cd registry/php && composer install first)
make build    # build bin/velyx
```

The site runs like any Laravel app from `site/`:

```bash
cd site && composer install && pnpm install
cp .env.example .env && php artisan key:generate && php artisan migrate
composer run dev
```

## License

MIT
