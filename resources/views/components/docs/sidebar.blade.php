@php
    $navigation = config('velyx-docs.navigation', []);
    $currentPath = trim(request()->path(), '/');
@endphp

<nav class="space-y-6 text-sm">
    <div class="lg:hidden">
        <x-ui.input placeholder="Search docs..." icon="search" aria-label="Search docs" />
    </div>

    @foreach($navigation as $section => $item)
        <section>
            <a
                href="/{{ $item['url'] }}"
                class="mb-2 flex items-center justify-between rounded-md px-2 py-1.5 font-semibold text-foreground hover:bg-accent"
            >
                <span>{{ $section }}</span>
            </a>

            <div class="space-y-0.5 border-l border-border pl-2">
                @foreach(($item['children'] ?? []) as $label => $url)
                    @php $active = $currentPath === trim($url, '/'); @endphp
                    <a
                        href="/{{ $url }}"
                        @class([
                            'block rounded-md px-2 py-1.5 transition-colors',
                            'bg-accent font-medium text-accent-foreground' => $active,
                            'text-muted-foreground hover:bg-accent/70 hover:text-foreground' => ! $active,
                        ])
                    >
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </section>
    @endforeach
</nav>
