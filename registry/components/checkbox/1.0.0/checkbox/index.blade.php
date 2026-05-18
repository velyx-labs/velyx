@props(['disabled' => false])

<label
    data-slot="checkbox"
    {{ $disabled ? 'data-disabled=true' : '' }}
    {{ $attributes->only(['class'])->class([
        'group/checkbox relative flex size-4 shrink-0 cursor-pointer items-center justify-center',
    ]) }}
>
    <input
        type="checkbox"
        class="peer sr-only"
        @disabled($disabled)
        {{ $attributes->except(['class', 'disabled']) }}
    />

    {{-- Visual border / background --}}
    <span
        aria-hidden="true"
        class="pointer-events-none absolute inset-0 rounded-[4px] border border-input transition-colors
               peer-focus-visible:border-ring peer-focus-visible:ring-[3px] peer-focus-visible:ring-ring/50
               peer-disabled:cursor-not-allowed peer-disabled:opacity-50
               peer-checked:border-primary peer-checked:bg-primary
               peer-aria-invalid:border-destructive peer-aria-invalid:ring-[3px] peer-aria-invalid:ring-destructive/20
               dark:peer-aria-invalid:border-destructive/50 dark:peer-aria-invalid:ring-destructive/40
               group-has-disabled/field:opacity-50"
    ></span>

    {{-- Check indicator --}}
    <span
        data-slot="checkbox-indicator"
        aria-hidden="true"
        class="pointer-events-none relative z-10 grid place-content-center text-primary-foreground opacity-0 transition-none
               peer-checked:opacity-100
               [&>svg]:size-3.5"
    >
        <x-lucide-check />
    </span>
</label>
