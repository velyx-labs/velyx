@props([
    'wordmark' => true,
])

<span {{ $attributes->class('inline-flex items-center gap-2 text-ink') }}>
    <svg viewBox="0 0 64 64" class="size-5 shrink-0" fill="currentColor" aria-hidden="true">
        <path d="M8 0H20L32 30L44 0H56A8 8 0 0 1 64 8V56A8 8 0 0 1 56 64H8A8 8 0 0 1 0 56V8A8 8 0 0 1 8 0Z" />
    </svg>
    @if ($wordmark)
        <span class="font-display text-[22px] leading-none font-bold tracking-[-0.02em]">velyx</span>
    @else
        <span class="sr-only">Velyx</span>
    @endif
</span>
