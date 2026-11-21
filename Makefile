.PHONY: tokens registry site-theme site-components test test-php vet build check-generated

GO := cd cli && go

# Regenerate tokens/build/velyx.css and cli/internal/ui/palette_gen.go.
tokens:
	$(GO) run ./cmd/velyx-tokens -in ../tokens/tokens.json -css ../tokens/build/velyx.css -go internal/ui/palette_gen.go

# Regenerate the icon component and the static registry in registry/build.
registry:
	$(GO) run ./cmd/velyx-registry -root ../registry

# Regenerate the component theme the site uses for its live previews.
site-theme:
	$(GO) run ./cmd/velyx-site-theme

# Reinstall every registry component into the site with the CLI itself.
site-components: build
	cd site && ../bin/velyx add $(notdir $(wildcard registry/components/*)) --yes --overwrite --no-composer

test:
	$(GO) test ./...

# Render every registry component inside a real Laravel app (needs composer install in registry/php).
test-php:
	cd registry/php && vendor/bin/pest --compact

vet:
	$(GO) vet ./...

build:
	$(GO) build -o ../bin/velyx ./cmd/velyx

# Fails when generated files are out of date with tokens.json.
check-generated: tokens registry site-theme site-components
	git diff --exit-code -- tokens/build cli/internal/ui registry/build registry/components/icon site/resources/css/ui-theme.css site/resources/views/components/ui site/velyx.json
