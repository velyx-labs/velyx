@props([
    'variant' => 'default',
    'icon' => null,
])

@php
    $variants = [
        'default' => 'border-transparent bg-primary text-primary-foreground',
        'secondary' => 'border-transparent bg-secondary text-secondary-foreground',
        'outline' => 'border-border text-foreground',
        'success' => 'border-success/40 bg-success/10 text-success',
        'warning' => 'border-warning/50 bg-warning/15 text-foreground',
        'info' => 'border-info/40 bg-info/10 text-info',
        'destructive' => 'border-destructive/40 bg-destructive/10 text-destructive',
    ];
@endphp

<span {{ $attributes->class([
    'inline-flex w-fit shrink-0 items-center gap-1 whitespace-nowrap rounded-md border px-2 py-0.5 text-xs font-medium',
    $variants[$variant] ?? $variants['default'],
]) }}>
    @if ($icon)
        <x-ui.icon :name="$icon" class="size-3" />
    @endif
    {{ $slot }}
</span>
