@props(['variant' => 'default'])

@php
    $variantClasses = match($variant) {
        'destructive' => 'bg-card text-destructive *:data-[slot=alert-description]:text-destructive/90 *:[svg]:text-current',
        'success'     => 'bg-card text-green-700 dark:text-green-400 *:data-[slot=alert-description]:text-green-700/80 dark:*:data-[slot=alert-description]:text-green-400/80 *:[svg]:text-current',
        'warning'     => 'bg-card text-yellow-700 dark:text-yellow-500 *:data-[slot=alert-description]:text-yellow-700/80 dark:*:data-[slot=alert-description]:text-yellow-500/80 *:[svg]:text-current',
        'info'        => 'bg-card text-card-foreground *:[svg]:text-current',
        default       => 'bg-card text-card-foreground',
    };
@endphp

<div
    data-slot="alert"
    role="alert"
    {{ $attributes->class([
        'group/alert relative grid w-full gap-0.5 rounded-lg border px-2.5 py-2 text-left text-sm',
        'has-data-[slot=alert-action]:pr-18',
        'has-[>svg]:grid-cols-[auto_1fr] has-[>svg]:gap-x-2',
        '[&>svg]:row-span-2 [&>svg]:translate-y-0.5 [&>svg:not([class*=size-])]:size-4',
        $variantClasses,
    ]) }}
>{{ $slot }}</div>
