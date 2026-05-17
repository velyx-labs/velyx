<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
    <section class="relative overflow-hidden border-b border-border bg-background">
        <div class="pointer-events-none absolute inset-x-0 top-0 z-10 h-px bg-linear-to-r from-transparent via-border to-transparent"></div>

        <div class="pointer-events-none absolute inset-0 z-0"
             style="background-image: linear-gradient(to right, var(--border) 1px, transparent 1px), linear-gradient(to bottom, var(--border) 1px, transparent 1px); background-size: 72px 72px; mask-image: radial-gradient(ellipse 85% 55% at 50% 0%, black 10%, transparent 100%); -webkit-mask-image: radial-gradient(ellipse 85% 55% at 50% 0%, black 10%, transparent 100%);"></div>

        <div class="pointer-events-none absolute inset-0 z-0">
            <div class="absolute left-1/2 top-0 h-64 w-160 -translate-x-1/2 rounded-full bg-foreground/4 blur-3xl"></div>
            <div class="absolute right-[6%] top-12 h-52 w-52 rounded-full bg-foreground/2.5 blur-3xl"></div>
        </div>

        <div class="container-wrapper relative z-10 px-4 py-20 lg:px-6 lg:py-28">
            <div class="mx-auto max-w-5xl text-center">
                <div class="animate-fade-in inline-flex items-center gap-2.5 rounded-full border border-border bg-primary/5 px-4 py-2 text-[0.625rem] font-semibold uppercase tracking-wide text-foreground backdrop-blur-sm">
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-foreground"></span>
                    Blade Components For Product Teams
                </div>

                <h1 class="mt-8 animate-fade-in text-5xl font-semibold leading-[1.1] tracking-tight text-foreground sm:text-6xl lg:text-[5.25rem]">
                    Copy the UI.<br>
                    <em class="italic font-normal text-muted-foreground">Keep the control.</em>
                </h1>

                <p class="mx-auto mt-6 max-w-2xl animate-fade-in text-base font-light leading-relaxed text-muted-foreground sm:text-lg">
                    A Laravel-first component library built for teams shipping real products. Get polished, production-ready Blade components you own, modify, and control — no dependency lock-in.
                </p>

                <div class="mt-9 flex animate-fade-in flex-wrap justify-center gap-3">
                    <x-ui.button href="{{ route('docs.page', 'installation') }}" wire:navigate iconRight="arrow-right">Get Started</x-ui.button>
                    <x-ui.button href="{{ route('docs.page', 'components') }}" wire:navigate variant="outline" iconRight="arrow-right">Browse Components</x-ui.button>
                </div>

                <div class="mt-14 grid animate-fade-in overflow-hidden rounded-2xl border border-border md:grid-cols-3">
                    <div class="border-b border-border p-6 text-left md:border-b-0 md:border-r">
                        <p class="text-[0.6rem] font-bold uppercase tracking-wider text-muted-foreground">100% Ownership</p>
                        <p class="mt-3 text-sm font-light leading-relaxed text-foreground">Components live in your repository. No package lock-in, no hidden abstractions.</p>
                    </div>
                    <div class="border-b border-border p-6 text-left md:border-b-0 md:border-r">
                        <p class="text-[0.6rem] font-bold uppercase tracking-wider text-muted-foreground">Native Stack</p>
                        <p class="mt-3 text-sm font-light leading-relaxed text-foreground">Built with Blade, Alpine.js, Tailwind CSS v4, and Livewire. Your stack, your way.</p>
                    </div>
                    <div class="p-6 text-left">
                        <p class="text-[0.6rem] font-bold uppercase tracking-wider text-muted-foreground">Ship Instantly</p>
                        <p class="mt-3 text-sm font-light leading-relaxed text-foreground">Polished baseline + copy-paste components. Production-ready on day one.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-border bg-muted/20">
        <div class="container-wrapper px-4 py-14 lg:px-6">
            <div class="grid gap-6 lg:grid-cols-3">
                <x-ui.card class="flex flex-col p-8">
                    <div class="inline-flex rounded-lg bg-primary/8 p-4 text-primary">
                        <x-lucide-copy class="size-6" />
                    </div>
                    <h2 class="mt-6 text-lg font-semibold leading-tight text-foreground">Copy. Customize. Own.</h2>
                    <p class="mt-3 flex-1 text-sm font-light leading-relaxed text-muted-foreground">Pull components into your codebase, inspect every line, and adapt them to fit your product's unique needs and constraints.</p>
                    <a href="{{ route('docs.page', 'installation') }}" wire:navigate class="mt-5 inline-flex items-center text-sm font-medium text-primary transition-colors hover:text-primary/80">Learn more <x-lucide-arrow-right class="ml-1.5 size-3.5" /></a>
                </x-ui.card>

                <x-ui.card class="flex flex-col p-8">
                    <div class="inline-flex rounded-lg bg-primary/8 p-4 text-primary">
                        <x-lucide-sliders-horizontal class="size-6" />
                    </div>
                    <h2 class="mt-6 text-lg font-semibold leading-tight text-foreground">Built to be Edited</h2>
                    <p class="mt-3 flex-1 text-sm font-light leading-relaxed text-muted-foreground">Clean utility classes, sensible structure, and zero abstraction overhead. Your design system can bend the UI however it needs to.</p>
                    <a href="{{ route('docs.page', 'components') }}" wire:navigate class="mt-5 inline-flex items-center text-sm font-medium text-primary transition-colors hover:text-primary/80">Browse components <x-lucide-arrow-right class="ml-1.5 size-3.5" /></a>
                </x-ui.card>

                <x-ui.card class="flex flex-col p-8">
                    <div class="inline-flex rounded-lg bg-primary/8 p-4 text-primary">
                        <x-lucide-layout-dashboard class="size-6" />
                    </div>
                    <h2 class="mt-6 text-lg font-semibold leading-tight text-foreground">Built for Product Teams</h2>
                    <p class="mt-3 flex-1 text-sm font-light leading-relaxed text-muted-foreground">Patterns proven on real SaaS products. Admin panels, dashboards, forms, and search interfaces that ship fast and feel cohesive.</p>
                    <a href="{{ route('docs.page', 'quick-start') }}" wire:navigate class="mt-5 inline-flex items-center text-sm font-medium text-primary transition-colors hover:text-primary/80">Quick start <x-lucide-arrow-right class="ml-1.5 size-3.5" /></a>
                </x-ui.card>
            </div>
        </div>
    </section>

    <section class="border-b border-border bg-background">
        <div class="container-wrapper px-4 py-16 lg:px-6">
            <div class="flex flex-col gap-4 text-center">
                <p class="text-[0.625rem] font-bold uppercase tracking-wider text-muted-foreground">What You Actually Get</p>
                <h2 class="text-3xl font-semibold leading-tight text-foreground sm:text-4xl">A polished baseline. Complete creative control.</h2>
                <p class="mx-auto max-w-2xl text-[0.9375rem] leading-relaxed text-muted-foreground">Ship fast with a confident component library. Then bend every pixel to match your product's brand, data density, and workflows.</p>
            </div>

            <div class="mt-12 grid gap-5 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,0.8fr)]">
                <x-ui.card class="p-6">
                    <div class="grid gap-5 sm:grid-cols-2">
                        @foreach([
                            ['Documentation', 'Everything you need to ship fast', 'Installation, quick-start, component catalog, and real-world examples. No hidden surprises.'],
                            ['30+ Components', 'Building blocks for any interface', 'Buttons, cards, tables, forms, modals, popovers, and more. All battle-tested on production apps.'],
                            ['Ownership', 'Edit with zero friction', 'Clean Tailwind utility classes, sensible HTML. No abstractions, no magic. Exactly what you see is what you ship.'],
                            ['Speed', 'From zero to shipped', 'Copy components into your app. Wire them to your data. Build. No build process drama, no compilation steps.'],
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
                            ['No lock-in', 'Your code stays in your repo. No runtime dependencies between your UI and Velyx. You control every update.'],
                            ['Built-in defaults', 'Thoughtful patterns and spacing that look good out of the box. Still room for your brand to shine through.'],
                            ['Laravel, all the way', 'Blade, Livewire, Alpine. Familiar patterns, natural Laravel. No mental model switching, just productive coding.'],
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
                {{-- <div class="docs-grid-bg pointer-events-none absolute inset-0 z-0 opacity-60"></div> --}}
                <div class="pointer-events-none absolute inset-0 z-0"
                     style="background-image: linear-gradient(to right, var(--border) 1px, transparent 1px), linear-gradient(to bottom, var(--border) 1px, transparent 1px); background-size: 52px 52px; mask-image: radial-gradient(ellipse 85% 85% at 50% 50%, transparent 18%, black 100%); -webkit-mask-image: radial-gradient(ellipse 85% 85% at 50% 50%, transparent 18%, black 100%);"></div>

                <div class="pointer-events-none absolute inset-0 z-0">
                    <div class="absolute -left-20 -top-20 h-72 w-72 rounded-full bg-foreground/[0.035] blur-3xl"></div>
                    <div class="absolute -bottom-20 -right-20 h-72 w-72 rounded-full bg-foreground/2.5 blur-3xl"></div>
                </div>
                <div class="relative z-10">
                    <x-ui.badge variant="outline" pill>Start Building</x-ui.badge>

                    <h2 class="mx-auto mt-6 max-w-2xl text-4xl font-semibold leading-tight tracking-tight text-foreground sm:text-5xl">
                        Start shipping. Keep shipping.
                        <em class="block font-normal italic text-muted-foreground">Without losing control.</em>
                    </h2>

                    <p class="mx-auto mt-6 max-w-lg text-sm font-light leading-relaxed text-muted-foreground">
                        Explore 30+ production-ready components. Copy them into your Laravel app. Adapt them to your brand. Build fast. Ship confidently.
                    </p>

                    <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                        <x-ui.button href="{{ route('docs.page', 'installation') }}" wire:navigate size="lg" iconRight="arrow-right">Get Started</x-ui.button>
                        <x-ui.button href="https://github.com/velyx-labs/registry" variant="outline" size="lg" :lucide='false' icon="icons.github">View on GitHub</x-ui.button>
                    </div>

                    <p class="mt-8 text-[0.6875rem] font-light tracking-wide text-muted-foreground/60">
                        No package required - <span class="font-medium text-muted-foreground/80">components live in your repo.</span>
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
