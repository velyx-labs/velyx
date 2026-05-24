<div
    data-slot="field-group"
    {{ $attributes->class([
        'group/field-group @container/field-group flex w-full flex-col gap-5',
        'data-[slot=checkbox-group]:gap-3',
        '*:data-[slot=field-group]:gap-4',
    ]) }}
>{{ $slot }}</div>
