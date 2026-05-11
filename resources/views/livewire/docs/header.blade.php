<header class="sticky top-0 z-50 w-full border-b border-border/40 bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/80" style="--header-height: 4rem;">
    <div class="container-wrapper px-4 lg:px-6">
        <div class="flex h-16 items-center gap-4">
            <div class="flex min-w-0 items-center gap-4 lg:gap-8">
                <a href="{{ route('home') }}" class="group flex items-center gap-2.5 font-bold text-foreground transition-colors hover:text-primary">
                    <img class="h-7 w-7 transition-transform duration-300 group-hover:rotate-6 dark:hidden" src="/assets/img/logo.svg" alt="Velyx logo" width="28" height="28">
                    <img class="hidden h-7 w-7 transition-transform duration-300 group-hover:rotate-6 dark:block" src="/assets/img/logo-dark.svg" alt="Velyx logo" width="28" height="28">
                    <span class="text-[15px] tracking-tight sm:text-[17px]">Velyx</span>
                    <span class="ml-0.5 hidden rounded-full border border-border bg-muted/70 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-widest text-muted-foreground sm:inline-flex">
                        Copy. Adapt. Ship.
                    </span>
                </a>

                <nav class="hidden items-center gap-1 text-sm font-medium md:flex" aria-label="Main navigation">
                    <a href="{{ route('docs.page', 'installation') }}" class="rounded-md px-3 py-1.5 text-muted-foreground transition-colors hover:bg-muted/60 hover:text-foreground">Get Started</a>
                    <a href="{{ route('docs.page', 'components') }}" class="rounded-md px-3 py-1.5 text-muted-foreground transition-colors hover:bg-muted/60 hover:text-foreground">Component Library</a>
                    <a href="https://github.com/velyx-labs" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-md px-3 py-1.5 text-muted-foreground transition-colors hover:bg-muted/60 hover:text-foreground">
                        <x-icons.github class="h-4 w-4 text-foreground" />
                        GitHub
                    </a>
                    <a href="https://gvcjmaad.mychariow.shop/velyx-dev" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-md px-3 py-1.5 text-muted-foreground transition-colors hover:bg-muted/60 hover:text-foreground">
                        <x-lucide-heart class="h-4 w-4 text-red-600" />
                        Support
                    </a>
                </nav>
            </div>

            <div class="ml-auto flex items-center gap-2 md:flex-1 md:justify-end">
                <button
                    type="button"
                    class="dark-mode-toggle inline-flex h-9 w-9 items-center justify-center rounded-md border border-border bg-background text-muted-foreground transition-colors hover:bg-muted hover:text-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                    aria-label="Toggle dark mode"
                >
                    <x-lucide-sun class="h-[1.1rem] w-[1.1rem] dark:hidden" />
                    <x-lucide-moon class="hidden h-[1.1rem] w-[1.1rem] dark:block" />
                </button>

                <x-ui.button href="{{ route('docs.page', 'installation') }}" class="hidden md:inline-flex" size="sm" iconRight="arrow-right">
                    Start Building
                </x-ui.button>

                <button
                    type="button"
                    wire:click="toggleMobileNavigation"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-border bg-background text-muted-foreground transition-colors hover:bg-muted hover:text-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 md:hidden"
                    aria-label="Toggle navigation"
                >
                    @if($mobileNavigationOpen)
                        <x-lucide-x class="h-4 w-4" />
                    @else
                        <x-lucide-menu class="h-4 w-4" />
                    @endif
                </button>
            </div>
        </div>

        @if($mobileNavigationOpen)
            <div class="border-t border-border py-4 md:hidden">
                <nav class="grid gap-2 text-sm">
                    <a wire:click="closeMobileNavigation" href="{{ route('docs.page', 'installation') }}" class="rounded-md px-3 py-2 text-muted-foreground hover:bg-muted hover:text-foreground">Get Started</a>
                    <a wire:click="closeMobileNavigation" href="{{ route('docs.page', 'components') }}" class="rounded-md px-3 py-2 text-muted-foreground hover:bg-muted hover:text-foreground">Component Library</a>
                    <a wire:click="closeMobileNavigation" href="https://gvcjmaad.mychariow.shop/velyx-dev" class="rounded-md px-3 py-2 text-muted-foreground hover:bg-muted hover:text-foreground">Support</a>
                    <a wire:click="closeMobileNavigation" href="{{ route('components.index') }}" class="rounded-md px-3 py-2 text-muted-foreground hover:bg-muted hover:text-foreground">Registry API</a>
                </nav>
            </div>
        @endif
    </div>
</header>
