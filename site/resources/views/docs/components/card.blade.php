@php
    $examples = [
        'simple' => 'Header only',
        'with-badge' => ['With content', 'Use <code>as</code> to render a <code>&lt;section&gt;</code> or an <code>&lt;article&gt;</code>.'],
    ];
    $toc = [
        'installation' => 'Installation',
        'usage' => 'Usage',
        ...collect($examples)->map(fn (string|array $example): string => is_array($example) ? $example[0] : $example)->all(),
        'api' => 'API reference',
    ];
@endphp

<x-docs.layout
    :title="$title"
    :nav-key="$navKey"
    :around="$around"
    section="Components"
    :toc="$toc"
>
    <x-docs.page-header section="Components" :section-url="route('docs.components')" :title="$title" :description="$manifest['description']">
        <x-docs.badges :manifest="$manifest" />
    </x-docs.page-header>

    <x-docs.example name="card.preview" stage="min-h-[360px]" />

    <x-docs.section id="installation" title="Installation">
        <x-docs.install :manifest="$manifest" />
    </x-docs.section>

    <x-docs.section id="usage" title="Usage">
        <p class="docs-prose">Every part is optional. Use the ones you need, in this order.</p>
        <x-docs.code>
            @verbatim
            <x-ui.card>
                <x-ui.card.header>
                    <x-ui.card.title>Title</x-ui.card.title>
                    <x-ui.card.description>Description</x-ui.card.description>
                </x-ui.card.header>
                <x-ui.card.content>Content</x-ui.card.content>
                <x-ui.card.footer>Footer</x-ui.card.footer>
            </x-ui.card>
            @endverbatim
        </x-docs.code>
    </x-docs.section>

    <x-docs.examples group="card" :examples="$examples" />

    <x-docs.section id="api" title="API reference">
        <x-docs.props name="x-ui.card" :rows="[
            ['as', 'string', 'div', 'Root element, for example section or article.'],
        ]" />
        <x-docs.props name="x-ui.card.title" :rows="[
            ['as', 'string', 'h3', 'Heading level that fits your page outline.'],
        ]" />
        <p class="docs-prose"><code>header</code>, <code>description</code>, <code>content</code> and <code>footer</code> take no props. Every part passes other attributes to its root element.</p>
    </x-docs.section>
</x-docs.layout>
