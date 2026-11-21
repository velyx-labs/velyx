@php
    $examples = [
        'default' => 'Default',
        'secondary' => 'Secondary',
        'outline' => 'Outline',
        'ghost' => 'Ghost',
        'destructive' => ['Destructive', 'For actions that delete or cannot be undone.'],
        'link' => 'Link',
        'sizes' => ['Sizes', 'Three heights, plus <code>icon</code> for a square button.'],
        'icon' => ['Icon', 'Icon-only buttons need an <code>aria-label</code>.'],
        'with-icon' => ['With icon', '<code>icon</code> and <code>icon-trailing</code> take a Velyx icon name, so they follow your icon set.'],
        'as-link' => ['As link', 'With <code>href</code>, the button renders an <code>&lt;a&gt;</code>.'],
        'disabled' => 'Disabled',
    ];
    $toc = [
        'installation' => 'Installation',
        'usage' => 'Usage',
        ...collect($examples)->map(fn (string|array $example): string => is_array($example) ? $example[0] : $example)->all(),
        'livewire' => 'With Livewire',
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

    <x-docs.example name="button.preview" />

    <x-docs.section id="installation" title="Installation">
        <x-docs.install :manifest="$manifest" />
    </x-docs.section>

    <x-docs.section id="usage" title="Usage">
        <x-docs.code>
            @verbatim
            <x-ui.button>Save changes</x-ui.button>

            <x-ui.button variant="outline" href="/settings">Settings</x-ui.button>
            @endverbatim
        </x-docs.code>
    </x-docs.section>

    <x-docs.examples group="button" :examples="$examples" />



    <x-docs.section id="livewire" title="With Livewire">
        <p class="docs-prose">
            When the button has <code>wire:click</code>, it disables itself and shows a spinner while that action runs.
            No extra attribute is needed.
        </p>
        <x-docs.code file="app/Livewire/ProjectSettings.php" icon="brand-php">
            @verbatim
            public function deploy(): void
            {
                $this->project->deploy();
            }
            @endverbatim
        </x-docs.code>
        <x-docs.code file="resources/views/livewire/project-settings.blade.php">
            @verbatim
            <x-ui.button icon="check" wire:click="deploy">
                Deploy
            </x-ui.button>
            @endverbatim
        </x-docs.code>
    </x-docs.section>

    <x-docs.section id="api" title="API reference">
        <x-docs.props name="x-ui.button" :rows="[
            ['variant', 'default | secondary | outline | ghost | destructive | link', 'default', 'Visual style.'],
            ['size', 'sm | md | lg | icon', 'md', 'Height and padding. icon makes a square button.'],
            ['href', 'string', 'none', 'Renders an anchor instead of a button.'],
            ['icon', 'string', 'none', 'Leading icon, by Velyx icon name.'],
            ['icon-trailing', 'string', 'none', 'Trailing icon, by Velyx icon name.'],
            ['type', 'button | submit | reset', 'button', 'Native button type.'],
        ]" />
        <p class="docs-prose">Any other attribute (<code>class</code>, <code>wire:*</code>, <code>x-*</code>, <code>data-*</code>) is passed to the root element.</p>
    </x-docs.section>

    <x-docs.section id="a11y" title="Accessibility">
        <p class="docs-prose">
            A native <code>&lt;button&gt;</code>, or an <code>&lt;a&gt;</code> when <code>href</code> is set, so focus and keyboard work as expected.
            Icon-only buttons need an <code>aria-label</code>. During a Livewire action the button is disabled.
        </p>
        <x-docs.keys :rows="['Enter' => 'Activates the button.', 'Space' => 'Activates the button (not links).']" />
    </x-docs.section>
</x-docs.layout>
