# velyx

## 2.1.3

### Patch Changes

- Add velyx component dependency resolution — components can now declare other velyx components as dependencies via `requires.velyx` in meta.json; they are auto-installed recursively before the parent component

## 2.1.2

### Patch Changes

- Migrate color themes to OKLCH, add mauve/olive/mist/taupe palettes, fix concurrent spinners, set neutral as default theme selection

## 2.1.1

### Patch Changes

- Fix registry URL not resolving for published CLI builds and improve network error messages.

  The production registry URL was not being inlined at build time, causing the CLI to fall back to `http://velyx.test/api/v1` (a dev-only local domain) when run outside the development environment. The URL is now baked into the bundle via esbuild's `define` option.

  Also removed a stray debug `console.log`, improved `NetworkError` messages to include the target URL and the underlying system error (e.g. `ENOTFOUND`, `ECONNREFUSED`), and added contextual hints in the error handler.

## 2.1.0

### Minor Changes

- Add four new components: Checkbox, Separator, Field, and Empty (renamed from empty-state). Refactor all existing components (button, badge, alert, avatar, avatar-group, card, accordion, input, label, skeleton, table) to shadcn/ui style with `data-slot` attributes and Blade sub-component composition. Replace iframe-based doc previews with inline rendering.

## 2.0.2

### Patch Changes

- Ask user to override existing velyx.css theme file

  When running `velyx init`, if a velyx.css file already exists, the CLI will now ask the user if they want to overwrite it with the current theme or
  keep the existing file.

  Also fixed EEXIST error when overwriting existing files.

## 2.0.1

### Patch Changes

- 69e4a23: Add Tailwind CSS v4 @theme inline support to theme generation

## 2.0.0

### Major Changes

- Initial release of velyx CLI
