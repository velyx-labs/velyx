<x-docs.layout :title="$title">
    <x-docs.page-header
        eyebrow="Component"
        title="Button"
        description="{{ $componentData['meta']['description'] ?? 'Buttons allow users to perform actions or navigate with a single click.' }}"
    />

    <section>
        <h2 class="text-xl font-semibold">Installation</h2>
        <x-docs.code-tabs
            npm="npx velyx@latest add button"
            pnpm="pnpm dlx velyx@latest add button"
            yarn="yarn dlx velyx@latest add button"
            bun="bunx --bun velyx@latest add button"
        />
    </section>

    <section class="mt-10">
        <div class="mb-4 flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold">Preview</h2>
                <p class="mt-1 text-sm text-muted-foreground">Rendered by the registry preview route, not copied markup.</p>
            </div>
            <x-ui.badge variant="secondary">v{{ $componentData['version'] }}</x-ui.badge>
        </div>

        <x-docs.component-preview name="button" />
    </section>

    <section class="mt-10 grid gap-4 md:grid-cols-2">
        <x-ui.card class="p-5">
            <h2 class="text-lg font-semibold">Variants</h2>
            <div class="mt-4 flex flex-wrap gap-2">
                <x-ui.button>Primary</x-ui.button>
                <x-ui.button variant="secondary">Secondary</x-ui.button>
                <x-ui.button variant="outline">Outline</x-ui.button>
                <x-ui.button variant="ghost">Ghost</x-ui.button>
                <x-ui.button variant="destructive">Delete</x-ui.button>
            </div>
        </x-ui.card>

        <x-ui.card class="p-5">
            <h2 class="text-lg font-semibold">Dependencies</h2>
            <div class="mt-4 space-y-3">
                <div>
                    <p class="text-xs font-medium uppercase tracking-normal text-muted-foreground">Composer</p>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @forelse($componentData['meta']['requires']['composer'] ?? [] as $dependency)
                            <x-ui.badge variant="outline">{{ $dependency }}</x-ui.badge>
                        @empty
                            <span class="text-sm text-muted-foreground">None</span>
                        @endforelse
                    </div>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-normal text-muted-foreground">NPM</p>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @forelse($componentData['meta']['requires']['npm'] ?? [] as $dependency)
                            <x-ui.badge variant="outline">{{ $dependency }}</x-ui.badge>
                        @empty
                            <span class="text-sm text-muted-foreground">None</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </x-ui.card>
    </section>
</x-docs.layout>
