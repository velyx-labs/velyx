@php
    $baseColors = [
        ['Background', '--background', 'Page and app surface color.'],
        ['Foreground', '--foreground', 'Primary text and icon color.'],
    ];

    $semanticColors = [
        ['Primary', '--primary', '--primary-foreground', 'bg-primary text-primary-foreground', 'Main actions, links, and high-emphasis controls.'],
        ['Secondary', '--secondary', '--secondary-foreground', 'bg-secondary text-secondary-foreground', 'Secondary actions and lower-emphasis UI.'],
        ['Muted', '--muted', '--muted-foreground', 'bg-muted text-muted-foreground', 'Subtle backgrounds, help text, and disabled states.'],
        ['Accent', '--accent', '--accent-foreground', 'bg-accent text-accent-foreground', 'Hover states and interactive highlights.'],
        ['Destructive', '--destructive', '--destructive-foreground', 'bg-destructive text-destructive-foreground', 'Dangerous actions like delete or remove.'],
    ];

    $borderColors = [
        ['Border', '--border', 'Borders around cards, tables, separators, and panels.'],
        ['Input', '--input', 'Input and form control borders.'],
        ['Ring', '--ring', 'Focus rings and keyboard navigation outlines.'],
    ];

    $chartColors = ['--chart-1', '--chart-2', '--chart-3', '--chart-4', '--chart-5'];
@endphp

<x-docs.layout :title="$title">
    <x-docs.page-header
        eyebrow="Design"
        title="Colors"
        description="Velyx uses OKLCH tokens for consistent surfaces, actions, borders, charts, and dark mode."
    />

    <div class="space-y-12">
        <section class="space-y-4">
            <div class="space-y-2">
                <h2 class="text-2xl font-semibold tracking-tight">Color Tokens</h2>
                <p class="max-w-2xl text-sm leading-6 text-muted-foreground">
                    Components do not hard-code colors. They consume CSS variables, so themes can change without rewriting component markup.
                </p>
            </div>

            <x-ui.card class="overflow-hidden">
                <x-ui.table>
                    <x-ui.table.header>
                        <x-ui.table.row>
                            <x-ui.table.head>Token</x-ui.table.head>
                            <x-ui.table.head>Preview</x-ui.table.head>
                            <x-ui.table.head>Usage</x-ui.table.head>
                        </x-ui.table.row>
                    </x-ui.table.header>
                    <x-ui.table.body>
                        @foreach ($baseColors as [$label, $token, $description])
                            <x-ui.table.row>
                                <x-ui.table.cell>
                                    <div class="font-medium">{{ $label }}</div>
                                    <code class="text-xs text-muted-foreground">{{ $token }}</code>
                                </x-ui.table.cell>
                                <x-ui.table.cell>
                                    <span class="block h-8 w-20 rounded-md border" style="background: var({{ $token }});"></span>
                                </x-ui.table.cell>
                                <x-ui.table.cell class="text-muted-foreground">{{ $description }}</x-ui.table.cell>
                            </x-ui.table.row>
                        @endforeach
                    </x-ui.table.body>
                </x-ui.table>
            </x-ui.card>

            <pre class="overflow-x-auto rounded-lg border bg-muted p-4"><code class="language-css">:root {
  --background: oklch(1 0 0);
  --foreground: oklch(0.145 0 0);
}</code></pre>
        </section>

        <section class="space-y-4">
            <div class="space-y-2">
                <h2 class="text-2xl font-semibold tracking-tight">Semantic Colors</h2>
                <p class="max-w-2xl text-sm leading-6 text-muted-foreground">
                    Semantic pairs define the background and readable foreground for common component states.
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                @foreach ($semanticColors as [$label, $token, $foreground, $classes, $description])
                    <x-ui.card class="overflow-hidden">
                        <div class="{{ $classes }} p-5">
                            <div class="text-sm font-semibold">{{ $label }}</div>
                            <div class="mt-1 font-mono text-xs opacity-80">{{ $token }} / {{ $foreground }}</div>
                        </div>
                        <x-ui.card.content class="py-5">
                            <p class="text-sm leading-6 text-muted-foreground">{{ $description }}</p>
                        </x-ui.card.content>
                    </x-ui.card>
                @endforeach
            </div>

            <pre class="overflow-x-auto rounded-lg border bg-muted p-4"><code class="language-css">--primary: oklch(0.205 0 0);
--primary-foreground: oklch(0.985 0 0);

--secondary: oklch(0.97 0 0);
--secondary-foreground: oklch(0.205 0 0);

--muted: oklch(0.97 0 0);
--muted-foreground: oklch(0.556 0 0);

--accent: oklch(0.97 0 0);
--accent-foreground: oklch(0.205 0 0);

--destructive: oklch(0.58 0.22 27);</code></pre>
        </section>

        <section class="space-y-4">
            <h2 class="text-2xl font-semibold tracking-tight">Border Colors</h2>

            <x-ui.card class="overflow-hidden">
                <x-ui.table>
                    <x-ui.table.header>
                        <x-ui.table.row>
                            <x-ui.table.head>Token</x-ui.table.head>
                            <x-ui.table.head>Preview</x-ui.table.head>
                            <x-ui.table.head>Usage</x-ui.table.head>
                        </x-ui.table.row>
                    </x-ui.table.header>
                    <x-ui.table.body>
                        @foreach ($borderColors as [$label, $token, $description])
                            <x-ui.table.row>
                                <x-ui.table.cell>
                                    <div class="font-medium">{{ $label }}</div>
                                    <code class="text-xs text-muted-foreground">{{ $token }}</code>
                                </x-ui.table.cell>
                                <x-ui.table.cell>
                                    <span class="block h-8 w-20 rounded-md border-2" style="border-color: var({{ $token }});"></span>
                                </x-ui.table.cell>
                                <x-ui.table.cell class="text-muted-foreground">{{ $description }}</x-ui.table.cell>
                            </x-ui.table.row>
                        @endforeach
                    </x-ui.table.body>
                </x-ui.table>
            </x-ui.card>

            <pre class="overflow-x-auto rounded-lg border bg-muted p-4"><code class="language-css">--border: oklch(0.922 0 0);
--input: oklch(0.922 0 0);
--ring: oklch(0.708 0 0);</code></pre>
        </section>

        <section class="grid gap-4 lg:grid-cols-2">
            <x-ui.card>
                <x-ui.card.header>
                    <x-ui.card.title>Component Colors</x-ui.card.title>
                    <x-ui.card.description>Surface tokens used by cards, popovers, and floating panels.</x-ui.card.description>
                </x-ui.card.header>
                <x-ui.card.content class="pb-6">
                    <pre class="overflow-x-auto rounded-lg border bg-muted p-4"><code class="language-css">--card: oklch(1 0 0);
--card-foreground: oklch(0.145 0 0);
--popover: oklch(1 0 0);
--popover-foreground: oklch(0.145 0 0);</code></pre>
                </x-ui.card.content>
            </x-ui.card>

            <x-ui.card>
                <x-ui.card.header>
                    <x-ui.card.title>Using Colors</x-ui.card.title>
                    <x-ui.card.description>Reference Tailwind utility names generated from the Velyx tokens.</x-ui.card.description>
                </x-ui.card.header>
                <x-ui.card.content class="pb-6">
                    <pre class="overflow-x-auto rounded-lg border bg-muted p-4"><code class="language-php">&lt;button class="bg-primary text-primary-foreground hover:bg-primary/90"&gt;
    Click me
&lt;/button&gt;

&lt;div class="rounded-lg border border-border bg-card p-4 text-card-foreground"&gt;
    Card content
&lt;/div&gt;</code></pre>
                </x-ui.card.content>
            </x-ui.card>
        </section>

        <section class="space-y-4">
            <div class="space-y-2">
                <h2 class="text-2xl font-semibold tracking-tight">Dark Mode</h2>
                <p class="max-w-2xl text-sm leading-6 text-muted-foreground">
                    Dark mode is activated by adding the <code class="rounded bg-muted px-1.5 py-0.5 text-xs">.dark</code> class to the HTML element.
                </p>
            </div>

            <pre class="overflow-x-auto rounded-lg border bg-muted p-4"><code class="language-css">.dark {
  --background: oklch(0.145 0 0);
  --foreground: oklch(0.985 0 0);
  --primary: oklch(0.87 0 0);
  --primary-foreground: oklch(0.205 0 0);
}</code></pre>

            <x-ui.card class="border-primary/30 bg-primary/5 p-5">
                <div class="text-sm font-semibold text-foreground">Automatic Dark Mode</div>
                <p class="mt-2 text-sm leading-6 text-muted-foreground">
                    Components keep the same classes in both themes. Only token values change, so contrast and surfaces adapt automatically.
                </p>
            </x-ui.card>
        </section>

        <section class="space-y-4">
            <div class="space-y-2">
                <h2 class="text-2xl font-semibold tracking-tight">Chart Colors</h2>
                <p class="max-w-2xl text-sm leading-6 text-muted-foreground">
                    Velyx includes chart tokens for data visualizations and dashboard widgets.
                </p>
            </div>

            <div class="grid gap-3 sm:grid-cols-5">
                @foreach ($chartColors as $token)
                    <x-ui.card class="overflow-hidden">
                        <span class="block h-20" style="background: var({{ $token }});"></span>
                        <div class="p-3 font-mono text-xs text-muted-foreground">{{ $token }}</div>
                    </x-ui.card>
                @endforeach
            </div>

            <pre class="overflow-x-auto rounded-lg border bg-muted p-4"><code class="language-css">--chart-1: oklch(0.809 0.105 251.813);
--chart-2: oklch(0.623 0.214 259.815);
--chart-3: oklch(0.546 0.245 262.881);
--chart-4: oklch(0.488 0.243 264.376);
--chart-5: oklch(0.424 0.199 265.638);</code></pre>
        </section>

        <section class="grid gap-4 md:grid-cols-3">
            <a href="/docs/design/typography" wire:navigate>
                <x-ui.card class="h-full p-5 transition hover:border-primary/50">
                    <div class="font-semibold">Typography</div>
                    <p class="mt-2 text-sm leading-6 text-muted-foreground">Text scale, rhythm, and font usage.</p>
                </x-ui.card>
            </a>
            <a href="/docs/design/spacing" wire:navigate>
                <x-ui.card class="h-full p-5 transition hover:border-primary/50">
                    <div class="font-semibold">Spacing</div>
                    <p class="mt-2 text-sm leading-6 text-muted-foreground">Layout spacing and density rules.</p>
                </x-ui.card>
            </a>
            <a href="/docs/theming" wire:navigate>
                <x-ui.card class="h-full p-5 transition hover:border-primary/50">
                    <div class="font-semibold">Theming</div>
                    <p class="mt-2 text-sm leading-6 text-muted-foreground">Override tokens for your brand.</p>
                </x-ui.card>
            </a>
        </section>
    </div>
</x-docs.layout>
