<x-docs.base-layout :title="$title" description="Laravel-first UI components you can copy, adapt, and ship without losing control of your codebase.">
    <section class="relative overflow-hidden border-b border-border bg-background">
        <div class="pointer-events-none absolute inset-x-0 top-0 z-10 h-px bg-gradient-to-r from-transparent via-border to-transparent"></div>
        <div class="docs-grid-bg pointer-events-none absolute inset-0 z-0"></div>

        <div class="container-wrapper relative z-10 px-4 py-20 lg:px-6 lg:py-28">
            <div class="mx-auto max-w-5xl text-center">
                <div class="animate-fade-in inline-flex items-center gap-2 rounded-full border border-border bg-background/80 px-4 py-1.5 text-[0.625rem] font-bold uppercase tracking-normal text-muted-foreground backdrop-blur-sm">
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-foreground opacity-50"></span>
                    Blade Components For Shipping Products
                </div>

                <h1 class="mt-7 animate-fade-in text-5xl font-normal leading-[1.06] tracking-normal text-foreground sm:text-6xl lg:text-[5.25rem]">
                    Copy the UI.<br>
                    <em class="italic text-muted-foreground">Keep the leverage.</em>
                </h1>

                <p class="mx-auto mt-6 max-w-[38rem] animate-fade-in text-base font-light leading-[1.85] text-muted-foreground sm:text-lg">
                    Velyx is a Laravel-first component system for teams that want polished interfaces without tying product work to a dependency-owned UI layer. Copy, adapt, ship.
                </p>

                <div class="mt-9 flex animate-fade-in flex-wrap justify-center gap-3">
                    <x-ui.button href="/docs/installation" size="lg" iconRight="arrow-right">Get Started</x-ui.button>
                    <x-ui.button href="/docs/components/button" variant="outline" size="lg" iconRight="arrow-right">Browse Components</x-ui.button>
                </div>

                <div class="mt-14 grid animate-fade-in overflow-hidden rounded-2xl border border-border md:grid-cols-3">
                    <div class="border-b border-border p-5 text-left md:border-b-0 md:border-r">
                        <p class="text-[0.625rem] font-bold uppercase tracking-normal text-muted-foreground">Ownership</p>
                        <p class="mt-2 text-sm font-light leading-[1.75] text-foreground">No runtime UI package between your product and your codebase.</p>
                    </div>
                    <div class="border-b border-border p-5 text-left md:border-b-0 md:border-r">
                        <p class="text-[0.625rem] font-bold uppercase tracking-normal text-muted-foreground">Stack Fit</p>
                        <p class="mt-2 text-sm font-light leading-[1.75] text-foreground">Blade, Alpine.js, Tailwind CSS v4 and Livewire from day one.</p>
                    </div>
                    <div class="p-5 text-left">
                        <p class="text-[0.625rem] font-bold uppercase tracking-normal text-muted-foreground">Ship Faster</p>
                        <p class="mt-2 text-sm font-light leading-[1.75] text-foreground">Sharp baseline, then shape every component around your product.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-border bg-muted/20">
        <div class="container-wrapper px-4 py-14 lg:px-6">
            <div class="grid gap-6 lg:grid-cols-3">
                <x-ui.card class="p-8">
                    <div class="inline-flex rounded-xl bg-primary/10 p-3 text-primary">
                        <x-lucide-copy class="h-[1.375rem] w-[1.375rem]" />
                    </div>
                    <h2 class="mt-5 text-[1.0625rem] font-semibold leading-snug tracking-normal text-foreground">Copy the component. Keep the control.</h2>
                    <p class="mt-3 text-[0.8125rem] font-light leading-7 text-muted-foreground">Pull the markup into your app, inspect every class, and evolve the component with your own product constraints.</p>
                </x-ui.card>

                <x-ui.card class="p-8">
                    <div class="inline-flex rounded-xl bg-primary/10 p-3 text-primary">
                        <x-lucide-sliders-horizontal class="h-[1.375rem] w-[1.375rem]" />
                    </div>
                    <h2 class="mt-5 text-[1.0625rem] font-semibold leading-snug tracking-normal text-foreground">Built to be edited, not protected.</h2>
                    <p class="mt-3 text-[0.8125rem] font-light leading-7 text-muted-foreground">Utility classes stay legible, component anatomy stays practical, and your design system can bend the UI.</p>
                </x-ui.card>

                <x-ui.card class="p-8">
                    <div class="inline-flex rounded-xl bg-primary/10 p-3 text-primary">
                        <x-lucide-layout-dashboard class="h-[1.375rem] w-[1.375rem]" />
                    </div>
                    <h2 class="mt-5 text-[1.0625rem] font-semibold leading-snug tracking-normal text-foreground">Made for real Laravel product work.</h2>
                    <p class="mt-3 text-[0.8125rem] font-light leading-7 text-muted-foreground">The patterns target admin panels, SaaS dashboards, settings flows, and search-heavy interfaces.</p>
                </x-ui.card>
            </div>
        </div>
    </section>

    <section class="border-b border-border bg-background">
        <div class="container-wrapper px-4 py-16 lg:px-6">
            <div class="flex flex-col gap-4 text-center">
                <p class="text-[0.625rem] font-bold uppercase tracking-normal text-muted-foreground">What You Actually Get</p>
                <h2 class="text-3xl font-semibold tracking-normal text-foreground sm:text-4xl">A Laravel UI baseline that still feels like your product</h2>
                <p class="mx-auto max-w-2xl text-[0.9375rem] leading-7 text-muted-foreground">Start from a confident component library, then shape each screen around your brand, data density, and workflow needs.</p>
            </div>

            <div class="mt-12 grid gap-5 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,0.8fr)]">
                <x-ui.card class="p-6">
                    <div class="grid gap-5 sm:grid-cols-2">
                        @foreach([
                            ['Documentation', 'Installation guides and usage patterns', 'Clear onboarding paths for adding components into Blade projects without build-process drama.'],
                            ['Components', 'A practical catalog for common product UI', 'Drawers, cards, tables, popovers, command palettes, modals, markdown viewers and more.'],
                            ['Customization', 'Classes you can actually reason about', 'No hidden abstraction tax when brand direction, spacing logic, or product states evolve.'],
                            ['Workflow', 'Faster iteration from docs to interface', 'Pick a component, paste it into the app, wire it to your data, then keep momentum.'],
                        ] as [$eyebrow, $heading, $body])
                            <div class="rounded-2xl border border-border bg-background p-5">
                                <p class="text-[0.6rem] font-bold uppercase tracking-normal text-muted-foreground">{{ $eyebrow }}</p>
                                <p class="mt-3 text-base font-semibold text-foreground">{{ $heading }}</p>
                                <p class="mt-2 text-[0.8125rem] leading-6 text-muted-foreground">{{ $body }}</p>
                            </div>
                        @endforeach
                    </div>
                </x-ui.card>

                <x-ui.card class="bg-muted/30 p-6">
                    <p class="text-[0.6rem] font-bold uppercase tracking-normal text-muted-foreground">Why Teams Reach For It</p>
                    <div class="mt-6 space-y-4">
                        @foreach([
                            ['No package lock-in', 'Your components live in your repository, where product decisions and maintenance already happen.'],
                            ['Consistent visual starting point', 'Useful defaults that still leave room for a brand with sharper visual character.'],
                            ['Laravel-native ergonomics', 'It feels like building in Laravel instead of translating a foreign component philosophy.'],
                        ] as [$heading, $body])
                            <div class="rounded-2xl border border-border bg-background px-4 py-4">
                                <p class="text-sm font-semibold text-foreground">{{ $heading }}</p>
                                <p class="mt-1 text-[0.8125rem] leading-6 text-muted-foreground">{{ $body }}</p>
                            </div>
                        @endforeach
                    </div>
                </x-ui.card>
            </div>
        </div>
    </section>

    <section class="border-t border-border bg-background">
        <div class="container-wrapper px-4 py-20 lg:px-6 lg:py-24">
            <div class="relative overflow-hidden rounded-3xl border border-border bg-card px-8 py-16 text-center md:px-16">
                <div class="docs-grid-bg pointer-events-none absolute inset-0 z-0 opacity-60"></div>
                <div class="relative z-10">
                    <x-ui.badge variant="outline" pill>Start Building</x-ui.badge>

                    <h2 class="mx-auto mt-6 max-w-2xl text-4xl font-normal leading-[1.1] tracking-normal text-foreground sm:text-5xl">
                        Build the first serious screen faster,
                        <em class="italic text-muted-foreground">then make it unmistakably yours.</em>
                    </h2>

                    <p class="mx-auto mt-5 max-w-md text-sm font-light leading-[1.85] text-muted-foreground">
                        Explore the docs, pull in the components you need, and turn Velyx into an interface layer that belongs to your product.
                    </p>

                    <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                        <x-ui.button href="/docs/installation" size="lg" iconRight="arrow-right">Read the Docs</x-ui.button>
                        <x-ui.button href="https://github.com/velyx-labs" variant="outline" size="lg" :lucide='false' icon="icons.github">View on GitHub</x-ui.button>
                    </div>

                    <p class="mt-8 text-[0.6875rem] font-light tracking-wide text-muted-foreground/60">
                        No package required - <span class="font-medium text-muted-foreground/80">components live in your repo.</span>
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-docs.base-layout>
