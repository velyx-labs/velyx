<x-docs.layout :title="$title">
    <x-docs.page-header
        eyebrow="Design"
        title="Theming"
        description="Customize Velyx components to match your brand with Tailwind CSS v4 utilities and CSS variables."
    />

    <section class="space-y-10">
        <div>
            <h2 class="text-2xl font-semibold">Design Tokens</h2>
            <p class="mt-2 text-sm leading-6 text-muted-foreground">Velyx uses CSS variables for semantic colors, radius, spacing, and component states.</p>
            <pre class="mt-4 overflow-x-auto rounded-lg border bg-muted p-4"><code class="language-css">:root {
  --background: oklch(1 0 0);
  --foreground: oklch(0.145 0 0);
  --primary: oklch(0.205 0 0);
  --primary-foreground: oklch(0.985 0 0);
  --border: oklch(0.922 0 0);
  --radius: 0.625rem;
}</code></pre>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <x-ui.card class="p-5">
                <h2 class="text-lg font-semibold">Dark mode</h2>
                <p class="mt-2 text-sm leading-6 text-muted-foreground">Add the `dark` class to the HTML element. Components read the same semantic variables in both themes.</p>
                <pre class="mt-4 overflow-x-auto rounded-lg bg-muted p-4"><code class="language-php">&lt;html class="dark"&gt;</code></pre>
            </x-ui.card>

            <x-ui.card class="p-5">
                <h2 class="text-lg font-semibold">Copied code</h2>
                <p class="mt-2 text-sm leading-6 text-muted-foreground">Components are copied into your app, so theme overrides and component edits stay under your control.</p>
                <x-ui.button href="{{ route('docs.page', 'configuration') }}" variant="outline" class="mt-4" iconRight="arrow-right">Configuration</x-ui.button>
            </x-ui.card>
        </div>

        <div>
            <h2 class="text-2xl font-semibold">Custom Component Variant</h2>
            <pre class="mt-4 overflow-x-auto rounded-lg border bg-muted p-4"><code class="language-php">@verbatim@php
$variants = [
    'primary' => 'bg-primary text-primary-foreground hover:bg-primary/90',
    'gradient' => 'bg-gradient-to-r from-primary to-accent text-white',
];
@endphp@endverbatim</code></pre>
        </div>

        <x-ui.card class="p-5">
            <h2 class="text-lg font-semibold">Design guides</h2>
            <div class="mt-4 flex flex-wrap gap-3">
                <x-ui.button href="{{ route('docs.page', 'design/colors') }}" variant="outline" iconRight="arrow-right">Colors</x-ui.button>
                <x-ui.button href="{{ route('docs.page', 'design/typography') }}" variant="outline" iconRight="arrow-right">Typography</x-ui.button>
                <x-ui.button href="{{ route('docs.page', 'design/spacing') }}" variant="outline" iconRight="arrow-right">Spacing</x-ui.button>
            </div>
        </x-ui.card>
    </section>
</x-docs.layout>
