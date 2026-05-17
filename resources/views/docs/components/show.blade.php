<?php
use Livewire\Component;

new class extends Component {
};
?>

<x-docs.layout :title="$title">
    <x-docs.page-header
        eyebrow="Component"
        title="{{ Str::headline($componentName) }}"
        description="{{ $componentData['meta']['description'] ?? 'Velyx component.' }}"
    />

    <x-docs.code-tabs
        npm="npx velyx@latest add {{ $componentName }}"
        pnpm="pnpm dlx velyx@latest add {{ $componentName }}"
        yarn="yarn dlx velyx@latest add {{ $componentName }}"
        bun="bunx --bun velyx@latest add {{ $componentName }}"
    />

    <x-docs.component-preview :name="$componentName" />
</x-docs.layout>
