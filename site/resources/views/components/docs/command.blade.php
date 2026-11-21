@props([
    'command',
])

@php
    $runners = [
        'npx' => 'npx '.$command,
        'pnpm' => 'pnpm dlx '.$command,
        'bun' => 'bunx '.$command,
        'velyx' => $command,
    ];
@endphp

<div
    data-md-code="{{ $runners['npx'] }}"
    data-md-lang="bash"
    x-data="{
        runners: @js($runners),
        runner: 'npx',
        copied: false,
        copy() {
            navigator.clipboard.writeText(this.runners[this.runner]).then(() => {
                this.copied = true;
                setTimeout(() => (this.copied = false), 1600);
            });
        },
    }"
    {{ $attributes->class('overflow-hidden rounded-xl border border-border bg-[#f6f7f8] dark:bg-surface') }}
>
    <div class="flex h-11 items-center justify-between gap-3 border-b border-border pr-2 pl-3.5">
        <div class="flex items-center gap-2">
            <x-tabler-terminal-2 class="size-[15px] text-ink-muted" aria-hidden="true" />
            <div role="tablist" aria-label="Package runner" class="flex gap-0.5">
                @foreach (array_keys($runners) as $runner)
                    <button
                        type="button"
                        role="tab"
                        x-on:click="runner = @js($runner)"
                        x-bind:aria-selected="runner === @js($runner)"
                        x-bind:class="runner === @js($runner) ? 'bg-surface text-ink ring-1 ring-border dark:bg-surface-subtle' : 'text-ink-subtle hover:text-ink'"
                        class="h-[26px] rounded-md px-2.5 font-mono text-xs transition-colors"
                    >{{ $runner }}</button>
                @endforeach
            </div>
        </div>
        <button
            type="button"
            x-on:click="copy()"
            class="inline-flex size-[30px] items-center justify-center rounded-md text-ink-subtle transition-[color,background-color,scale] duration-200 hover:bg-border/60 hover:text-ink active:scale-90"
        >
            <x-tabler-copy class="size-[15px]" x-show="! copied" aria-hidden="true" />
            <x-tabler-check class="size-[15px] text-success" x-show="copied" x-cloak aria-hidden="true" />
            <span class="sr-only" x-text="copied ? 'Copied' : 'Copy command'">Copy command</span>
        </button>
    </div>
    <pre class="m-0 overflow-x-auto px-4 py-4 font-mono text-[13px] leading-[23px] text-ink"><code x-text="runners[runner]">{{ $runners['npx'] }}</code></pre>
</div>
