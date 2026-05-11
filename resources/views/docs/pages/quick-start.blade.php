<x-docs.layout :title="$title">
    <x-docs.page-header
        eyebrow="Getting Started"
        title="Quick Start"
        description="Add your first Velyx component, understand the workflow, and move from documentation to implementation quickly in Laravel."
    />

    <section class="space-y-10">
        <div>
            <h2 class="text-2xl font-semibold">1. Initialize Velyx</h2>
            <p class="mt-2 text-sm leading-6 text-muted-foreground">Run the init command from your Laravel project root.</p>
            <x-docs.code-tabs
                npm="npx velyx@latest init"
                pnpm="pnpm dlx velyx@latest init"
                yarn="yarn dlx velyx@latest init"
                bun="bunx --bun velyx@latest init"
            />

            <p class="text-sm leading-6 text-muted-foreground">For a non-interactive setup with defaults:</p>
            <x-docs.code-tabs
                npm="npx velyx@latest init --defaults"
                pnpm="pnpm dlx velyx@latest init --defaults"
                yarn="yarn dlx velyx@latest init --defaults"
                bun="bunx --bun velyx@latest init --defaults"
            />
        </div>

        <div>
            <h2 class="text-2xl font-semibold">2. Add a Component</h2>
            <p class="mt-2 text-sm leading-6 text-muted-foreground">Use the CLI to copy a component into your application.</p>
            <x-docs.code-tabs
                npm="npx velyx@latest add button"
                pnpm="pnpm dlx velyx@latest add button"
                yarn="yarn dlx velyx@latest add button"
                bun="bunx --bun velyx@latest add button"
            />

            <x-ui.card class="p-5">
                <h3 class="font-semibold">This command will</h3>
                <ul class="mt-3 space-y-2 text-sm leading-6 text-muted-foreground">
                    <li>Copy the button component files to your project.</li>
                    <li>Prompt for required dependencies when needed.</li>
                    <li>Handle file conflicts before overwriting code.</li>
                </ul>
            </x-ui.card>
        </div>

        <div>
            <h2 class="text-2xl font-semibold">3. List or Search Components</h2>
            <p class="mt-2 text-sm leading-6 text-muted-foreground">Explore available registry components directly from your terminal.</p>
            <x-docs.code-tabs
                npm="npx velyx@latest list"
                pnpm="pnpm dlx velyx@latest list"
                yarn="yarn dlx velyx@latest list"
                bun="bunx --bun velyx@latest list"
            />
        </div>

        <div>
            <h2 class="text-2xl font-semibold">4. Use the Component</h2>
            <p class="mt-2 text-sm leading-6 text-muted-foreground">The copied component is now available in your Blade templates.</p>
            <pre class="mt-4 overflow-x-auto rounded-lg border bg-muted p-4"><code class="language-php">&lt;x-button&gt;Click me&lt;/x-button&gt;

&lt;x-button variant="secondary"&gt;Secondary Action&lt;/x-button&gt;

&lt;x-button variant="outline" size="sm"&gt;Small Button&lt;/x-button&gt;</code></pre>

            <x-docs.component-preview name="button" />
        </div>

        <div>
            <h2 class="text-2xl font-semibold">5. Customize</h2>
            <p class="mt-2 text-sm leading-6 text-muted-foreground">Components are copied directly into your project, so you can customize markup, classes, and behavior.</p>
            <pre class="mt-4 overflow-x-auto rounded-lg border bg-muted p-4"><code class="language-php">@verbatim&lt;!-- resources/views/components/button.blade.php --&gt;

@props([
    'variant' =&gt; 'default',
    'size' =&gt; 'default',
])

&lt;button class="..." &#123;&#123; $attributes &#125;&#125;&gt;
    &#123;&#123; $slot &#125;&#125;
&lt;/button&gt;@endverbatim</code></pre>
        </div>

        <x-ui.card class="p-5">
            <h2 class="text-lg font-semibold">Next steps</h2>
            <div class="mt-4 flex flex-wrap gap-3">
                <x-ui.button href="{{ route('docs.page', 'components') }}" variant="outline" iconRight="arrow-right">Explore components</x-ui.button>
                <x-ui.button href="{{ route('docs.page', 'theming') }}" variant="outline" iconRight="arrow-right">Learn theming</x-ui.button>
                <x-ui.button href="{{ route('docs.page', 'cli-reference') }}" variant="outline" iconRight="arrow-right">Read CLI reference</x-ui.button>
            </div>
        </x-ui.card>
    </section>
</x-docs.layout>
