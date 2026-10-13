@php
    $currentPath = trim(request()->path(), '/');
    $labelsOf = fn (array $section): array => collect($section['items'])
        ->merge(collect($section['groups'])->pluck('items')->flatten(1))
        ->pluck('label')
        ->map(fn (string $label): string => strtolower($label))
        ->values()
        ->all();
    $allLabels = collect($this->sections)->flatMap($labelsOf)->values()->all();
@endphp

<div
    x-data="{ q: '', matches(label) { return this.q === '' || label.includes(this.q.trim().toLowerCase()); } }"
    class="docs-sidebar flex flex-col gap-6 text-sm"
>
    {{-- Filter --}}
    <div class="relative">
        <label for="docs-nav-filter" class="sr-only">Filter the navigation</label>
        <x-lucide-list-filter class="pointer-events-none absolute top-1/2 left-3 size-3.5 -translate-y-1/2 text-muted-foreground" />
        <input
            id="docs-nav-filter"
            x-model="q"
            type="search"
            placeholder="Filter pages…"
            autocomplete="off"
            data-slot="input"
            class="h-9 w-full rounded-md border border-input bg-background pr-3 pl-8 text-sm outline-none placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-2 focus-visible:ring-ring/30"
        />
    </div>

    <nav class="flex flex-col gap-6" aria-label="Documentation">
        @foreach($this->sections as $section)
            <section class="flex flex-col gap-1" x-data="{ labels: @js($labelsOf($section)) }" x-show="labels.some((label) => matches(label))">
                <p class="mb-1 flex items-center justify-between px-2 font-mono text-[10px] uppercase tracking-[0.14em] text-muted-foreground/60">
                    <span>{{ $section['name'] }}</span>
                    @if($section['groups'])
                        <span>{{ collect($section['groups'])->sum(fn ($group) => count($group['items'])) }}</span>
                    @endif
                </p>

                @foreach($section['items'] as $item)
                    @php($active = $currentPath === $item['path'])
                    <a
                        href="{{ $item['url'] }}"
                        wire:navigate
                        x-show="matches(@js(strtolower($item['label'])))"
                        @if($active) data-active aria-current="page" @endif
                        @class([
                            'docs-nav-link flex min-h-8 items-center gap-2.5 rounded-md px-2 py-1 transition-colors',
                            'bg-muted font-medium text-foreground' => $active,
                            'font-normal text-muted-foreground hover:bg-muted/60 hover:text-foreground' => ! $active,
                        ])
                    >
                        @if($item['icon'])
                            <span class="docs-nav-icon inline-flex size-6 shrink-0 items-center justify-center rounded-md border border-border bg-background text-muted-foreground">
                                <x-dynamic-component :component="'lucide-'.$item['icon']" class="size-3.5" />
                            </span>
                        @endif
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach

                @foreach($section['groups'] as $group)
                    @php($groupHasActive = collect($group['items'])->contains('path', $currentPath))
                    <div
                        x-data="{ open: @js($groupHasActive || $loop->first), labels: @js(collect($group['items'])->pluck('label')->map(fn ($label) => strtolower($label))->values()) }"
                        x-show="labels.some((label) => matches(label))"
                        class="flex flex-col"
                    >
                        <button
                            type="button"
                            x-on:click="open = ! open"
                            :aria-expanded="(open || q !== '').toString()"
                            class="flex min-h-8 items-center gap-2 rounded-md px-2 text-left font-medium text-foreground transition-colors hover:bg-muted/60"
                        >
                            <x-lucide-chevron-right class="size-3.5 shrink-0 text-muted-foreground transition-transform duration-150" ::class="(open || q !== '') && 'rotate-90'" />
                            <span class="flex-1">{{ $group['name'] }}</span>
                            <span class="rounded-full border border-border px-1.5 font-mono text-[10px] text-muted-foreground">{{ count($group['items']) }}</span>
                        </button>

                        <div x-show="open || q !== ''" x-collapse.duration.150ms class="ml-[1.05rem] flex flex-col gap-px border-l border-border py-1 pl-2">
                            @foreach($group['items'] as $item)
                                @php($active = $currentPath === $item['path'])
                                <a
                                    href="{{ $item['url'] }}"
                                    wire:navigate
                                    x-show="matches(@js(strtolower($item['label'])))"
                                    @if($active) data-active aria-current="page" @endif
                                    @class([
                                        'docs-nav-link block rounded-md px-2 py-1.5 transition-colors',
                                        'bg-muted font-medium text-foreground' => $active,
                                        'font-normal text-muted-foreground hover:bg-muted/60 hover:text-foreground' => ! $active,
                                    ])
                                >
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </section>
        @endforeach

        <p x-data="{ labels: @js($allLabels) }" x-show="! labels.some((label) => matches(label))" x-cloak class="px-2 text-muted-foreground">
            No page matches “<span x-text="q"></span>”.
        </p>
    </nav>

    {{-- CLI card --}}
    <div class="docs-cli-card neo-fill-blue neo-shadow flex flex-col gap-2.5 rounded-lg border border-border bg-muted p-3.5">
        <div class="flex items-center justify-between gap-2">
            <span class="text-[13px] font-semibold text-foreground">Velyx CLI</span>
            @if($this->cliVersion)
                <span class="rounded-full border border-border bg-background px-1.5 font-mono text-[10px] text-muted-foreground">v{{ $this->cliVersion }}</span>
            @endif
        </div>
        <code class="rounded-md bg-background px-2 py-1.5 font-mono text-xs break-all text-foreground">npx velyx@latest init</code>
        <div class="flex flex-wrap gap-x-3 gap-y-1 text-xs text-muted-foreground">
            <a href="{{ config('velyx-docs.links.gitlab') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 font-normal text-muted-foreground hover:text-foreground"><x-icons.gitlab class="size-3" />GitLab</a>
            <a href="{{ config('velyx-docs.links.support') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 font-normal text-muted-foreground hover:text-foreground"><x-icons.buymeacoffee class="size-3" />Buy me a coffee</a>
        </div>
    </div>
</div>
