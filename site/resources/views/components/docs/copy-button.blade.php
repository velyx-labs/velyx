@props([
    'text',
    'label' => 'Copy code',
])

<button
    type="button"
    x-data="{
        copied: false,
        copy() {
            navigator.clipboard.writeText(@js($text)).then(() => {
                this.copied = true;
                setTimeout(() => (this.copied = false), 1600);
            });
        },
    }"
    x-on:click="copy()"
    {{ $attributes->class('inline-flex size-[30px] items-center justify-center rounded-md text-ink-subtle transition-[color,background-color,scale] duration-200 hover:bg-border/60 hover:text-ink active:scale-90') }}
>
    <x-tabler-copy class="size-[15px]" x-show="! copied" aria-hidden="true" />
    <x-tabler-check class="size-[15px] text-success" x-show="copied" x-cloak aria-hidden="true" />
    <span class="sr-only" x-text="copied ? 'Copied' : @js($label)">{{ $label }}</span>
</button>
