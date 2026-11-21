@props([
    'as' => 'div',
    'delay' => 0,
])

<{{ $as }}
    data-reveal
    x-data
    x-intersect.once.margin.0px.0px.-10%.0px="$el.classList.add('is-shown')"
    @if ($delay) style="--delay: {{ (int) $delay }}ms" @endif
    {{ $attributes }}
>{{ $slot }}</{{ $as }}>
