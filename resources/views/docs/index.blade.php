<x-docs.layout :title="$title">
    <x-docs.page-header
        eyebrow="Docs"
        title="Build Laravel interfaces with code you own"
        description="Velyx ships Blade, Alpine.js, and Tailwind CSS components through a registry API. The docs now run inside the same Laravel app that serves the registry, so the product uses its own components."
    />

    <div class="grid gap-4 md:grid-cols-3">
        <x-ui.card class="p-5">
            <x-ui.badge variant="primary" icon="terminal">CLI</x-ui.badge>
            <h2 class="mt-4 text-lg font-semibold">Install from the registry</h2>
            <p class="mt-2 text-sm leading-6 text-muted-foreground">Use the CLI to fetch components, resolve dependencies, and copy files into your Laravel app.</p>
            <x-ui.button href="{{ route('docs.page', 'quick-start') }}" variant="outline" size="sm" class="mt-5" iconRight="arrow-right">Quick start</x-ui.button>
        </x-ui.card>

        <x-ui.card class="p-5">
            <x-ui.badge variant="secondary" icon="box">Components</x-ui.badge>
            <h2 class="mt-4 text-lg font-semibold">Dogfooded UI</h2>
            <p class="mt-2 text-sm leading-6 text-muted-foreground">Docs pages render with the same Blade components distributed by Velyx.</p>
            <x-ui.button href="{{ route('docs.components.show', 'button') }}" variant="outline" size="sm" class="mt-5" iconRight="arrow-right">View button</x-ui.button>
        </x-ui.card>

        <x-ui.card class="p-5">
            <x-ui.badge variant="outline" icon="database">Registry</x-ui.badge>
            <h2 class="mt-4 text-lg font-semibold">One source of truth</h2>
            <p class="mt-2 text-sm leading-6 text-muted-foreground">Metadata, previews, API responses, and documentation live in one Laravel project boundary.</p>
            <x-ui.button href="{{ route('components.index') }}" variant="outline" size="sm" class="mt-5" iconRight="arrow-up-right">API index</x-ui.button>
        </x-ui.card>
    </div>

    <section class="mt-10">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-xl font-semibold">Available components</h2>
            <x-ui.badge variant="secondary">{{ count($components) }} components</x-ui.badge>
        </div>

        <div class="grid gap-2 sm:grid-cols-2 xl:grid-cols-3">
            @foreach($components as $name => $component)
                <a href="{{ route('docs.components.show', $name) }}" class="group rounded-lg border bg-card p-4 transition-colors hover:bg-accent/40">
                    <div class="flex items-center justify-between gap-3">
                        <span class="font-medium">{{ Str::headline($name) }}</span>
                        <x-lucide-arrow-right class="size-4 text-muted-foreground transition-transform group-hover:translate-x-0.5" />
                    </div>
                    <p class="mt-2 line-clamp-2 text-sm leading-6 text-muted-foreground">{{ $component['meta']['description'] ?? 'Velyx component.' }}</p>
                </a>
            @endforeach
        </div>
    </section>
</x-docs.layout>
