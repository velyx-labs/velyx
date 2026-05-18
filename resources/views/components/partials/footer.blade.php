<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<footer class="border-t border-border bg-background" role="contentinfo">
    <div class="container-wrapper px-4 py-12 lg:px-6 lg:py-16">

        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-[1.5fr_1fr_1fr]">

            {{-- Brand --}}
            <div class="flex flex-col gap-5 sm:col-span-2 lg:col-span-1">
                <x-ui.button href="{{ route('home') }}" wire:navigate variant="ghost" class="w-fit gap-2.5 px-0 hover:bg-transparent">
                    <img class="h-8 w-8 dark:hidden" src="{{ asset('assets/img/logo.svg') }}" alt="Velyx" width="32" height="32">
                    <img class="hidden h-8 w-8 dark:block" src="{{ asset('assets/img/logo-dark.svg') }}" alt="Velyx" width="32" height="32">
                    <span class="text-base font-semibold text-foreground">Velyx</span>
                </x-ui.button>

                <p class="max-w-sm text-sm leading-7 text-muted-foreground">
                    Copy the component, adapt the markup, and ship Laravel interfaces that still feel like your product — not someone else's package.
                </p>

                <div class="flex flex-wrap gap-3">
                    <x-ui.button href="{{ route('docs.page', 'installation') }}" wire:navigate size="sm" iconRight="arrow-right">
                        Start Building
                    </x-ui.button>
                    <x-ui.button href="https://github.com/velyx-labs/registry" target="_blank" rel="noopener noreferrer" variant="outline" size="sm" icon="icons.github" :lucide="false">
                        GitHub
                    </x-ui.button>
                </div>
            </div>

            {{-- Explore --}}
            <div class="flex flex-col gap-4">
                <p class="text-xs font-medium uppercase tracking-widest text-muted-foreground">Explore</p>
                <div class="flex flex-col items-start -ml-3">
                    <x-ui.button href="{{ route('docs.page', 'installation') }}" wire:navigate variant="link" size="sm" class="text-muted-foreground hover:text-foreground">
                        Get Started
                    </x-ui.button>
                    <x-ui.button href="{{ route('docs.page', 'components') }}" wire:navigate variant="link" size="sm" class="text-muted-foreground hover:text-foreground">
                        Component Library
                    </x-ui.button>
                    <x-ui.button href="{{ route('home') }}" wire:navigate variant="link" size="sm" class="text-muted-foreground hover:text-foreground">
                        Homepage
                    </x-ui.button>
                </div>
            </div>

            {{-- Community --}}
            <div class="flex flex-col gap-4">
                <p class="text-xs font-medium uppercase tracking-widest text-muted-foreground">Community</p>
                <div class="flex flex-col items-start -ml-3">
                    <x-ui.button href="https://github.com/velyx-labs/registry" target="_blank" rel="noopener noreferrer" variant="link" size="sm" class="text-muted-foreground hover:text-foreground">
                        GitHub
                    </x-ui.button>
                    <x-ui.button href="https://x.com/velyxdev" target="_blank" rel="noopener noreferrer" variant="link" size="sm" class="text-muted-foreground hover:text-foreground">
                        X (Twitter)
                    </x-ui.button>
                    <x-ui.button href="https://gvcjmaad.mychariow.shop/velyx-dev" target="_blank" rel="noopener noreferrer" variant="link" size="sm" iconLeft="heart" class="text-muted-foreground hover:text-foreground">
                        Support
                    </x-ui.button>
                </div>
            </div>

        </div>

        <x-ui.separator class="my-8" />

        <div class="flex flex-col gap-2 text-xs text-muted-foreground sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ date('Y') }} Velyx. Laravel UI components for teams that want speed without losing ownership.</p>
            <p>
                Inspired by
                <x-ui.button href="https://ui.shadcn.com" target="_blank" rel="noopener noreferrer" variant="link" class="h-auto p-0 text-xs text-muted-foreground hover:text-foreground">
                    shadcn/ui
                </x-ui.button>
            </p>
        </div>

    </div>
</footer>
