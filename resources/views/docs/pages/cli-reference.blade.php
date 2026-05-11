<x-docs.layout :title="$title">
    <x-docs.page-header
        eyebrow="CLI"
        title="CLI Reference"
        description="Reference for Velyx CLI commands, installation flows, and day-to-day component management in Laravel projects."
    />

    <section class="space-y-10">
        <div>
            <h2 class="text-2xl font-semibold">Global Options</h2>
            <p class="mt-2 text-sm leading-6 text-muted-foreground">Display the installed CLI version.</p>
            <pre class="mt-4 overflow-x-auto rounded-lg border bg-muted p-4"><code class="language-bash">velyx --version
velyx -v</code></pre>
        </div>

        <div>
            <h2 class="text-2xl font-semibold">Initialize Velyx</h2>
            <p class="mt-2 text-sm leading-6 text-muted-foreground">Creates `velyx.json`, checks your environment, and prepares the component target path.</p>
            <x-docs.code-tabs
                npm="npx velyx@latest init"
                pnpm="pnpm dlx velyx@latest init"
                yarn="yarn dlx velyx@latest init"
                bun="bunx --bun velyx@latest init"
            />

            <x-ui.table class="mt-4 rounded-lg border">
                <x-ui.table.header class="bg-muted/50">
                    <x-ui.table.row>
                        <x-ui.table.head>Option</x-ui.table.head>
                        <x-ui.table.head>Alias</x-ui.table.head>
                        <x-ui.table.head>Description</x-ui.table.head>
                    </x-ui.table.row>
                </x-ui.table.header>
                <x-ui.table.body>
                    <x-ui.table.row>
                        <x-ui.table.cell class="font-mono">--base-color</x-ui.table.cell>
                        <x-ui.table.cell class="font-mono">-b</x-ui.table.cell>
                        <x-ui.table.cell class="text-muted-foreground">Base color: neutral, gray, zinc, stone, slate.</x-ui.table.cell>
                    </x-ui.table.row>
                    <x-ui.table.row>
                        <x-ui.table.cell class="font-mono">--defaults</x-ui.table.cell>
                        <x-ui.table.cell class="font-mono">-d</x-ui.table.cell>
                        <x-ui.table.cell class="text-muted-foreground">Use default configuration.</x-ui.table.cell>
                    </x-ui.table.row>
                    <x-ui.table.row>
                        <x-ui.table.cell class="font-mono">--force</x-ui.table.cell>
                        <x-ui.table.cell class="font-mono">-f</x-ui.table.cell>
                        <x-ui.table.cell class="text-muted-foreground">Overwrite existing configuration.</x-ui.table.cell>
                    </x-ui.table.row>
                    <x-ui.table.row>
                        <x-ui.table.cell class="font-mono">--cwd</x-ui.table.cell>
                        <x-ui.table.cell class="font-mono">-c</x-ui.table.cell>
                        <x-ui.table.cell class="text-muted-foreground">Working directory.</x-ui.table.cell>
                    </x-ui.table.row>
                </x-ui.table.body>
            </x-ui.table>
        </div>

        <div>
            <h2 class="text-2xl font-semibold">Add Components</h2>
            <p class="mt-2 text-sm leading-6 text-muted-foreground">Copies component files into your app and handles required dependencies and conflicts.</p>
            <x-docs.code-tabs
                npm="npx velyx@latest add button"
                pnpm="pnpm dlx velyx@latest add button"
                yarn="yarn dlx velyx@latest add button"
                bun="bunx --bun velyx@latest add button"
            />
            <x-docs.code-tabs
                npm="npx velyx@latest add card input dialog"
                pnpm="pnpm dlx velyx@latest add card input dialog"
                yarn="yarn dlx velyx@latest add card input dialog"
                bun="bunx --bun velyx@latest add card input dialog"
            />
            <x-docs.code-tabs
                npm="npx velyx@latest add --all"
                pnpm="pnpm dlx velyx@latest add --all"
                yarn="yarn dlx velyx@latest add --all"
                bun="bunx --bun velyx@latest add --all"
            />
        </div>

        <div>
            <h2 class="text-2xl font-semibold">List and Search</h2>
            <p class="mt-2 text-sm leading-6 text-muted-foreground">Inspect available registry components from the command line.</p>
            <x-docs.code-tabs
                npm="npx velyx@latest list"
                pnpm="pnpm dlx velyx@latest list"
                yarn="yarn dlx velyx@latest list"
                bun="bunx --bun velyx@latest list"
            />
            <x-docs.code-tabs
                npm="npx velyx@latest list --query button"
                pnpm="pnpm dlx velyx@latest list --query button"
                yarn="yarn dlx velyx@latest list --query button"
                bun="bunx --bun velyx@latest list --query button"
            />
            <x-docs.code-tabs
                npm="npx velyx@latest list --json"
                pnpm="pnpm dlx velyx@latest list --json"
                yarn="yarn dlx velyx@latest list --json"
                bun="bunx --bun velyx@latest list --json"
            />
        </div>
    </section>
</x-docs.layout>
