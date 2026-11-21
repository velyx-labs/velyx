<footer class="border-t border-border bg-surface">
    <div class="mx-auto flex max-w-[1200px] flex-col gap-9 px-4 pt-12 pb-8 sm:px-8">
        <div class="flex flex-wrap justify-between gap-10">
            <div class="flex max-w-[300px] flex-col gap-3">
                <x-logo />
                <p class="text-control text-ink-muted">Laravel components you own, line by line.</p>
                <div class="flex gap-1.5">
                    <x-site.button variant="outline" size="icon" href="https://github.com/velyx-labs/velyx" aria-label="GitHub">
                        <x-icons.github class="size-4" />
                    </x-site.button>
                    <x-site.button variant="outline" size="icon" href="https://buymeacoffee.com/jiordiviera" aria-label="Buy Me a Coffee">
                        <x-icons.buy-me-a-coffee class="h-4 w-auto" />
                    </x-site.button>
                </div>
            </div>

            <div class="flex flex-wrap gap-14 text-control">
                <div class="flex flex-col gap-2.5">
                    <x-site.label>Product</x-site.label>
                    <a href="{{ route('docs.components') }}" class="text-ink-muted hover:text-ink">Components</a>
                    <a href="{{ route('docs.guide', 'cli') }}" class="text-ink-muted hover:text-ink">CLI</a>
                    <a href="{{ route('docs.guide', 'icons') }}" class="text-ink-muted hover:text-ink">Icons</a>
                    <a href="https://github.com/velyx-labs/velyx/releases" class="text-ink-muted hover:text-ink">Changelog</a>
                </div>
                <div class="flex flex-col gap-2.5">
                    <x-site.label>Resources</x-site.label>
                    <a href="{{ route('docs') }}" class="text-ink-muted hover:text-ink">Documentation</a>
                    <a href="https://github.com/velyx-labs/velyx" class="text-ink-muted hover:text-ink">GitHub</a>
                    <a href="https://buymeacoffee.com/jiordiviera" class="text-ink-muted hover:text-ink">Buy Me a Coffee</a>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap justify-between gap-3 border-t border-border pt-5 text-small text-ink-subtle">
            <span>MIT License</span>
            <span>
                Looking for v2?
                <a href="https://github.com/velyx-labs/velyx/tree/2.x" class="text-ink underline underline-offset-[3px]">v2 documentation</a>
            </span>
        </div>
    </div>
</footer>
