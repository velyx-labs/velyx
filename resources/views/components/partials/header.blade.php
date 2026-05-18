<?php

use Livewire\Component;

new class extends Component {
    public bool $mobileNavigationOpen = false;

    public function toggleMobileNavigation(): void
    {
        $this->mobileNavigationOpen = ! $this->mobileNavigationOpen;
    }

    public function closeMobileNavigation(): void
    {
        $this->mobileNavigationOpen = false;
    }
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

            {{-- Desktop nav --}}
            <nav class="hidden flex-1 items-center gap-0.5 md:flex" aria-label="Main navigation">
                <x-ui.button href="{{ route('docs.page', 'installation') }}" wire:navigate variant="ghost" size="sm">
                    Get Started
                </x-ui.button>
                <x-ui.button href="{{ route('docs.page', 'components') }}" wire:navigate variant="ghost" size="sm">
                    Components
                </x-ui.button>
                <x-ui.button href="https://github.com/velyx-labs/registry" target="_blank" rel="noopener noreferrer" variant="ghost" size="sm" icon="icons.github" :lucide="false">
                    GitHub
                </x-ui.button>
                <x-ui.button href="https://gvcjmaad.mychariow.shop/velyx-dev" target="_blank" rel="noopener noreferrer" variant="ghost" size="sm" iconLeft="heart">
                    Support
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

                <x-ui.button
                    href="{{ route('docs.page', 'installation') }}" wire:navigate
                    size="sm" iconRight="arrow-right"
                    class="hidden md:inline-flex"
                >
                    Start Building
                </x-ui.button>

                <button
                    type="button"
                    wire:click="toggleMobileNavigation"
                    class="inline-flex size-9 shrink-0 items-center justify-center rounded-md border border-input bg-transparent text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 md:hidden"
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

        {{-- Mobile nav --}}
        @if($mobileNavigationOpen)
            <div class="border-t border-border pb-4 pt-2 md:hidden">
                <nav class="flex flex-col" aria-label="Mobile navigation">
                    <x-ui.button href="{{ route('docs.page', 'installation') }}" wire:navigate wire:click="closeMobileNavigation" variant="ghost" size="sm" class="justify-start">
                        Get Started
                    </x-ui.button>
                    <x-ui.button href="{{ route('docs.page', 'components') }}" wire:navigate wire:click="closeMobileNavigation" variant="ghost" size="sm" class="justify-start">
                        Components
                    </x-ui.button>
                    <x-ui.button href="https://github.com/velyx-labs/registry" target="_blank" rel="noopener noreferrer" wire:click="closeMobileNavigation" variant="ghost" size="sm" icon="icons.github" :lucide="false" class="justify-start">
                        GitHub
                    </x-ui.button>
                    <x-ui.button href="https://gvcjmaad.mychariow.shop/velyx-dev" target="_blank" rel="noopener noreferrer" wire:click="closeMobileNavigation" variant="ghost" size="sm" iconLeft="heart" class="justify-start">
                        Support
                    </x-ui.button>
                </nav>
                <div class="mt-2 border-t border-border pt-3 px-1">
                    <x-ui.button
                        href="{{ route('docs.page', 'installation') }}" wire:navigate
                        wire:click="closeMobileNavigation"
                        size="sm" iconRight="arrow-right"
                        class="w-full"
                    >
                        Start Building
                    </x-ui.button>
                </div>
            </div>
        @endif
    </div>
</header>
