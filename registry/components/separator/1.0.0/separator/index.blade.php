@props(['orientation' => 'horizontal', 'decorative' => true])

<div
    data-slot="separator"
    @if($decorative)
        role="none"
    @else
        role="separator"
        aria-orientation="{{ $orientation }}"
    @endif
    data-orientation="{{ $orientation }}"
    {{ $attributes->class([
        'shrink-0 bg-border',
        'data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full',
        'data-[orientation=vertical]:w-px data-[orientation=vertical]:self-stretch',
    ]) }}
></div>
