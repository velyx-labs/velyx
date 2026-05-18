@props(['size' => 'default'])

<span
    data-slot="avatar"
    data-size="{{ $size }}"
    {{ $attributes->class([
        'group/avatar relative flex shrink-0 overflow-hidden rounded-full select-none',
        'size-8 data-[size=sm]:size-6 data-[size=lg]:size-10',
    ]) }}
>{{ $slot }}</span>
