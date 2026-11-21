@php
    $examples = [
        'default' => 'Default',
        'with-label' => ['With label', 'Pair the input with a label through <code>id</code> and <code>for</code>.'],
        'sizes' => 'Sizes',
        'disabled' => 'Disabled',
        'invalid' => ['Invalid', 'Connect the message with <code>aria-describedby</code> so screen readers announce it.'],
        'file' => 'File',
    ];
    $toc = [
        'installation' => 'Installation',
        'usage' => 'Usage',
        ...collect($examples)->map(fn (string|array $example): string => is_array($example) ? $example[0] : $example)->all(),
        'validation' => 'Validation',
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

    <x-docs.example name="input.preview" />

    <x-docs.section id="installation" title="Installation">
        <x-docs.install :manifest="$manifest" />
    </x-docs.section>

    <x-docs.section id="usage" title="Usage">
        <x-docs.code>
            @verbatim
            <x-ui.input name="email" type="email" :value="old('email')" />

            <x-ui.input wire:model="email" type="email" />
            @endverbatim
        </x-docs.code>
    </x-docs.section>

    <x-docs.examples group="input" :examples="$examples" />

    <x-docs.section id="validation" title="Validation">
        <p class="docs-prose">
            The input looks up its field in the Laravel error bag: <code>name</code> first, then the <code>wire:model</code> property.
            When there is an error it sets <code>aria-invalid="true"</code> and turns red. Pass <code>:invalid</code> to decide yourself.
        </p>
        <x-docs.code file="resources/views/profile.blade.php">
            @verbatim
            <x-ui.input name="email" type="email" />
            @error('email')
                <p class="text-sm text-destructive">{{ $message }}</p>
            @enderror
            @endverbatim
        </x-docs.code>
    </x-docs.section>


    <x-docs.section id="api" title="API reference">
        <x-docs.props name="x-ui.input" :rows="[
            ['type', 'string', 'text', 'Native input type.'],
            ['size', 'sm | md | lg', 'md', 'Height and text size.'],
            ['name', 'string', 'none', 'Field name, also used to find validation errors.'],
            ['invalid', 'bool | null', 'null', 'Forces the invalid state. When null, it follows the error bag.'],
        ]" />
        <p class="docs-prose">Any other attribute (<code>placeholder</code>, <code>wire:model</code>, <code>disabled</code>…) is passed to the <code>&lt;input&gt;</code>.</p>
    </x-docs.section>

    <x-docs.section id="a11y" title="Accessibility">
        <p class="docs-prose">
            Pair every input with a <a href="{{ route('docs.component', 'label') }}">label</a> through <code>id</code> and <code>for</code>.
            To announce the error message, give it an <code>id</code> and add <code>aria-describedby</code> to the input.
        </p>
    </x-docs.section>
</x-docs.layout>
