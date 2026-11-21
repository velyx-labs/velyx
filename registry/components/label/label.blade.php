@props([
    'required' => false,
    'hint' => null,
])

<label {{ $attributes->class('flex items-center gap-1 text-sm font-medium leading-none select-none peer-disabled:cursor-not-allowed peer-disabled:opacity-50') }}>
    {{ $slot }}
    @if ($required)
        <span class="text-destructive" aria-hidden="true">*</span>
    @endif
    @if ($hint)
        <span class="font-normal text-muted-foreground">{{ $hint }}</span>
    @endif
</label>
