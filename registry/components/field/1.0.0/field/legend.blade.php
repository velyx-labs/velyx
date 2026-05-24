@props(['variant' => 'legend'])

<legend
    data-slot="field-legend"
    data-variant="{{ $variant }}"
    {{ $attributes->class([
        'mb-1.5 font-medium',
        'data-[variant=label]:text-sm',
        'data-[variant=legend]:text-base',
    ]) }}
>{{ $slot }}</legend>
