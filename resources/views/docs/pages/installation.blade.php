<x-docs.layout :title="$title">
    <x-docs.page-header
        eyebrow="Getting Started"
        title="Installation"
        description="Install the CLI, initialize Velyx in a Laravel project, then copy components from the registry."
    />

    <div class="prose prose-neutral max-w-none dark:prose-invert">
        <h2>Requirements</h2>
        <p>Velyx expects a modern Laravel application using Blade, Alpine.js, and Tailwind CSS v4.</p>
    </div>

    <x-docs.code-tabs
        npm="npx velyx@latest init"
        pnpm="pnpm dlx velyx@latest init"
        yarn="yarn dlx velyx@latest init"
        bun="bunx --bun velyx@latest init"
    />

    <div class="grid gap-4 md:grid-cols-2">
        <x-ui.card class="p-5">
            <h2 class="text-lg font-semibold">What init does</h2>
            <ul class="mt-3 space-y-2 text-sm leading-6 text-muted-foreground">
                <li>Checks your Laravel environment.</li>
                <li>Creates the Velyx configuration file.</li>
                <li>Prepares the target component directory.</li>
            </ul>
        </x-ui.card>

        <x-ui.card class="p-5">
            <h2 class="text-lg font-semibold">Default output</h2>
            <p class="mt-3 text-sm leading-6 text-muted-foreground">Components are copied into your app so you can edit them directly.</p>
            <code class="mt-4 block rounded-md bg-muted p-3 font-mono text-sm">resources/views/components/ui</code>
        </x-ui.card>
    </div>
</x-docs.layout>
