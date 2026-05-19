<?php

use Livewire\Component;

new class extends Component {
    
};
?>

<header class="sticky top-0 z-50 w-full border-b border-border/40 bg-background/95 backdrop-blur supports-backdrop-filter:bg-background/80">
    <div class="container-wrapper px-4 lg:px-6">
        <div class="flex h-16 items-center justify-between gap-6">

            {{-- Logo --}}
            <x-ui.button href="{{ route('home') }}" wire:navigate variant="ghost" class="gap-2.5 px-0 font-semibold hover:bg-transparent">
                <img class="h-7 w-7 transition-transform duration-300 group-hover:rotate-6 dark:hidden"
                     src="{{ asset('assets/img/logo.svg') }}" alt="Velyx" width="28" height="28">
                <img class="hidden h-7 w-7 transition-transform duration-300 group-hover:rotate-6 dark:block"
                     src="{{ asset('assets/img/logo-dark.svg') }}" alt="Velyx" width="28" height="28">
                <span class="text-[15px] tracking-tight sm:text-base">Velyx</span>
            </x-ui.button>

            {{-- Nav --}}
            <nav class="flex flex-1 items-center gap-0.5" aria-label="Main navigation">
                <x-ui.button href="{{ route('docs.page', 'installation') }}" wire:navigate variant="ghost" size="sm">
                    Get Started
                </x-ui.button>
                <x-ui.button href="{{ route('docs.page', 'components') }}" wire:navigate variant="ghost" size="sm">
                    Components
                </x-ui.button>
            </nav>

            {{-- Right actions --}}
            <div class="flex items-center gap-2">
                <button
                    type="button"
                    class="dark-mode-toggle inline-flex size-9 shrink-0 items-center justify-center rounded-md border border-input bg-transparent text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    aria-label="Toggle dark mode"
                >
                    <x-lucide-sun class="h-4 w-4 dark:hidden" />
                    <x-lucide-moon class="hidden h-4 w-4 dark:block" />
                </button>
            </div>
        </div>
    </div>
</header>
