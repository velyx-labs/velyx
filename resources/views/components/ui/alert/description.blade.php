<div
    data-slot="alert-description"
    {{ $attributes->class([
        'text-sm text-balance text-muted-foreground',
        'group-has-[>svg]/alert:col-start-2',
        '[&_a]:underline [&_a]:underline-offset-3 [&_a]:hover:text-foreground',
        '[&_p:not(:last-child)]:mb-4',
    ]) }}
>{{ $slot }}</div>
