@props([
    'manifest',
])

<div class="flex flex-wrap gap-1.5 text-xs font-medium text-ink-muted">
    <span class="rounded-sm border border-border bg-surface px-2 py-[3px] font-mono">v{{ $manifest['version'] }}</span>
    <span class="rounded-sm border border-border bg-surface px-2 py-[3px]">Laravel {{ ltrim($manifest['requires']['laravel'] ?? '>=10', '>=') }}+</span>
    @foreach ($manifest['dependencies']['components'] ?? [] as $dependency)
        <span class="rounded-sm border border-border bg-surface px-2 py-[3px]">Uses {{ $dependency }}</span>
    @endforeach
</div>
