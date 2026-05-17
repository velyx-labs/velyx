# Releases & Versioning

Velyx Registry follows [Semantic Versioning](https://semver.org/) for all releases.

## Version Format

`vMAJOR.MINOR.PATCH`

- **MAJOR**: Breaking changes to API or component contracts
- **MINOR**: New features, non-breaking additions
- **PATCH**: Bug fixes, documentation updates, internal improvements

## Release Process

### 1. Prepare Release

- Update version in relevant files
- Review changelog entries
- Ensure all tests pass: `php artisan test --compact`
- Format code: `vendor/bin/pint --dirty --format agent`

### 2. Create Release Tag

```bash
git tag -a vX.Y.Z -m "Release description"
git push origin vX.Y.Z
```

### 3. Create GitHub Release

- Go to [Releases](https://github.com/velyx-labs/registry/releases)
- Click "Create a new release"
- Select the tag
- Add release notes and changelog
- Publish release

## Current Releases

### v1.0.0 (Current)

Initial release with:
- Landing page improvements
- Full Livewire SPA migration
- Docs components (Header, Footer)
- wire:navigate navigation
- Enhanced installation documentation
- Template system for PRs and issues

## Contributing

When submitting PRs:
- Reference related issues with `Closes #123`
- Follow the PR template
- Ensure tests pass before requesting review
- Provide clear commit messages

See [CONTRIBUTING.md](CONTRIBUTING.md) for detailed guidelines.
