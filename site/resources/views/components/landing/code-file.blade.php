@props([
    'name',
    'language',
])

<x-site.card {{ $attributes->class('overflow-hidden') }}>
    <div class="flex justify-between border-b border-border bg-surface-subtle px-4 py-2.5 font-mono text-xs">
        <span class="text-ink-muted">{{ $name }}</span>
        <span class="text-ink-subtle">{{ $language }}</span>
    </div>
    <pre class="m-0 overflow-x-auto p-4 font-mono text-code"><code>{{ $slot }}</code></pre>
</x-site.card>
