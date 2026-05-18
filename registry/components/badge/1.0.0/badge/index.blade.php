@props(['variant' => 'default'])

@php
    $variantClasses = match($variant) {
        'secondary'   => 'border-transparent bg-secondary text-secondary-foreground',
        'destructive' => 'border-transparent bg-destructive text-white dark:bg-destructive/60',
        'outline'     => 'text-foreground',
        'success'     => 'border-transparent bg-green-500/10 text-green-700 border-green-500/20 dark:text-green-400 dark:border-green-500/30',
        default       => 'border-transparent bg-primary text-primary-foreground',
    };
@endphp

<span
    data-slot="badge"
    {{ $attributes->class([
        'inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 gap-1 overflow-hidden transition-[color,box-shadow]',
        '[&>svg]:size-3 [&>svg]:pointer-events-none',
        'focus-visible:outline-none focus-visible:ring-[3px] focus-visible:ring-ring/50',
        $variantClasses,
    ]) }}
>{{ $slot }}</span>
