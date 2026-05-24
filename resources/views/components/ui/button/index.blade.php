@props([
    'variant'  => 'default',
    'size'     => 'default',
    'href'     => null,
    'type'     => 'button',
    'disabled' => false,
    'icon'     => null,
    'iconLeft' => null,
    'iconRight' => null,
    'iconOnly' => false,
    'lucide'   => true,
])

@php
    // iconOnly="icon-name" is shorthand for iconLeft + :iconOnly="true"
    $iconOnlyIcon = (is_string($iconOnly) && ! in_array($iconOnly, ['true', '1', 'false', '0'], true)) ? $iconOnly : null;
    $isIconOnly   = $iconOnly !== false && $iconOnly !== null && $iconOnly !== '' && $iconOnly !== 'false' && $iconOnly !== '0';
    $leftIcon     = $iconLeft ?? $icon ?? $iconOnlyIcon;

    $resolveIcon = fn(?string $name) => $name === null ? null
        : ($lucide ? 'lucide-' . $name : $name);

    $variantClasses = match($variant) {
        'destructive' => 'bg-destructive text-white shadow-xs hover:bg-destructive/90 focus-visible:ring-destructive/20 dark:focus-visible:ring-destructive/40 dark:bg-destructive/60',
        'outline'     => 'border border-input bg-background shadow-xs hover:bg-accent hover:text-accent-foreground dark:bg-input/30 dark:border-input dark:hover:bg-input',
        'secondary'   => 'bg-secondary text-secondary-foreground shadow-xs hover:bg-secondary/80',
        'ghost'       => 'hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50',
        'link'        => 'text-primary underline-offset-4 hover:underline',
        default       => 'bg-primary text-primary-foreground shadow-xs hover:bg-primary/90',
    };

    $sizeClasses = match($size) {
        'sm'    => 'h-8 rounded-md gap-1.5 px-3 text-xs has-[>svg]:px-2.5',
        'lg'    => 'h-10 rounded-md px-6 text-base has-[>svg]:px-4',
        'icon'  => 'size-9',
        default => 'h-9 px-4 py-2 text-sm has-[>svg]:px-3',
    };

    $baseClasses = 'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md font-medium transition-all outline-none shrink-0 [&_svg]:pointer-events-none [&_svg:not([class*=size-])]:size-4 [&_svg]:shrink-0 focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 disabled:pointer-events-none disabled:opacity-50';

    $tag = $href ? 'a' : 'button';
@endphp

@if($tag === 'a')
    <a
        data-slot="button"
        href="{{ $href }}"
        {{ $attributes->class([$baseClasses, $variantClasses, $sizeClasses]) }}
        @if($disabled) aria-disabled="true" @endif
    >
        @if($leftIcon && !$isIconOnly)
            <x-dynamic-component :component="$resolveIcon($leftIcon)" />
        @endif
        @if(!$isIconOnly)
            {{ $slot }}
        @endif
        @if($iconRight && !$isIconOnly)
            <x-dynamic-component :component="$resolveIcon($iconRight)" />
        @endif
        @if($isIconOnly)
            <x-dynamic-component :component="$resolveIcon($leftIcon ?? $iconRight)" />
            <span class="sr-only">{{ $slot }}</span>
        @endif
    </a>
@else
    <button
        data-slot="button"
        type="{{ $type }}"
        {{ $attributes->class([$baseClasses, $variantClasses, $sizeClasses]) }}
        @if($disabled) disabled @endif
        wire:loading.attr="disabled"
    >
        <x-lucide-loader-circle wire:loading class="size-4 animate-spin" />
        <span wire:loading.remove class="contents">
            @if($leftIcon && !$isIconOnly)
                <x-dynamic-component :component="$resolveIcon($leftIcon)" />
            @endif
            @if(!$isIconOnly)
                {{ $slot }}
            @endif
            @if($iconRight && !$isIconOnly)
                <x-dynamic-component :component="$resolveIcon($iconRight)" />
            @endif
            @if($isIconOnly)
                <x-dynamic-component :component="$resolveIcon($leftIcon ?? $iconRight)" />
                <span class="sr-only">{{ $slot }}</span>
            @endif
        </span>
    </button>
@endif
