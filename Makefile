.PHONY: tokens test vet build check-generated

GO := cd cli && go

# Regenerate tokens/build/velyx.css and cli/internal/ui/palette_gen.go.
tokens:
	$(GO) run ./cmd/velyx-tokens -in ../tokens/tokens.json -css ../tokens/build/velyx.css -go internal/ui/palette_gen.go

test:
	$(GO) test ./...

vet:
	$(GO) vet ./...

build:
	$(GO) build -o ../bin/velyx ./cmd/velyx

# Fails when generated files are out of date with tokens.json.
check-generated: tokens
	git diff --exit-code -- tokens/build cli/internal/ui
