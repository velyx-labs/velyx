@props([
    'title',
    'navKey',
    'around' => ['previous' => null, 'next' => null],
    'toc' => [],
    'section' => null,
])

@php
    $sections = app(\App\Docs\Navigation::class)->sections();
@endphp

<x-layouts::app :title="$title.' · Velyx docs'">
    <div x-data="{ nav: false }" x-on:keydown.escape.window="nav = false">
        <x-site.header />

        <div class="sticky top-[60px] z-30 flex items-center gap-3 border-b border-border bg-canvas/90 px-4 py-2 backdrop-blur md:hidden">
            <button type="button" x-on:click="nav = true" class="inline-flex h-8 items-center gap-1.5 rounded-md px-2 text-small font-medium text-ink hover:bg-surface-subtle">
                <x-tabler-layout-sidebar class="size-4" aria-hidden="true" />
                Menu
            </button>
            <span class="truncate text-small text-ink-subtle">{{ $section }} / <span class="font-semibold text-ink">{{ $title }}</span></span>
        </div>

        <div
            x-show="nav"
            x-cloak
            x-transition.opacity
            x-on:click="nav = false"
            class="fixed inset-0 z-50 bg-ink/40 md:hidden"
        ></div>
        <div
            x-show="nav"
            x-cloak
            x-transition:enter="transition duration-300 ease-out-quint"
            x-transition:enter-start="-translate-x-full"
            x-transition:leave="transition duration-200 ease-in"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 z-50 w-[280px] overflow-y-auto border-r border-border bg-canvas px-4 py-5 md:hidden"
            role="dialog"
            aria-label="Documentation"
        >
            <div class="mb-4 flex items-center justify-between">
                <x-logo />
                <button type="button" x-on:click="nav = false" class="inline-flex size-8 items-center justify-center rounded-md hover:bg-surface-subtle">
                    <x-tabler-x class="size-4" aria-hidden="true" />
                    <span class="sr-only">Close menu</span>
                </button>
            </div>
            <x-docs.sidebar :sections="$sections" :current="$navKey" />
        </div>

        <div class="mx-auto flex max-w-[1400px] gap-10 px-4 sm:px-8">
            <aside aria-label="Documentation" class="sticky top-[60px] hidden h-[calc(100vh-60px)] w-[232px] shrink-0 overflow-y-auto py-7 md:block">
                <x-docs.sidebar :sections="$sections" :current="$navKey" />
            </aside>

            <main class="flex min-w-0 flex-1 items-start gap-14 pt-9 pb-24">
                <article class="flex min-w-0 max-w-[760px] flex-1 flex-col gap-11">
                    {{ $slot }}

                    <nav aria-label="Pagination" class="mt-4 grid grid-cols-2 gap-4 border-t border-border pt-8">
                        <div>
                            @if ($around['previous'])
                                <a href="{{ $around['previous']['url'] }}" class="group flex flex-col gap-1 rounded-lg border border-border p-4 hover:border-border-strong">
                                    <span class="text-small text-ink-subtle">Previous</span>
                                    <span class="font-semibold text-ink">← {{ $around['previous']['title'] }}</span>
                                </a>
                            @endif
                        </div>
                        <div>
                            @if ($around['next'])
                                <a href="{{ $around['next']['url'] }}" class="group flex flex-col items-end gap-1 rounded-lg border border-border p-4 text-right hover:border-border-strong">
                                    <span class="text-small text-ink-subtle">Next</span>
                                    <span class="font-semibold text-ink">{{ $around['next']['title'] }} →</span>
                                </a>
                            @endif
                        </div>
                    </nav>
                </article>

                @if ($toc)
                    <x-docs.toc :items="$toc" />
                @endif
            </main>
        </div>

        <footer class="border-t border-border">
            <div class="mx-auto flex max-w-[1400px] flex-wrap justify-between gap-3 px-4 py-6 text-small text-ink-subtle sm:px-8">
                <span>MIT License · Velyx v3</span>
                <span>
                    Looking for v2?
                    <a href="https://github.com/velyx-labs/velyx/tree/2.x" class="text-ink underline underline-offset-[3px]">v2 documentation</a>
                </span>
            </div>
        </footer>
    </div>
</x-layouts::app>
