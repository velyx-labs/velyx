@props(['orientation' => 'vertical'])

@php
    $orientationClasses = match($orientation) {
        'horizontal' => 'flex-row items-center has-[>[data-slot=field-content]]:items-start *:data-[slot=field-label]:flex-auto has-[>[data-slot=field-content]]:[&>[role=checkbox],[role=radio]]:mt-px',
        'responsive' => 'flex-col *:w-full @md/field-group:flex-row @md/field-group:items-center @md/field-group:*:w-auto @md/field-group:has-[>[data-slot=field-content]]:items-start @md/field-group:*:data-[slot=field-label]:flex-auto [&>.sr-only]:w-auto @md/field-group:has-[>[data-slot=field-content]]:[&>[role=checkbox],[role=radio]]:mt-px',
        default      => 'flex-col *:w-full [&>.sr-only]:w-auto',
    };
@endphp

<div
    role="group"
    data-slot="field"
    data-orientation="{{ $orientation }}"
    {{ $attributes->class([
        'group/field flex w-full gap-2 data-[invalid=true]:text-destructive',
        $orientationClasses,
    ]) }}
>{{ $slot }}</div>
