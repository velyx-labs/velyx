@php($currentPath = trim(request()->path(), '/'))

<nav class="space-y-7 text-sm" aria-label="Documentation">
    @foreach($this->navigation as $section => $item)
        <div>
            {{-- Section label — recedes, does not compete --}}
            <p class="mb-2 px-2 font-mono text-[10px] uppercase tracking-[0.14em] text-muted-foreground/40">
                {{ $section }}
            </p>

            {{-- Child links — no side stripe, just padding --}}
            <div class="space-y-0.5">
                @foreach(($item['children'] ?? []) as $label => $url)
                    @php($active = $currentPath === trim($url, '/'))
                    <a
                        href="{{ docs_url($url) }}"
                        wire:navigate
                        @class([
                            'block rounded-md px-2 py-1.5 transition-colors',
                            'bg-muted font-medium text-foreground' => $active,
                            'text-muted-foreground hover:bg-muted/60 hover:text-foreground' => ! $active,
                        ])
                    >
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</nav>
