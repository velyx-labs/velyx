<div
    data-slot="card-footer"
    {{ $attributes->class([
        'flex items-center rounded-b-xl border-t bg-muted/50 p-4',
        'group-data-[size=sm]/card:p-3',
    ]) }}
>{{ $slot }}</div>
