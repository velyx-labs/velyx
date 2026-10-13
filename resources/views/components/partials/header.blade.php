<?php

use Livewire\Component;

new class extends Component {};
?>

<header class="site-header sticky top-0 z-50 w-full border-b border-border bg-background/85 backdrop-blur supports-backdrop-filter:bg-background/70">
    <div class="px-4 sm:px-6 lg:px-12 xl:px-24">
        <div class="mx-auto flex h-14 max-w-7xl items-center justify-between gap-3 sm:gap-6">

            {{-- Logo --}}
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 text-foreground">
                <x-icons.velyx class="h-5 w-5" />
                <span class="text-[15px] font-semibold tracking-tight">Velyx</span>
            </a>

            {{-- Nav --}}
            <nav class="hidden flex-1 items-center gap-1 sm:flex" aria-label="Main navigation">
                <x-ui.button href="{{ route('docs.page', 'installation') }}" wire:navigate variant="ghost" size="sm" class="text-muted-foreground hover:text-foreground">
                    Docs
                </x-ui.button>
                <x-ui.button href="{{ route('docs.page', 'components') }}" wire:navigate variant="ghost" size="sm" class="text-muted-foreground hover:text-foreground">
                    Components
                </x-ui.button>
            </nav>

            {{-- Right actions --}}
            <div class="flex items-center gap-1.5 sm:gap-2">
                <x-site-search />

                <x-style-switch />

                <a
                    href="{{ config('velyx-docs.links.support') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Buy me a coffee"
                    class="inline-flex h-9 items-center gap-1.5 rounded-md px-2 text-xs font-medium text-muted-foreground transition-colors hover:text-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                >
                    <x-lucide-coffee class="h-4 w-4" />
                    <span class="hidden lg:inline">Buy me a coffee</span>
                </a>

                <a
                    href="{{ config('velyx-docs.links.gitlab') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="hidden size-9 items-center justify-center rounded-md text-muted-foreground transition-colors hover:bg-accent sm:inline-flex hover:text-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                    aria-label="Velyx on GitLab"
                >
                    <x-icons.gitlab class="h-4 w-4" />
                </a>
            </div>
        </div>
    </div>
</header>
