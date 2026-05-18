<span
    data-slot="avatar-fallback"
    {{ $attributes->class([
        'flex size-full items-center justify-center rounded-full bg-muted text-sm font-medium text-muted-foreground',
        'group-data-[size=sm]/avatar:text-xs',
        'group-data-[size=lg]/avatar:text-base',
    ]) }}
>{{ $slot }}</span>
