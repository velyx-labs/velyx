@props([
    'items' => app(\App\Support\DocsSearchIndex::class)->items(),
])

<div
    x-data="{
        open: false,
        query: '',
        active: 0,
        items: @js($items),
        get results() {
            const q = this.query.trim().toLowerCase();

            if (! q) {
                return this.items.slice(0, 8);
            }

            return this.items
                .filter((item) => `${item.title} ${item.section} ${item.description}`.toLowerCase().includes(q))
                .sort((a, b) => Number(b.title.toLowerCase().startsWith(q)) - Number(a.title.toLowerCase().startsWith(q)))
                .slice(0, 12);
        },
        show() {
            this.open = true;
            this.active = 0;
            this.$nextTick(() => this.$refs.input.focus());
        },
        hide() {
            this.open = false;
            this.query = '';
        },
        move(step) {
            const count = this.results.length;

            if (count) {
                this.active = (this.active + step + count) % count;
            }
        },
        go() {
            const item = this.results[this.active];

            if (item) {
                this.hide();
                window.location.href = item.url;
            }
        },
    }"
    x-on:keydown.meta.k.window.prevent="show()"
    x-on:keydown.ctrl.k.window.prevent="show()"
    {{ $attributes->class('site-search') }}
>
    <button
        type="button"
        x-on:click="show()"
        class="inline-flex h-9 items-center gap-2 rounded-md border border-border bg-muted px-2.5 text-sm text-muted-foreground transition-colors hover:text-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring sm:w-56 sm:px-3"
        aria-label="Search documentation"
    >
        <x-lucide-search class="size-4 shrink-0" />
        <span class="hidden flex-1 text-left sm:inline">Search docs…</span>
        <kbd class="hidden rounded border border-border bg-background px-1.5 font-mono text-[10px] sm:inline">⌘K</kbd>
    </button>

    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            x-transition.opacity.duration.150ms
            x-on:click.self="hide()"
            x-on:keydown.escape.window="hide()"
            class="fixed inset-0 z-[100] flex items-start justify-center bg-foreground/40 p-4 pt-[12vh] backdrop-blur-sm"
        >
            <div
                role="dialog"
                aria-modal="true"
                aria-label="Search documentation"
                data-slot="dialog-content"
                class="w-full max-w-xl overflow-hidden rounded-xl border border-border bg-popover text-popover-foreground shadow-2xl"
            >
                <div class="flex items-center gap-3 border-b border-border px-4">
                    <x-lucide-search class="size-4 shrink-0 text-muted-foreground" />
                    <input
                        x-ref="input"
                        x-model="query"
                        x-on:input="active = 0"
                        x-on:keydown.arrow-down.prevent="move(1)"
                        x-on:keydown.arrow-up.prevent="move(-1)"
                        x-on:keydown.enter.prevent="go()"
                        type="search"
                        placeholder="Search docs and components…"
                        aria-label="Search docs and components"
                        class="h-12 w-full bg-transparent text-sm outline-none placeholder:text-muted-foreground"
                    />
                    <button
                        type="button"
                        x-on:click="hide()"
                        class="rounded border border-border px-1.5 py-0.5 font-mono text-[10px] text-muted-foreground hover:text-foreground"
                    >ESC</button>
                </div>

                <ul class="max-h-[60vh] overflow-y-auto p-2" role="listbox" aria-label="Search results">
                    <template x-for="(item, index) in results" :key="item.url">
                        <li role="option" :aria-selected="index === active">
                            <a
                                :href="item.url"
                                x-on:mouseenter="active = index"
                                :class="index === active ? 'bg-accent text-accent-foreground' : ''"
                                class="flex flex-col gap-0.5 rounded-md px-3 py-2.5"
                            >
                                <span class="flex items-center justify-between gap-3">
                                    <span class="text-sm font-medium" x-text="item.title"></span>
                                    <span class="shrink-0 font-mono text-[10px] uppercase tracking-wider text-muted-foreground" x-text="item.section"></span>
                                </span>
                                <span x-show="item.description" class="line-clamp-1 text-xs text-muted-foreground" x-text="item.description"></span>
                            </a>
                        </li>
                    </template>
                    <li x-show="results.length === 0" class="px-3 py-8 text-center text-sm text-muted-foreground">
                        No results for “<span x-text="query"></span>”.
                    </li>
                </ul>
            </div>
        </div>
    </template>
</div>
