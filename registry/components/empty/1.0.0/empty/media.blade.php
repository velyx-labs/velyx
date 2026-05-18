@props(['variant' => 'default'])

@php
    $variantClasses = match($variant) {
        'icon' => 'flex size-8 shrink-0 items-center justify-center rounded-lg bg-muted text-foreground [&_svg:not([class*=size-])]:size-4',
        default => 'bg-transparent',
    };
@endphp

<div
    data-slot="empty-icon"
    data-variant="{{ $variant }}"
    {{ $attributes->class([
        'mb-2 flex shrink-0 items-center justify-center [&_svg]:pointer-events-none [&_svg]:shrink-0',
        $variantClasses,
    ]) }}
>{{ $slot }}</div>
