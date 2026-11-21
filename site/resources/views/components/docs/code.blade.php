@props([
    'code' => null,
    'file' => null,
    'numbers' => true,
    'icon' => 'file-code',
    'lang' => null,
    // Long code starts folded to about 16 lines, with an Expand button.
    'expandable' => false,
])

@php
    $code ??= \App\Docs\Highlighter::dedent((string) $slot);
    $lines = app(\App\Docs\Highlighter::class)->lines($code);
    $lang ??= match (true) {
        $file === 'Terminal' => 'bash',
        str_ends_with((string) $file, '.blade.php') => 'blade',
        default => pathinfo((string) $file, PATHINFO_EXTENSION) ?: 'blade',
    };
    $folds = $expandable && count($lines) > 20;
@endphp

<div
    data-md-code="{{ $code }}"
    data-md-lang="{{ $lang }}"
    @if ($file && $file !== 'Terminal') data-md-title="{{ $file }}" @endif
    @if ($folds) x-data="{ expanded: false }" @endif
    {{ $attributes->class('relative overflow-hidden rounded-xl border border-border bg-[#f6f7f8] dark:bg-surface') }}
>
    @if ($file)
        <div class="flex h-11 items-center justify-between gap-3 border-b border-border pr-2 pl-3.5 font-mono text-[12.5px] text-ink-muted">
            <span class="flex min-w-0 items-center gap-2">
                <x-dynamic-component :component="'tabler-'.$icon" class="size-[15px] shrink-0" aria-hidden="true" />
                <span class="truncate">{{ $file }}</span>
            </span>
            <x-docs.copy-button :text="$code" />
        </div>
    @else
        <x-docs.copy-button :text="$code" class="absolute top-2 right-2 z-10" />
    @endif

    <pre
        @if ($folds) x-bind:class="{ 'max-h-96 overflow-y-hidden': ! expanded }" @endif
        @class(['m-0 overflow-x-auto py-4 font-mono text-[13px] leading-[23px] text-ink', 'max-h-96 overflow-y-hidden' => $folds])
    ><code>@foreach ($lines as $line)<span class="block pr-12 whitespace-pre">@if ($numbers)<span class="inline-block w-[42px] pr-5 text-right text-ink-subtle/70 select-none">{{ $loop->iteration }}</span>@else<span class="inline-block w-4"></span>@endif{!! $line === '' ? ' ' : $line !!}</span>@endforeach</code></pre>

    @if ($folds)
        <div
            x-bind:class="{
                'absolute inset-x-0 bottom-0 h-32 bg-linear-to-b from-transparent to-[#f6f7f8] pb-4 dark:to-surface': ! expanded,
                'relative border-t border-border py-3': expanded,
            }"
            class="absolute inset-x-0 bottom-0 flex h-32 items-end justify-center bg-linear-to-b from-transparent to-[#f6f7f8] pb-4 dark:to-surface"
        >
            <button
                type="button"
                x-on:click="expanded = ! expanded"
                x-bind:aria-expanded="expanded"
                class="h-[30px] rounded-md border border-border bg-surface px-3.5 text-small font-medium text-ink shadow-xs hover:bg-surface-subtle"
                x-text="expanded ? 'Collapse' : 'Expand'"
            >Expand</button>
        </div>
    @endif
</div>
