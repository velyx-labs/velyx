@props([
    'as' => 'h3',
])

<{{ $as }} {{ $attributes->class('text-base leading-none font-semibold') }}>
    {{ $slot }}
</{{ $as }}>
