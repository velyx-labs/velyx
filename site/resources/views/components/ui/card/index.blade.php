@props([
    'as' => 'div',
])

<{{ $as }} {{ $attributes->class('flex flex-col gap-6 rounded-xl border border-border bg-card py-6 text-card-foreground shadow-xs') }}>
    {{ $slot }}
</{{ $as }}>
