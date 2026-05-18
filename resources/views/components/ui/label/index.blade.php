@props([
    'for' => null,
    'required' => false,
    'hint' => null,
])

<label
    data-slot="label"
    @if($for) for="{{ $for }}" @endif
    {{ $attributes->class([
        'flex items-center gap-1 text-sm leading-none font-medium select-none',
        'peer-disabled:cursor-not-allowed peer-disabled:opacity-70',
        'group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50',
    ]) }}
>
    {{ $slot }}
    @if($required)
        <span aria-hidden="true" class="text-destructive">*</span>
    @endif
    @if($hint)
        <span class="font-normal text-muted-foreground">({{ $hint }})</span>
    @endif
</label>
