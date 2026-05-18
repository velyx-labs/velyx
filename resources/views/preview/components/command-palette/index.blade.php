@props([
    'props' => [],
])

@php
    $placeholder = (string) ($props['placeholder'] ?? 'Search commands, files...');
@endphp

{{--
    Static inline representation of the open state.
    The real component uses fixed overlay positioning, incompatible with inline embedding.
--}}
<div class="preview w-full bg-muted/30 p-6">
    <div class="mx-auto max-w-2xl overflow-hidden rounded-xl border bg-background shadow-2xl ring-1 ring-border">
        {{-- Search input --}}
        <div class="relative">
            <x-lucide-search class="pointer-events-none absolute left-4 top-3.5 h-5 w-5 text-muted-foreground" />
            <div class="flex h-12 w-full items-center bg-transparent pl-11 pr-12 text-sm text-muted-foreground/60">
                {{ $placeholder }}
            </div>
            <kbd class="absolute right-4 top-3 hidden rounded border border-border bg-muted px-2 py-1 text-xs text-muted-foreground sm:block">
                ESC
            </kbd>
        </div>

        {{-- Results list --}}
        <div class="max-h-72 overflow-y-auto border-t border-border">
            <div class="p-2">
                <p class="px-3 pb-1 pt-2 text-xs font-medium text-muted-foreground">Suggestions</p>
                @foreach([
                    ['icon' => 'settings',     'label' => 'Open Settings',        'shortcut' => '⌘,'],
                    ['icon' => 'layout-grid',  'label' => 'Browse Components',    'shortcut' => null],
                    ['icon' => 'file-text',    'label' => 'Go to Documentation',  'shortcut' => null],
                    ['icon' => 'moon',         'label' => 'Toggle Dark Mode',     'shortcut' => '⌘D'],
                ] as $i => $item)
                    <div class="flex items-center justify-between rounded-md px-3 py-2 text-sm {{ $i === 0 ? 'bg-accent text-accent-foreground' : 'text-foreground' }}">
                        <div class="flex items-center gap-3">
                            <x-dynamic-component :component="'lucide-' . $item['icon']" class="h-4 w-4 text-muted-foreground" />
                            {{ $item['label'] }}
                        </div>
                        @if($item['shortcut'])
                            <kbd class="rounded border border-border bg-muted px-1.5 py-0.5 font-mono text-xs text-muted-foreground">{{ $item['shortcut'] }}</kbd>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Footer hints --}}
        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 border-t border-border bg-muted/40 px-4 py-2.5 text-xs text-muted-foreground">
            <span class="flex items-center gap-1">
                <kbd class="rounded border border-border bg-muted px-1.5 py-0.5 font-mono">↑↓</kbd>
                Navigate
            </span>
            <span class="flex items-center gap-1">
                <kbd class="rounded border border-border bg-muted px-1.5 py-0.5 font-mono">↵</kbd>
                Select
            </span>
            <span class="flex items-center gap-1">
                <kbd class="rounded border border-border bg-muted px-1.5 py-0.5 font-mono">esc</kbd>
                Close
            </span>
        </div>
    </div>
</div>
