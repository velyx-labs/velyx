@unless($slot->isEmpty())
    <div
        role="alert"
        data-slot="field-error"
        {{ $attributes->class(['text-sm font-normal text-destructive']) }}
    >{{ $slot }}</div>
@endunless
