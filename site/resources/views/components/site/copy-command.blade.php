@props([
    'command',
    'tone' => 'light',
])

<div
    x-data="{
        copied: false,
        copy() {
            navigator.clipboard.writeText(@js($command)).then(() => {
                this.copied = true;
                setTimeout(() => (this.copied = false), 1600);
            });
        },
    }"
    {{ $attributes->class([
        'inline-flex items-center gap-3 rounded-md py-[3px] pr-[3px] pl-3.5',
        'border border-border bg-surface text-ink' => $tone === 'light',
        'bg-terminal text-on-terminal dark:ring-1 dark:ring-border' => $tone === 'dark',
    ]) }}
>
    <code class="font-mono text-code"><span class="text-terminal-muted select-none">$</span> {{ $command }}</code>
    <button
        type="button"
        x-on:click="copy()"
        @class([
            'inline-flex size-8 items-center justify-center rounded-md transition-[color,background-color,scale] duration-200 active:scale-90',
            'text-ink-muted hover:bg-surface-subtle hover:text-ink' => $tone === 'light',
            'bg-white/10 text-on-terminal hover:bg-white/20' => $tone === 'dark',
        ])
    >
        <x-tabler-copy class="size-[15px]" x-show="! copied" aria-hidden="true" />
        <x-tabler-check class="size-[15px]" x-show="copied" x-cloak x-transition:enter="transition duration-300 ease-out-quint" x-transition:enter-start="scale-50 opacity-0" x-transition:enter-end="scale-100 opacity-100" aria-hidden="true" />
        <span class="sr-only" x-text="copied ? 'Copied' : 'Copy command'">Copy command</span>
    </button>
</div>
