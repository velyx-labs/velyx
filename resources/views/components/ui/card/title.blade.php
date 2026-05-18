<div
    data-slot="card-title"
    {{ $attributes->class([
        'text-base leading-snug font-medium',
        'group-data-[size=sm]/card:text-sm',
    ]) }}
>{{ $slot }}</div>
