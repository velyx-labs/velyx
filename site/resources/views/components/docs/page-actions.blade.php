@props([
    'around' => ['previous' => null, 'next' => null],
])

{{--
    Beside the page title: copy the page as Markdown (with a menu to view it
    or hand it to an assistant), then previous / next arrows.
--}}
@php
    $markdownUrl = url()->current().'.md';
    $prompt = 'Read '.$markdownUrl.' so I can ask questions about it.';
    $assistants = [
        'Claude' => 'https://claude.ai/new?q='.rawurlencode($prompt),
        'ChatGPT' => 'https://chatgpt.com/?hints=search&q='.rawurlencode($prompt),
    ];
    $iconButton = 'inline-flex size-8 items-center justify-center rounded-md border border-border bg-surface text-ink transition-colors hover:bg-surface-subtle';
@endphp

<div data-md="skip" {{ $attributes->class('flex shrink-0 items-center gap-2') }}>
    <div
        x-data="{
            open: false,
            copied: false,
            async copy() {
                const text = fetch(@js($markdownUrl)).then((response) => response.text());
                try {
                    await navigator.clipboard.write([
                        new ClipboardItem({ 'text/plain': text.then((body) => new Blob([body], { type: 'text/plain' })) }),
                    ]);
                } catch (error) {
                    await navigator.clipboard.writeText(await text);
                }
                this.copied = true;
                setTimeout(() => (this.copied = false), 1600);
            },
        }"
        x-on:keydown.escape="open = false"
        x-on:click.outside="open = false"
        class="relative flex"
    >
        <button
            type="button"
            x-on:click="copy()"
            class="inline-flex h-8 items-center gap-1.5 rounded-l-md border border-border bg-surface px-2.5 text-small font-medium text-ink transition-colors hover:bg-surface-subtle"
        >
            <x-tabler-copy class="size-3.5" x-show="! copied" aria-hidden="true" />
            <x-tabler-check class="size-3.5 text-success" x-show="copied" x-cloak aria-hidden="true" />
            <span x-text="copied ? 'Copied' : 'Copy page'">Copy page</span>
        </button>
        <button
            type="button"
            x-on:click="open = ! open"
            x-bind:aria-expanded="open"
            aria-haspopup="menu"
            class="-ml-px inline-flex size-8 items-center justify-center rounded-r-md border border-border bg-surface text-ink transition-colors hover:bg-surface-subtle"
        >
            <x-tabler-chevron-down class="size-3.5 transition-transform" x-bind:class="open && 'rotate-180'" aria-hidden="true" />
            <span class="sr-only">More ways to use this page</span>
        </button>

        <div
            x-show="open"
            x-cloak
            x-transition.origin.top.right
            role="menu"
            class="absolute top-[calc(100%+6px)] right-0 z-40 flex w-56 flex-col rounded-lg border border-border bg-surface p-1 text-small shadow-lg"
        >
            <a role="menuitem" href="{{ $markdownUrl }}" target="_blank" class="flex items-center gap-2.5 rounded-md px-2.5 py-2 text-ink hover:bg-surface-subtle">
                <x-tabler-markdown class="size-4 text-ink-muted" aria-hidden="true" />
                View as Markdown
            </a>
            @foreach ($assistants as $name => $url)
                <a role="menuitem" href="{{ $url }}" target="_blank" rel="noopener" class="flex items-center gap-2.5 rounded-md px-2.5 py-2 text-ink hover:bg-surface-subtle">
                    <x-tabler-message-chatbot class="size-4 text-ink-muted" aria-hidden="true" />
                    Open in {{ $name }}
                    <x-tabler-arrow-up-right class="ml-auto size-3.5 text-ink-subtle" aria-hidden="true" />
                </a>
            @endforeach
        </div>
    </div>

    @foreach (['previous' => 'chevron-left', 'next' => 'chevron-right'] as $direction => $icon)
        @if ($around[$direction] ?? null)
            <a href="{{ $around[$direction]['url'] }}" class="{{ $iconButton }}" title="{{ ucfirst($direction) }}: {{ $around[$direction]['title'] }}">
                <x-dynamic-component :component="'tabler-'.$icon" class="size-4" aria-hidden="true" />
                <span class="sr-only">{{ ucfirst($direction) }}: {{ $around[$direction]['title'] }}</span>
            </a>
        @else
            <span class="{{ $iconButton }} pointer-events-none opacity-40" aria-hidden="true">
                <x-dynamic-component :component="'tabler-'.$icon" class="size-4" />
            </span>
        @endif
    @endforeach
</div>
