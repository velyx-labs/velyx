<x-docs.layout :title="$title" :nav-key="$navKey" :around="$around" section="Components">
    <x-docs.page-header section="Components" :title="$title" description="Blade components you copy into your app. Each one is a file you own: read it, change it, keep it.">
    </x-docs.page-header>

    <ul class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        @foreach ($components as $item)
            <li>
                <a href="{{ $item['url'] }}" class="flex h-full flex-col gap-1.5 rounded-lg border border-border bg-surface p-5 transition-colors hover:border-border-strong">
                    <span class="font-semibold text-ink">{{ $item['title'] }}</span>
                    <span class="text-small text-ink-muted">{{ $item['description'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    <p class="docs-prose">
        More components ship during 3.0: textarea, select, checkbox, switch, dialog, dropdown menu, tabs, toast, table and others.
        Follow the <a href="{{ config('docs.repository') }}/releases">releases</a> to see them land.
    </p>
</x-docs.layout>
