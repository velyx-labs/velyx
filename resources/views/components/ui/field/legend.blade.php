@props(['variant' => 'legend'])

@if($variant === 'label')
    <div
        data-slot="field-legend"
        data-variant="{{ $variant }}"
        {{ $attributes->class(['text-sm font-medium leading-none']) }}
    >{{ $slot }}</div>
@else
    <legend
        data-slot="field-legend"
        data-variant="{{ $variant }}"
        {{ $attributes->class(['text-sm font-medium leading-none']) }}
    >{{ $slot }}</legend>
@endif
