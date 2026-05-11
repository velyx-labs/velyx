<footer class="border-t border-border/60 bg-background" role="contentinfo">
    <div class="container-wrapper px-4 py-10 lg:px-6 lg:py-14">
        <div class="relative overflow-hidden rounded-3xl border border-border/60 bg-muted/30">
            <div class="relative grid gap-10 px-6 py-8 md:px-8 lg:grid-cols-[minmax(0,1.25fr)_minmax(0,0.75fr)] lg:px-10 lg:py-10">
                <div class="max-w-xl">
                    <a href="/" class="inline-flex items-center gap-3 text-foreground transition-colors hover:text-primary">
                        <img class="h-9 w-9 rounded-xl border border-border/60 bg-background/80 p-1.5 shadow-sm dark:hidden" src="/assets/img/logo.svg" alt="Velyx logo" width="36" height="36">
                        <img class="hidden h-9 w-9 rounded-xl border border-border/60 bg-background/80 p-1.5 shadow-sm dark:block" src="/assets/img/logo-dark.svg" alt="Velyx logo" width="36" height="36">
                        <span class="text-lg font-semibold">Velyx</span>
                    </a>

                    <p class="mt-5 max-w-lg text-sm leading-7 text-muted-foreground sm:text-base">
                        Copy the component, adapt the markup, and ship Laravel interfaces that still feel like your product instead of someone else's package.
                    </p>

                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        <x-ui.button href="/docs/installation" iconRight="arrow-right">Start Building</x-ui.button>
                        <x-ui.button href="https://github.com/velyx-labs" variant="outline" icon="github">GitHub</x-ui.button>
                    </div>
                </div>

                <div class="grid gap-8 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-normal text-muted-foreground">Explore</p>
                        <div class="mt-4 flex flex-col gap-3 text-sm">
                            <a href="/docs/installation" class="text-muted-foreground transition-colors hover:text-foreground">Get Started</a>
                            <a href="/docs/components/button" class="text-muted-foreground transition-colors hover:text-foreground">Component Library</a>
                            <a href="/" class="text-muted-foreground transition-colors hover:text-foreground">Homepage</a>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-normal text-muted-foreground">Community</p>
                        <div class="mt-4 flex flex-col gap-3 text-sm">
                            <a href="https://github.com/velyx-labs" target="_blank" rel="noopener noreferrer" class="text-muted-foreground transition-colors hover:text-foreground">GitHub</a>
                            <a href="https://x.com/velyxdev" target="_blank" rel="noopener noreferrer" class="text-muted-foreground transition-colors hover:text-foreground">X</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 flex flex-col gap-3 border-t border-border/50 pt-5 text-xs text-muted-foreground sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ date('Y') }} Velyx. Laravel UI components for teams that want speed without losing ownership.</p>
            <p>Inspired by <a href="https://ui.shadcn.com" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-foreground">shadcn/ui</a></p>
        </div>
    </div>
</footer>
