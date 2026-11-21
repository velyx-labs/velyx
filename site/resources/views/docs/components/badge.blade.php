@php
    $examples = [
        'default' => 'Default',
        'secondary' => 'Secondary',
        'outline' => 'Outline',
        'success' => ['Success', 'Status variants use the theme status colors. Keep a word in the badge: color alone does not carry meaning.'],
        'warning' => 'Warning',
        'info' => 'Info',
        'destructive' => 'Destructive',
    ];
    $toc = [
        'installation' => 'Installation',
        'usage' => 'Usage',
        ...collect($examples)->map(fn (string|array $example): string => is_array($example) ? $example[0] : $example)->all(),
        'api' => 'API reference',
        'a11y' => 'Accessibility',
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

    <x-docs.example name="badge.preview" stage="min-h-[200px]" />

    <x-docs.section id="installation" title="Installation">
        <x-docs.install :manifest="$manifest" />
    </x-docs.section>

    <x-docs.section id="usage" title="Usage">
        <x-docs.code>
            @verbatim
            <x-ui.badge variant="outline">Draft</x-ui.badge>
            @endverbatim
        </x-docs.code>
    </x-docs.section>

    <x-docs.examples group="badge" :examples="$examples" />


    <x-docs.section id="api" title="API reference">
        <x-docs.props name="x-ui.badge" :rows="[
            ['variant', 'default | secondary | outline | success | warning | info | destructive', 'default', 'Visual style.'],
            ['icon', 'string', 'none', 'Leading icon, by Velyx icon name.'],
        ]" />
    </x-docs.section>

    <x-docs.section id="a11y" title="Accessibility">
        <p class="docs-prose">A plain <code>&lt;span&gt;</code>; its icon is hidden from screen readers. For a count that changes live, wrap it in an element with <code>aria-live="polite"</code>.</p>
    </x-docs.section>
</x-docs.layout>
