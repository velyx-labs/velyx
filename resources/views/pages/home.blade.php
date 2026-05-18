<?php

use App\Services\ComponentService;
use Livewire\Component;

new class extends Component
{
    public array $components = [];

    public function mount(ComponentService $componentService): void
    {
        $this->components = $componentService->getAllComponents();
    }
};
?>

<div>
    <section class="relative flex min-h-screen flex-col items-center justify-center overflow-hidden px-4 py-16 lg:px-6">

        {{-- Grid background --}}
        <div
            class="pointer-events-none absolute inset-0"
            style="background-image: linear-gradient(to right, var(--border) 1px, transparent 1px), linear-gradient(to bottom, var(--border) 1px, transparent 1px); background-size: 64px 64px; mask-image: radial-gradient(ellipse 80% 60% at 50% 0%, black 0%, transparent 100%); -webkit-mask-image: radial-gradient(ellipse 80% 60% at 50% 0%, black 0%, transparent 100%);"
        ></div>

        <div class="container-wrapper relative z-10 flex w-full flex-col items-center gap-10">

            {{-- Title + description + CTAs --}}
            <div class="flex flex-col items-center gap-5 text-center">
                <p class="text-xs font-medium uppercase tracking-widest text-muted-foreground">
                    Open-source · MIT License
                </p>
                <h1 class="max-w-2xl text-5xl font-semibold leading-[1.1] tracking-tight text-foreground xl:text-6xl">
                    Blade components<br>
                    <span class="font-normal text-muted-foreground">you actually own.</span>
                </h1>
                <p class="max-w-md text-base leading-relaxed text-muted-foreground">
                    Production-ready UI for Laravel. Copy components into your project and adapt them freely — no lock-in, no abstractions.
                </p>
                <div class="flex flex-wrap justify-center gap-3">
                    <x-ui.button href="{{ route('docs.page', 'installation') }}" wire:navigate iconRight="arrow-right">
                        Get started
                    </x-ui.button>
                    <x-ui.button href="{{ route('docs.page', 'components') }}" wire:navigate variant="outline">
                        Browse components
                    </x-ui.button>
                </div>
            </div>

            {{-- Component preview --}}
            <div class="w-full max-w-4xl">
                {{-- Glow --}}
                <div class="pointer-events-none absolute inset-x-0 mx-auto h-64 w-2/3 -translate-y-1/2 rounded-full bg-foreground/[0.04] blur-3xl"></div>

                <div class="relative overflow-hidden rounded-xl border border-border bg-card shadow-2xl">

                    {{-- Browser chrome --}}
                    <div class="flex items-center gap-3 border-b border-border bg-muted/30 px-4 py-3">
                        <div class="flex gap-1.5">
                            <span class="size-2.5 rounded-full bg-border"></span>
                            <span class="size-2.5 rounded-full bg-border"></span>
                            <span class="size-2.5 rounded-full bg-border"></span>
                        </div>
                        <div class="flex flex-1 items-center gap-2 rounded-md border border-border/60 bg-background/60 px-3 py-1 text-xs text-muted-foreground">
                            <x-lucide-lock class="size-3 shrink-0" />
                            velyx.dev/components
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="space-y-4 p-5">

                        {{-- Toolbar: Field + Button --}}
                        <div class="flex items-end gap-3">
                            <x-ui.field class="flex-1">
                                <x-ui.field.label>Search</x-ui.field.label>
                                <x-ui.field.content>
                                    <x-ui.input placeholder="Filter components..." />
                                </x-ui.field.content>
                            </x-ui.field>
                            <x-ui.button size="sm" iconLeft="plus">Add component</x-ui.button>
                        </div>

                        <x-ui.separator />

                        {{-- Table --}}
                        <x-ui.table>
                            <x-ui.table.header>
                                <x-ui.table.row>
                                    <x-ui.table.head class="w-8">
                                        <x-ui.checkbox />
                                    </x-ui.table.head>
                                    <x-ui.table.head>Name</x-ui.table.head>
                                    <x-ui.table.head>Category</x-ui.table.head>
                                    <x-ui.table.head>Status</x-ui.table.head>
                                    <x-ui.table.head class="text-right"></x-ui.table.head>
                                </x-ui.table.row>
                            </x-ui.table.header>
                            <x-ui.table.body>
                                @foreach([
                                    ['Button',    'Forms',    'success',   'Stable'],
                                    ['Field',     'Forms',    'success',   'Stable'],
                                    ['Separator', 'Layout',   'secondary', 'New'],
                                    ['Table',     'Data',     'secondary', 'New'],
                                    ['Card',      'Layout',   'success',   'Stable'],
                                ] as [$name, $category, $badgeVariant, $badgeLabel])
                                    <x-ui.table.row>
                                        <x-ui.table.cell>
                                            <x-ui.checkbox />
                                        </x-ui.table.cell>
                                        <x-ui.table.cell class="font-medium text-foreground">
                                            {{ $name }}
                                        </x-ui.table.cell>
                                        <x-ui.table.cell class="text-muted-foreground">
                                            {{ $category }}
                                        </x-ui.table.cell>
                                        <x-ui.table.cell>
                                            <x-ui.badge variant="{{ $badgeVariant }}">{{ $badgeLabel }}</x-ui.badge>
                                        </x-ui.table.cell>
                                        <x-ui.table.cell class="text-right">
                                            <x-ui.button size="sm" variant="ghost" iconOnly="arrow-right" />
                                        </x-ui.table.cell>
                                    </x-ui.table.row>
                                @endforeach
                            </x-ui.table.body>
                        </x-ui.table>

                        {{-- Table footer --}}
                        <div class="flex items-center justify-between border-t border-border pt-3">
                            <p class="text-xs text-muted-foreground">5 of {{ count($this->components) }} components</p>
                            <div class="flex gap-1.5">
                                <x-ui.button size="sm" variant="outline" iconOnly="chevron-left" />
                                <x-ui.button size="sm" variant="outline" iconOnly="chevron-right" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
