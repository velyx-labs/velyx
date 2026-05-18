@props(['orientation' => 'vertical'])

@php
    $orientationClasses = match($orientation) {
        'horizontal' => 'grid-cols-[auto_1fr] items-start gap-x-6',
        'responsive' => 'sm:grid-cols-[auto_1fr] sm:items-start sm:gap-x-6',
        default => '',
    };
@endphp

<div
    data-slot="field"
    data-orientation="{{ $orientation }}"
    {{ $attributes->class([
        'group/field grid gap-2',
        $orientationClasses,
    ]) }}
>{{ $slot }}</div>
