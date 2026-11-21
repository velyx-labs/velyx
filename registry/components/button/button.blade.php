@props([
    'variant' => 'default',
    'size' => 'md',
    'href' => null,
    'icon' => null,
    'iconTrailing' => null,
    'type' => 'button',
])

@php
    $variants = [
        'default' => 'bg-primary text-primary-foreground shadow-xs hover:bg-primary/90',
        'secondary' => 'bg-secondary text-secondary-foreground hover:bg-secondary/80',
        'outline' => 'border border-input bg-background shadow-xs hover:bg-accent hover:text-accent-foreground',
        'ghost' => 'hover:bg-accent hover:text-accent-foreground',
        'destructive' => 'bg-destructive text-destructive-foreground shadow-xs hover:bg-destructive/90',
        'link' => 'text-primary underline-offset-4 hover:underline',
    ];

    $sizes = [
        'sm' => 'h-8 gap-1.5 rounded-md px-3 text-xs',
        'md' => 'h-9 gap-2 rounded-md px-4 text-sm',
        'lg' => 'h-10 gap-2 rounded-md px-6 text-sm',
        'icon' => 'size-9 rounded-md',
    ];

    $classes = \Illuminate\Support\Arr::toCssClasses([
        'inline-flex shrink-0 items-center justify-center whitespace-nowrap font-medium transition-colors',
        'outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background',
        'disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50',
        $variants[$variant] ?? $variants['default'],
        $sizes[$size] ?? $sizes['md'],
    ]);

    // When the button triggers a Livewire action, show a spinner and disable it while the action runs.
    $action = $attributes->whereStartsWith('wire:click')->first();
    $target = $action ? strtok($action, '(') : null;
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>
        @if ($icon)
            <x-ui.icon :name="$icon" class="size-4" />
        @endif
        {{ $slot }}
        @if ($iconTrailing)
            <x-ui.icon :name="$iconTrailing" class="size-4" />
        @endif
    </a>
@else
    <button
        type="{{ $type }}"
        @if ($target)
            wire:loading.attr="disabled"
            wire:target="{{ $target }}"
        @endif
        {{ $attributes->class($classes) }}
    >
        @if ($target)
            <x-ui.icon name="loader" class="size-4 animate-spin" wire:loading wire:target="{{ $target }}" />
        @endif
        @if ($icon && $target)
            <x-ui.icon :name="$icon" class="size-4" wire:loading.remove wire:target="{{ $target }}" />
        @elseif ($icon)
            <x-ui.icon :name="$icon" class="size-4" />
        @endif
        {{ $slot }}
        @if ($iconTrailing)
            <x-ui.icon :name="$iconTrailing" class="size-4" />
        @endif
    </button>
@endif
