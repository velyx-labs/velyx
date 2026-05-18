# velyx

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
