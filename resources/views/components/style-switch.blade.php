<div
    role="group"
    aria-label="Site style"
    {{ $attributes->class('style-switch inline-flex items-center gap-0.5 rounded-full border border-border bg-muted p-0.5') }}
>
    <button
        type="button"
        data-style-value="simple"
        aria-pressed="true"
        class="style-switch__option inline-flex h-7 items-center rounded-full px-2.5 text-xs font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
    >Simple</button>
    <button
        type="button"
        data-style-value="neo"
        aria-pressed="false"
        class="style-switch__option inline-flex h-7 items-center rounded-full px-2.5 text-xs font-bold transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
    >Neo</button>
</div>
