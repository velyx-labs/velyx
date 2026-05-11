<x-docs.layout :title="$title">
    <x-docs.page-header
        eyebrow="Getting Started"
        title="Quick Start"
        description="Add your first Velyx component and render it in a Blade view."
    />

    <x-docs.code-tabs
        npm="npx velyx@latest add button"
        pnpm="pnpm dlx velyx@latest add button"
        yarn="yarn dlx velyx@latest add button"
        bun="bunx --bun velyx@latest add button"
    />

    <x-ui.card class="p-5 mt-5">
        <h2 class="text-lg font-semibold">Use the component</h2>
        <p class="mt-2 text-sm leading-6 text-muted-foreground">After the CLI copies the files, render the Blade component from your application.</p>
        <x-docs.code-block>
            <x-ui.button>Save changes</x-ui.button>
</x-docs.code-block>
    </x-ui.card>

    <x-docs.component-preview name="button" />
</x-docs.layout>
