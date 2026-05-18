<div
    data-slot="empty-description"
    {{ $attributes->class([
        'text-sm/relaxed text-muted-foreground',
        '[&>a]:underline [&>a]:underline-offset-4 [&>a:hover]:text-foreground',
    ]) }}
>{{ $slot }}</div>
