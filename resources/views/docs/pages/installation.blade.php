<?php
use Livewire\Component;

new class extends Component {
};
?>

<x-docs.layout :title="$title">
    <x-docs.page-header
        eyebrow="Getting Started"
        title="Installation"
        description="Get Velyx working in your Laravel project in under 2 minutes."
    />

    <section class="space-y-10">
        <div>
            <h2 class="text-2xl font-semibold">Requirements</h2>
            <p class="mt-3 text-muted-foreground">Velyx is built for modern Laravel projects using:</p>
            <ul class="mt-4 space-y-2 text-sm leading-6 text-muted-foreground">
                <li><strong>Laravel 10+</strong> — Livewire components work on Laravel 10 and above.</li>
                <li><strong>Blade</strong> — Velyx components are Blade templates, not abstractions.</li>
                <li><strong>Tailwind CSS v4</strong> — Components use Tailwind utilities. v3 requires config adjustments.</li>
                <li><strong>Alpine.js 3+</strong> — For interactive components (optional; use Livewire for more complex state).</li>
            </ul>
        </div>

        <div>
            <h2 class="text-2xl font-semibold">Step 1: Initialize Velyx</h2>
            <p class="mt-3 text-muted-foreground">Run the init command from your Laravel project root.</p>
            <x-docs.code-tabs
                npm="npx velyx@latest init"
                pnpm="pnpm dlx velyx@latest init"
                yarn="yarn dlx velyx@latest init"
                bun="bunx --bun velyx@latest init"
            />
            <p class="mt-4 text-sm text-muted-foreground">For a non-interactive setup with defaults:</p>
            <x-docs.code-tabs
                npm="npx velyx@latest init --defaults"
                pnpm="pnpm dlx velyx@latest init --defaults"
                yarn="yarn dlx velyx@latest init --defaults"
                bun="bunx --bun velyx@latest init --defaults"
            />
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <x-ui.card class="p-5">
                <h3 class="text-lg font-semibold">What init does</h3>
                <ul class="mt-3 space-y-2 text-sm leading-6 text-muted-foreground">
                    <li>✓ Validates your Laravel setup</li>
                    <li>✓ Creates <code class="rounded bg-muted px-1">velyx.json</code> config</li>
                    <li>✓ Sets up component directory</li>
                    <li>✓ Prepares file structure for components</li>
                </ul>
            </x-ui.card>

            <x-ui.card class="p-5">
                <h3 class="text-lg font-semibold">Configuration</h3>
                <p class="mt-3 text-sm leading-6 text-muted-foreground">The init command creates a <code class="rounded bg-muted px-1">velyx.json</code> file with sensible defaults. You can customize paths, styles, or component names later.</p>
                <x-ui.button href="{{ route('docs.page', 'configuration') }}" wire:navigate variant="outline" size="sm" class="mt-4" iconRight="arrow-right">View config options</x-ui.button>
            </x-ui.card>
        </div>

        <div>
            <h2 class="text-2xl font-semibold">Step 2: Add Your First Component</h2>
            <p class="mt-3 text-muted-foreground">Use the CLI to copy a component into your app.</p>
            <x-docs.code-tabs
                npm="npx velyx@latest add button"
                pnpm="pnpm dlx velyx@latest add button"
                yarn="yarn dlx velyx@latest add button"
                bun="bunx --bun velyx@latest add button"
            />
            <p class="mt-4 text-sm text-muted-foreground">The button component (and any dependencies) are now copied to your <code class="rounded bg-muted px-1">resources/views/components/ui/</code> directory. No packages, just code you own.</p>
        </div>

        <div>
            <h2 class="text-2xl font-semibold">Step 3: Use It</h2>
            <p class="mt-3 text-muted-foreground">Import and use your component in any Blade template.</p>
            <pre class="mt-4 overflow-x-auto rounded-lg border bg-muted p-4"><code class="language-html">&lt;x-ui.button&gt;Click me&lt;/x-ui.button&gt;

&lt;x-ui.button variant="outline" size="lg"&gt;
  Large outline button
&lt;/x-ui.button&gt;</code></pre>
        </div>

        <x-ui.card class="p-5">
            <h2 class="text-lg font-semibold">What's next?</h2>
            <p class="mt-3 text-sm leading-6 text-muted-foreground">Now that Velyx is set up, explore the component library, learn about theming, or dive into the CLI reference.</p>
            <div class="mt-5 flex flex-wrap gap-3">
                <x-ui.button href="{{ route('docs.page', 'quick-start') }}" wire:navigate variant="primary" iconRight="arrow-right">Quick start guide</x-ui.button>
                <x-ui.button href="{{ route('docs.page', 'components') }}" wire:navigate variant="outline" iconRight="arrow-right">Browse components</x-ui.button>
            </div>
        </x-ui.card>
    </section>
</x-docs.layout>
