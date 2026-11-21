@props([
    'type' => 'text',
    'size' => 'md',
    'name' => null,
    'invalid' => null,
])

@php
    // The field name drives the error lookup; fall back to the wire:model property.
    $field = $name ?? $attributes->whereStartsWith('wire:model')->first();
    $invalid ??= $field && isset($errors) && $errors->has($field);

    $sizes = [
        'sm' => 'h-8 px-2.5 text-xs',
        'md' => 'h-9 px-3 text-sm',
        'lg' => 'h-10 px-3.5 text-sm',
    ];
@endphp

<input
    type="{{ $type }}"
    @if ($name) name="{{ $name }}" @endif
    @if ($invalid) aria-invalid="true" @endif
    {{ $attributes->class([
        'flex w-full min-w-0 rounded-md border border-input bg-transparent shadow-xs transition-colors',
        'placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground',
        'file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground',
        'outline-none focus-visible:border-ring focus-visible:ring-2 focus-visible:ring-ring/40',
        'disabled:cursor-not-allowed disabled:opacity-50',
        'aria-invalid:border-destructive aria-invalid:ring-destructive/30',
        $sizes[$size] ?? $sizes['md'],
    ]) }}
>
