<div
    data-slot="field-separator"
    data-content="{{ $slot->isEmpty() ? 'false' : 'true' }}"
    {{ $attributes->class([
        'relative -my-2 h-5 text-sm',
        'group-data-[variant=outline]/field-group:-mb-2',
    ]) }}
>
    <hr class="absolute inset-0 top-1/2 border-border" />
    @unless($slot->isEmpty())
        <span
            data-slot="field-separator-content"
            class="relative mx-auto block w-fit bg-background px-2 text-muted-foreground"
        >{{ $slot }}</span>
    @endunless
</div>
