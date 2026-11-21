{{-- Docs search: ⌘K / Ctrl K / "/" opens it. The index (docs.search) loads on first open. --}}
<div
    x-data="{
        open: false,
        query: '',
        entries: null,
        failed: false,
        active: 0,
        show() {
            this.open = true;
            this.active = 0;
            this.load();
            this.$nextTick(() => this.$refs.input.focus());
        },
        hide() {
            this.open = false;
            this.query = '';
        },
        async load() {
            if (this.entries) { return; }
            try {
                const response = await fetch(@js(route('docs.search')), { headers: { Accept: 'application/json' } });
                this.entries = await response.json();
            } catch (error) {
                this.failed = true;
            }
        },
        get results() {
            if (! this.entries) { return []; }
            const query = this.query.trim().toLowerCase();
            if (query === '') {
                return this.entries.filter((entry) => entry.kind === 'page');
            }
            const words = query.split(/\s+/);
            return this.entries
                .map((entry) => {
                    const title = entry.title.toLowerCase();
                    const haystack = `${title} ${entry.page.toLowerCase()} ${entry.group.toLowerCase()}`;
                    if (! words.every((word) => haystack.includes(word))) { return null; }
                    let score = title.startsWith(query) ? 0 : title.includes(query) ? 1 : 2;
                    if (entry.kind === 'page') { score -= 0.5; }
                    return { ...entry, score };
                })
                .filter(Boolean)
                .sort((a, b) => a.score - b.score)
                .slice(0, 20);
        },
        move(step) {
            const count = this.results.length;
            if (count === 0) { return; }
            this.active = (this.active + step + count) % count;
            this.$nextTick(() => this.$refs.list?.querySelector('[aria-selected=true]')?.scrollIntoView({ block: 'nearest' }));
        },
        go() {
            const result = this.results[this.active];
            if (result) { window.location.href = result.url; this.hide(); }
        },
        shortcut(event) {
            const typing = ['INPUT', 'TEXTAREA', 'SELECT'].includes(event.target.tagName) || event.target.isContentEditable;
            if ((event.key === 'k' && (event.metaKey || event.ctrlKey)) || (event.key === '/' && ! typing)) {
                event.preventDefault();
                this.open ? this.hide() : this.show();
            }
        },
    }"
    x-on:keydown.window="shortcut($event)"
    x-init="$watch('query', () => (active = 0))"
>
    <button
        type="button"
        x-on:click="show()"
        class="hidden h-[34px] w-[220px] items-center gap-2 rounded-md border border-border bg-surface-subtle pr-2 pl-3 text-small text-ink-subtle transition-colors hover:border-border-strong hover:text-ink lg:flex"
    >
        <x-tabler-search class="size-3.5" aria-hidden="true" />
        <span class="flex-1 text-left">Search docs…</span>
        <x-site.kbd class="text-ink-subtle">⌘K</x-site.kbd>
    </button>
    <button
        type="button"
        x-on:click="show()"
        class="inline-flex size-[34px] items-center justify-center rounded-md text-ink hover:bg-surface-subtle lg:hidden"
    >
        <x-tabler-search class="size-4" aria-hidden="true" />
        <span class="sr-only">Search docs</span>
    </button>

    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            x-on:keydown.escape.prevent.stop="hide()"
            class="fixed inset-0 z-[60] flex items-start justify-center px-4 pt-[12vh]"
            role="dialog"
            aria-modal="true"
            aria-label="Search documentation"
        >
            <div x-show="open" x-transition.opacity.duration.150ms x-on:click="hide()" class="absolute inset-0 bg-ink/30 backdrop-blur-[2px]"></div>

            <div
                x-show="open"
                x-trap.noscroll="open"
                x-transition:enter="transition duration-200 ease-out-quint"
                x-transition:enter-start="translate-y-2 scale-[0.98] opacity-0"
                x-transition:enter-end="translate-y-0 scale-100 opacity-100"
                class="relative flex max-h-[70vh] w-full max-w-[560px] flex-col overflow-hidden rounded-lg border border-border bg-surface shadow-overlay"
            >
                <div class="flex items-center gap-2.5 border-b border-border px-4">
                    <x-tabler-search class="size-4 shrink-0 text-ink-subtle" aria-hidden="true" />
                    <input
                        x-ref="input"
                        x-model="query"
                        x-on:keydown.down.prevent="move(1)"
                        x-on:keydown.up.prevent="move(-1)"
                        x-on:keydown.enter.prevent="go()"
                        type="search"
                        placeholder="Search pages and sections…"
                        aria-label="Search documentation"
                        aria-controls="docs-search-results"
                        autocomplete="off"
                        spellcheck="false"
                        class="h-12 flex-1 bg-transparent text-body text-ink outline-none placeholder:text-ink-subtle [&::-webkit-search-cancel-button]:hidden"
                    >
                    <x-site.kbd>Esc</x-site.kbd>
                </div>

                <ul x-ref="list" id="docs-search-results" role="listbox" aria-label="Results" class="flex-1 overflow-y-auto p-1.5">
                    <template x-for="(result, index) in results" :key="result.url">
                        <li
                            role="option"
                            x-bind:aria-selected="index === active"
                            x-on:mousemove="active = index"
                            x-on:click="go()"
                            x-bind:class="index === active ? 'bg-surface-subtle text-ink' : 'text-ink-muted'"
                            class="flex cursor-pointer items-center gap-3 rounded-md px-3 py-2.5"
                        >
                            <span class="grid size-7 shrink-0 place-items-center rounded-md border border-border bg-surface text-ink-subtle">
                                <x-tabler-file-text class="size-3.5" x-show="result.kind === 'page'" aria-hidden="true" />
                                <x-tabler-hash class="size-3.5" x-show="result.kind === 'heading'" aria-hidden="true" />
                            </span>
                            <span class="flex min-w-0 flex-1 flex-col">
                                <span class="truncate text-control font-medium text-ink" x-text="result.title"></span>
                                <span class="truncate text-small text-ink-subtle" x-text="result.kind === 'page' ? result.group : `${result.group} › ${result.page}`"></span>
                            </span>
                            <x-tabler-corner-down-left class="size-3.5 shrink-0 text-ink-subtle" x-show="index === active" aria-hidden="true" />
                        </li>
                    </template>
                </ul>

                <p x-show="entries && results.length === 0" class="px-4 py-10 text-center text-control text-ink-subtle">
                    No results for “<span x-text="query"></span>”.
                </p>
                <p x-show="! entries && ! failed" class="px-4 py-10 text-center text-control text-ink-subtle">Loading…</p>
                <p x-show="failed" class="px-4 py-10 text-center text-control text-ink-subtle">The search index could not be loaded.</p>

                <div class="flex items-center gap-4 border-t border-border bg-surface-subtle px-4 py-2 text-xs text-ink-subtle">
                    <span class="flex items-center gap-1.5"><x-site.kbd>↑</x-site.kbd><x-site.kbd>↓</x-site.kbd> to move</span>
                    <span class="flex items-center gap-1.5"><x-site.kbd>↵</x-site.kbd> to open</span>
                </div>
            </div>
        </div>
    </template>
</div>
