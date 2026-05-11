@props([
    'name',
    'variant' => null,
    'height' => '220px',
])

@php
    $query = array_filter(['variant' => $variant]);
    $src = route('preview.component', ['component' => $name] + $query);
    $sourceUrl = url('/api/v1/previews/'.$name.'/source'.($variant ? '?variant='.$variant : ''));
@endphp

<div
    class="my-6 overflow-hidden rounded-lg border bg-card"
    x-data="{
        previewOpen: false,
        mode: 'preview',
        source: '',
        sourcePath: '',
        sourceLoading: false,
        sourceError: '',
        async showCode() {
            this.mode = 'code';

            if (this.source || this.sourceLoading) {
                this.highlightCode();
                return;
            }

            this.sourceLoading = true;
            this.sourceError = '';

            try {
                const response = await fetch('{{ $sourceUrl }}', {
                    headers: { Accept: 'application/json' },
                });
                const json = await response.json();

                if (!response.ok) {
                    throw new Error(json.error || 'Preview source not found');
                }

                this.source = json.data.source;
                this.sourcePath = json.data.path;
                this.highlightCode();
            } catch (error) {
                this.sourceError = error.message || 'Unable to load preview source';
            } finally {
                this.sourceLoading = false;
            }
        },
        highlightCode() {
            this.$nextTick(() => {
                if (window.Prism) {
                    window.Prism.highlightAllUnder(this.$root);
                }
            });
        },
    }"
    x-on:keydown.escape.window="previewOpen = false"
>
    <div class="flex items-center justify-between border-b bg-muted/30 px-4 py-2">
        <div class="flex items-center gap-2">
            <x-ui.badge variant="secondary">{{ $name }}</x-ui.badge>
            @if($variant)
                <span class="text-xs text-muted-foreground">{{ $variant }}</span>
            @endif
        </div>
        <div class="flex items-center gap-1">
            <x-ui.button type="button" variant="ghost" size="sm" iconRight="code-2" x-on:click="showCode()">Code</x-ui.button>
            <x-ui.button type="button" variant="ghost" size="sm" iconRight="maximize-2" x-on:click="previewOpen = true">Preview</x-ui.button>
        </div>
    </div>

    <div x-show="mode === 'preview'">
        <iframe
            src="{{ $src }}"
            title="{{ $name }} preview"
            class="block w-full bg-background"
            style="height: {{ $height }}"
            loading="lazy"
        ></iframe>
    </div>

    <div x-show="mode === 'code'" x-cloak class="border-t bg-muted/20">
        <div class="flex items-center justify-between border-b px-4 py-2">
            <span class="truncate font-mono text-xs text-muted-foreground" x-text="sourcePath || 'preview source'"></span>
            <x-ui.button type="button" variant="ghost" size="sm" iconRight="eye" x-on:click="mode = 'preview'">Preview</x-ui.button>
        </div>
        <div x-show="sourceLoading" class="p-4 text-sm text-muted-foreground">Loading source...</div>
        <div x-show="sourceError" class="p-4 text-sm text-destructive" x-text="sourceError"></div>
        <pre x-show="source && !sourceLoading" class="max-h-[420px] overflow-auto bg-muted p-4 text-sm"><code class="language-php" x-text="source"></code></pre>
    </div>

    <template x-teleport="body">
        <div
            x-show="previewOpen"
            x-cloak
            class="fixed inset-0 z-[80] overflow-y-auto bg-background/80 p-4 backdrop-blur-sm sm:p-6"
            role="dialog"
            aria-modal="true"
            aria-label="{{ $name }} preview"
        >
            <div
                x-show="previewOpen"
                x-transition.opacity
                class="fixed inset-0"
                x-on:click="previewOpen = false"
            ></div>

            <div
                x-show="previewOpen"
                x-transition:enter="duration-150 ease-out"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="duration-100 ease-in"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative mx-auto flex min-h-[calc(100vh-2rem)] max-w-6xl flex-col overflow-hidden rounded-xl border bg-background shadow-2xl sm:min-h-[calc(100vh-3rem)]"
            >
                <div class="flex items-center justify-between border-b bg-muted/30 px-4 py-3">
                    <div class="flex min-w-0 items-center gap-2">
                        <x-ui.badge variant="secondary">{{ $name }}</x-ui.badge>
                        @if($variant)
                            <span class="truncate text-sm text-muted-foreground">{{ $variant }}</span>
                        @endif
                    </div>

                    <div class="flex items-center gap-1">
                        <x-ui.button type="button" variant="ghost" size="sm" iconRight="eye" x-on:click="mode = 'preview'">Preview</x-ui.button>
                        <x-ui.button type="button" variant="ghost" size="sm" iconRight="code-2" x-on:click="showCode()">Code</x-ui.button>
                        <x-ui.button type="button" variant="ghost" size="sm" icon="x" iconOnly title="Close preview" x-on:click="previewOpen = false" />
                    </div>
                </div>

                <iframe
                    x-show="mode === 'preview'"
                    src="{{ $src }}"
                    title="{{ $name }} expanded preview"
                    class="min-h-0 flex-1 bg-background"
                    loading="lazy"
                ></iframe>

                <div x-show="mode === 'code'" x-cloak class="min-h-0 flex-1 overflow-hidden bg-muted/20">
                    <div class="border-b px-4 py-2">
                        <span class="truncate font-mono text-xs text-muted-foreground" x-text="sourcePath || 'preview source'"></span>
                    </div>
                    <div x-show="sourceLoading" class="p-4 text-sm text-muted-foreground">Loading source...</div>
                    <div x-show="sourceError" class="p-4 text-sm text-destructive" x-text="sourceError"></div>
                    <pre x-show="source && !sourceLoading" class="h-full overflow-auto bg-muted p-4 text-sm"><code class="language-php" x-text="source"></code></pre>
                </div>
            </div>
        </div>
    </template>
</div>
