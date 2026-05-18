@props([
    'value',
])

<div
    data-slot="accordion-item"
    data-orientation="vertical"
    data-accordion-item-value="{{ (string) $value }}"
    :data-state="isOpen($el.dataset.accordionItemValue) ? 'open' : 'closed'"
    {{ $attributes->class(['not-last:border-b']) }}
>{{ $slot }}</div>
