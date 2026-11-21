@props([
    'code' => null,
    'file' => null,
    'numbers' => true,
    'icon' => 'file-code',
])

@php
    $code ??= \App\Docs\Highlighter::dedent((string) $slot);
    $lines = app(\App\Docs\Highlighter::class)->lines($code);
@endphp

<div {{ $attributes->class('relative overflow-hidden rounded-xl border border-border bg-[#f6f7f8] dark:bg-surface') }}>
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

    <pre class="m-0 overflow-x-auto py-4 font-mono text-[13px] leading-[23px] text-ink"><code>@foreach ($lines as $line)<span class="block pr-12 whitespace-pre">@if ($numbers)<span class="inline-block w-[42px] pr-5 text-right text-ink-subtle/70 select-none">{{ $loop->iteration }}</span>@else<span class="inline-block w-4"></span>@endif{!! $line === '' ? ' ' : $line !!}</span>@endforeach</code></pre>
</div>
