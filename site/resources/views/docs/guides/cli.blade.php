<x-docs.layout :title="$title" :nav-key="$navKey" :around="$around" section="Getting started"
    :toc="['init' => 'velyx init', 'add' => 'velyx add', 'list' => 'velyx list', 'registry' => 'Registry', 'next' => 'Coming next']">
    <x-docs.page-header section="Getting started" :title="$title" description="One binary, three commands. Run it with npx, pnpm dlx or bunx, or install it globally." />

    <x-docs.section id="init" title="velyx init">
        <p class="docs-prose">Sets up the project. Interactive by default.</p>
        <x-docs.props name="Options" :rows="[
            ['--yes', 'flag', 'false', 'Accept the defaults and run composer without asking.'],
            ['--components', 'path', 'resources/views/components/ui', 'Where components are written.'],
            ['--icons', 'lucide | heroicons | tabler | phosphor', 'lucide', 'Icon set.'],
            ['--base', 'neutral | zinc | stone | slate | gray', 'neutral', 'Base color for backgrounds, borders and text.'],
            ['--accent', 'neutral | blue | green | orange | rose | violet', 'neutral', 'Primary color.'],
            ['--radius', 'rem', '0.625', 'Base corner radius.'],
            ['--force', 'flag', 'false', 'Overwrite an existing velyx.json.'],
            ['--no-composer', 'flag', 'false', 'Do not run composer require.'],
        ]" />
    </x-docs.section>

    <x-docs.section id="add" title="velyx add">
        <p class="docs-prose">Adds one or more components and the components they depend on. Pin a version with <code>name@version</code>.</p>
        <x-docs.command command="velyx add card button" />
        <x-docs.props name="Options" :rows="[
            ['--overwrite', 'flag', 'false', 'Replace files that have local changes.'],
            ['--dry-run', 'flag', 'false', 'Show what would change without writing.'],
            ['--yes', 'flag', 'false', 'Run composer without asking.'],
            ['--no-composer', 'flag', 'false', 'Do not run composer require.'],
        ]" />
    </x-docs.section>

    <x-docs.section id="list" title="velyx list">
        <p class="docs-prose">Lists the registry. <code>✓</code> marks installed components, <code>↑</code> those with a newer version.</p>
        <x-docs.command command="velyx list" />
    </x-docs.section>

    <x-docs.section id="registry" title="Registry">
        <p class="docs-prose">
            Every command accepts <code>--registry</code>, a URL or a local folder, and <code>--cwd</code> to run in another project.
            The registry is a set of static JSON files, so you can host your own.
        </p>
    </x-docs.section>

    <x-docs.section id="next" title="Coming next">
        <p class="docs-prose">
            <code>velyx diff</code> and <code>velyx update</code> to compare your copy with a new version and take only what you want,
            <code>velyx icons use</code> to switch icon sets, and <code>velyx theme set</code> to change colors after init.
        </p>
    </x-docs.section>
</x-docs.layout>
