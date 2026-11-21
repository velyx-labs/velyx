@php
    $examples = [
        'required' => ['Required', 'The asterisk is hidden from screen readers; set <code>required</code> on the input.'],
        'hint' => 'With hint',
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

    <x-docs.example name="label.preview" />

    <x-docs.section id="installation" title="Installation">
        <x-docs.install :manifest="$manifest" />
    </x-docs.section>

    <x-docs.section id="usage" title="Usage">
        <x-docs.code>
            @verbatim
            <x-ui.label for="project" required hint="Shown in the URL">Project name</x-ui.label>
            <x-ui.input id="project" name="project" />
            @endverbatim
        </x-docs.code>
    </x-docs.section>

    <x-docs.examples group="label" :examples="$examples" />

    <x-docs.section id="api" title="API reference">
        <x-docs.props name="x-ui.label" :rows="[
            ['required', 'bool', 'false', 'Adds a red asterisk after the text. It is hidden from screen readers; set required on the input.'],
            ['hint', 'string', 'none', 'Muted text after the label, such as “optional”.'],
        ]" />
    </x-docs.section>

    <x-docs.section id="a11y" title="Accessibility">
        <p class="docs-prose">
            A native <code>&lt;label&gt;</code>. Set <code>for</code> to the input's <code>id</code> so clicking the label focuses the field
            and screen readers announce it.
        </p>
    </x-docs.section>
</x-docs.layout>
