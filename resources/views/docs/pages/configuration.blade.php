<x-docs.layout :title="$title">
    <x-docs.page-header
        eyebrow="Configuration"
        title="Configuration"
        description="Configure Velyx for your Laravel project, adjust project settings, and align the component workflow with your application structure."
    />

    <section class="space-y-10">
        <div>
            <h2 class="text-2xl font-semibold">velyx.json</h2>
            <p class="mt-2 text-sm leading-6 text-muted-foreground">After running init, Velyx creates a configuration file in your project root.</p>
            <pre class="mt-4 overflow-x-auto rounded-lg border bg-muted p-4"><code class="language-json">{
  "version": "x.y.z",
  "theme": "neutral",
  "packageManager": "npm",
  "css": {
    "entry": "resources/css/app.css",
    "velyx": "resources/css/velyx.css"
  },
  "js": {
    "entry": "resources/js/app.js"
  },
  "components": {
    "path": "resources/views/components/ui"
  }
}</code></pre>
        </div>

        <div>
            <h2 class="text-2xl font-semibold">Options</h2>
            <x-ui.table class="mt-4 rounded-lg border">
                <x-ui.table.header class="bg-muted/50">
                    <x-ui.table.row>
                        <x-ui.table.head>Key</x-ui.table.head>
                        <x-ui.table.head>Description</x-ui.table.head>
                        <x-ui.table.head>Default</x-ui.table.head>
                    </x-ui.table.row>
                </x-ui.table.header>
                <x-ui.table.body>
                    <x-ui.table.row>
                        <x-ui.table.cell class="font-mono">theme</x-ui.table.cell>
                        <x-ui.table.cell class="text-muted-foreground">Base color used for generated tokens.</x-ui.table.cell>
                        <x-ui.table.cell class="font-mono">neutral</x-ui.table.cell>
                    </x-ui.table.row>
                    <x-ui.table.row>
                        <x-ui.table.cell class="font-mono">packageManager</x-ui.table.cell>
                        <x-ui.table.cell class="text-muted-foreground">Package manager used in command output and dependency prompts.</x-ui.table.cell>
                        <x-ui.table.cell>Auto-detected</x-ui.table.cell>
                    </x-ui.table.row>
                    <x-ui.table.row>
                        <x-ui.table.cell class="font-mono">css.entry</x-ui.table.cell>
                        <x-ui.table.cell class="text-muted-foreground">Your main CSS entry file.</x-ui.table.cell>
                        <x-ui.table.cell>Auto-detected</x-ui.table.cell>
                    </x-ui.table.row>
                    <x-ui.table.row>
                        <x-ui.table.cell class="font-mono">css.velyx</x-ui.table.cell>
                        <x-ui.table.cell class="text-muted-foreground">Generated Velyx token file.</x-ui.table.cell>
                        <x-ui.table.cell class="font-mono">resources/css/velyx.css</x-ui.table.cell>
                    </x-ui.table.row>
                    <x-ui.table.row>
                        <x-ui.table.cell class="font-mono">components.path</x-ui.table.cell>
                        <x-ui.table.cell class="text-muted-foreground">Where copied Blade components are written.</x-ui.table.cell>
                        <x-ui.table.cell class="font-mono">resources/views/components/ui</x-ui.table.cell>
                    </x-ui.table.row>
                </x-ui.table.body>
            </x-ui.table>
        </div>

        <div>
            <h2 class="text-2xl font-semibold">Custom Paths</h2>
            <p class="mt-2 text-sm leading-6 text-muted-foreground">Edit paths manually if your Laravel app uses a custom structure.</p>
            <pre class="mt-4 overflow-x-auto rounded-lg border bg-muted p-4"><code class="language-json">{
  "css": {
    "entry": "public/css/style.css",
    "velyx": "resources/css/design-tokens.css"
  },
  "js": {
    "entry": "resources/js/main.js"
  },
  "components": {
    "path": "resources/views/ui/components"
  }
}</code></pre>
        </div>

        <x-ui.card class="p-5">
            <h2 class="text-lg font-semibold">Next steps</h2>
            <div class="mt-4 flex flex-wrap gap-3">
                <x-ui.button href="/docs/theming" variant="outline" iconRight="arrow-right">Theming</x-ui.button>
                <x-ui.button href="/docs/components" variant="outline" iconRight="arrow-right">Components</x-ui.button>
                <x-ui.button href="/docs/cli-reference" variant="outline" iconRight="arrow-right">CLI reference</x-ui.button>
            </div>
        </x-ui.card>
    </section>
</x-docs.layout>
