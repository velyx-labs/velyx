@php($currentPath = trim(request()->path(), '/'))

<nav class="space-y-6 text-sm custom-scrollbar">
    @foreach($this->navigation as $section => $item)
        <section>
            <a href="{{ docs_url($item['url']) }}" wire:navigate class="mb-2 flex items-center justify-between rounded-md px-2 py-1.5 font-semibold text-foreground hover:bg-accent">
                <span>{{ $section }}</span>
            </a>

            <div class="space-y-0.5 border-l border-border pl-2">
                @foreach(($item['children'] ?? []) as $label => $url)
                    @php($active = $currentPath === trim($url, '/'))
                    <a
                        href="{{ docs_url($url) }}"
                        wire:navigate
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
