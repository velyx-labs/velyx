<x-docs.layout :title="$title" :nav-key="$navKey" :around="$around" section="Getting started"
    :toc="['init' => 'Initialize', 'add' => 'Add a component', 'files' => 'What changes', 'existing' => 'Existing projects']">
    <x-docs.page-header section="Getting started" :title="$title" description="Set up Velyx in a Laravel app, then add your first component." />

    <x-docs.section id="init" title="Initialize">
        <p class="docs-prose">Run this at the root of your Laravel project. It asks where components go, which icon set to use and which colors to start from.</p>
        <x-docs.command command="velyx init" />
        <p class="docs-prose">To skip the questions and take the defaults (Lucide icons, neutral colors), add <code>--yes</code>.</p>
    </x-docs.section>

    <x-docs.section id="add" title="Add a component">
        <x-docs.command command="velyx add button" />
        <p class="docs-prose">Then use it in any view:</p>
        <x-docs.code file="resources/views/welcome.blade.php">
            @verbatim
            <x-ui.button>Get started</x-ui.button>
            @endverbatim
        </x-docs.code>
    </x-docs.section>

    <x-docs.section id="files" title="What changes">
        <div class="overflow-x-auto rounded-lg border border-border bg-surface">
            <table class="w-full border-collapse text-left text-control">
                <tbody>
                    @foreach ([
                        ['velyx.json', 'Your choices: components folder, icon set, theme, and the version of each installed component.'],
                        ['resources/css/velyx.css', 'The theme tokens (colors, radius, font) for light and dark mode.'],
                        ['resources/css/app.css', 'One line is added: @import "./velyx.css"; right after Tailwind.'],
                        ['resources/views/components/ui/', 'The components, starting with icon.blade.php.'],
                        ['composer.json', 'The Blade icon package for your icon set.'],
                    ] as [$file, $text])
                        <tr class="border-t border-border first:border-t-0">
                            <td class="px-4 py-[11px] align-top whitespace-nowrap"><code class="font-mono text-code text-ink">{{ $file }}</code></td>
                            <td class="px-4 py-[11px] align-top text-ink-muted">{{ $text }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-docs.section>

    <x-docs.section id="existing" title="Existing projects">
        <div class="docs-prose">
            <p>
                <code>init</code> stops if <code>velyx.json</code> already exists, and <code>add</code> stops before writing anything if a file
                you edited would be replaced. Pass <code>--overwrite</code> only when you mean it. If a write fails halfway, every file is put back.
            </p>
            <p>Coming from Velyx 2? The CLI detects the old <code>velyx.json</code> and tells you what to do.</p>
        </div>
    </x-docs.section>
</x-docs.layout>
