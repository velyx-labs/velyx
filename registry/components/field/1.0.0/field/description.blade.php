<p
    data-slot="field-description"
    {{ $attributes->class([
        'text-left text-sm leading-normal font-normal text-muted-foreground',
        'group-has-data-horizontal/field:text-balance',
        '[[data-variant=legend]+&]:-mt-1.5',
        'last:mt-0',
        '[&>a]:underline [&>a]:underline-offset-4 [&>a:hover]:text-primary',
    ]) }}
>{{ $slot }}</p>
