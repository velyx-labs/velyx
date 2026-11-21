@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
])

@php
    $classes = [
        'inline-flex shrink-0 items-center justify-center gap-2 whitespace-nowrap rounded-md border border-transparent font-medium transition-[color,background-color,border-color,opacity,scale] duration-200 active:scale-[0.97]',
        match ($size) {
            'sm' => 'h-[34px] px-3 text-control',
            'lg' => 'h-11 px-[18px] text-control',
            'icon' => 'size-[34px] p-0',
            default => 'h-10 px-4 text-control',
        },
        match ($variant) {
            'outline' => 'border-border bg-surface text-ink hover:bg-surface-subtle',
            'ghost' => 'bg-transparent text-ink hover:bg-surface-subtle',
            'danger' => 'bg-danger text-white hover:opacity-90',
            default => 'bg-primary text-on-primary hover:opacity-85',
        },
    ];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button type="button" {{ $attributes->class($classes) }}>{{ $slot }}</button>
@endif
