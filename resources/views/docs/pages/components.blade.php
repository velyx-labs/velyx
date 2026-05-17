<?php
use Livewire\Component;

new class extends Component {
};
?>

<x-docs.layout :title="$title">
    <x-docs.page-header
        eyebrow="Components"
        title="Component Library"
        description="Browse the Velyx components available from the registry. Each page is backed by the same metadata and preview routes used by the CLI and documentation."
    />

    <div class="mb-6 flex items-center justify-between gap-4">
        <p class="text-sm text-muted-foreground">{{ count($components) }} components available</p>
        <x-ui.button href="{{ route('components.index') }}" variant="outline" size="sm" iconRight="arrow-up-right">Registry API</x-ui.button>
    </div>

    <div class="grid gap-3 sm:grid-cols-2">
        @foreach($components as $name => $component)
            <a href="{{ route('docs.components.show', $name) }}" wire:navigate class="group rounded-lg border bg-card p-4 transition-colors hover:bg-accent/40">
                <div class="flex items-center justify-between gap-3">
                    <span class="font-medium">{{ Str::headline($name) }}</span>
                    <x-lucide-arrow-right class="size-4 text-muted-foreground transition-transform group-hover:translate-x-0.5" />
                </div>
                <p class="mt-2 line-clamp-2 text-sm leading-6 text-muted-foreground">
                    {{ $component['meta']['description'] ?? 'Velyx component.' }}
                </p>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach(($component['meta']['categories'] ?? []) as $category)
                        <x-ui.badge variant="outline" size="sm">{{ $category }}</x-ui.badge>
                    @endforeach
                </div>
            </a>
        @endforeach
    </div>
</x-docs.layout>
