@php
    $themes = app(\App\Docs\Registry::class)->themes();
    $tokens = [
        ['background / foreground', 'Page background and default text.'],
        ['card / card-foreground', 'Cards and panels.'],
        ['popover / popover-foreground', 'Menus, popovers and dialogs.'],
        ['primary / primary-foreground', 'Main actions. Set by the accent.'],
        ['secondary / secondary-foreground', 'Secondary actions.'],
        ['muted / muted-foreground', 'Quiet surfaces and help text.'],
        ['accent / accent-foreground', 'Hover and selected items.'],
        ['destructive', 'Deleting and errors.'],
        ['success, warning, info', 'Status colors for badges, alerts and toasts.'],
        ['border, input, ring', 'Borders, form fields and the focus ring.'],
        ['radius', 'Base corner radius. sm, md, lg and xl derive from it.'],
    ];
@endphp

<x-docs.layout :title="$title" :nav-key="$navKey" :around="$around" section="Getting started"
    :toc="['tokens' => 'Tokens', 'file' => 'The theme file', 'choices' => 'Bases and accents', 'dark' => 'Dark mode']">
    <x-docs.page-header section="Getting started" :title="$title" description="Components use theme tokens, never raw colors. Change the tokens and every component follows." />

    <x-docs.section id="tokens" title="Tokens">
        <p class="docs-prose">The token names follow shadcn/ui, plus success, warning and info. Use them as Tailwind utilities: <code>bg-primary</code>, <code>text-muted-foreground</code>, <code>border-input</code>.</p>
        <div class="overflow-x-auto rounded-lg border border-border bg-surface">
            <table class="w-full border-collapse text-left text-control">
                <tbody>
                    @foreach ($tokens as [$name, $use])
                        <tr class="border-t border-border first:border-t-0">
                            <td class="px-4 py-[11px] align-top whitespace-nowrap"><code class="font-mono text-code text-ink">{{ $name }}</code></td>
                            <td class="px-4 py-[11px] align-top text-ink-muted">{{ $use }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-docs.section>

    <x-docs.section id="file" title="The theme file">
        <p class="docs-prose"><code>velyx init</code> writes <code>resources/css/velyx.css</code>. Colors are oklch values; edit them freely.</p>
        <x-docs.code file="resources/css/velyx.css" icon="file-type-css">
            @verbatim
            :root {
              --radius: 0.625rem;
              --font-body: "Hanken Grotesk", ui-sans-serif, system-ui, sans-serif;
              --background: oklch(1 0 0);
              --foreground: oklch(0.145 0 0);
              --primary: oklch(0.546 0.245 262.881);
              --primary-foreground: oklch(0.985 0 0);
              /* … */
            }

            .dark {
              --background: oklch(0.145 0 0);
              --foreground: oklch(0.985 0 0);
              /* … */
            }

            @theme inline {
              --color-background: var(--background);
              --color-primary: var(--primary);
              --radius-md: calc(var(--radius) - 2px);
              --font-sans: var(--font-body);
              /* … */
            }
            @endverbatim
        </x-docs.code>
    </x-docs.section>

    <x-docs.section id="choices" title="Bases and accents">
        <p class="docs-prose">The base sets the greys, the accent sets <code>primary</code> and <code>ring</code>. Pick them at init with <code>--base</code> and <code>--accent</code>.</p>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="flex flex-col gap-2.5 rounded-lg border border-border bg-surface p-4">
                <x-site.label>Bases</x-site.label>
                <ul class="flex flex-wrap gap-2">
                    @foreach ($themes['bases'] as $name => $base)
                        <li class="flex items-center gap-2 rounded-md border border-border px-2.5 py-1 text-small">
                            <span class="size-3.5 rounded-full border border-border" style="background: {{ $base['swatch'] }}"></span>{{ $name }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="flex flex-col gap-2.5 rounded-lg border border-border bg-surface p-4">
                <x-site.label>Accents</x-site.label>
                <ul class="flex flex-wrap gap-2">
                    @foreach ($themes['accents'] as $name => $value)
                        <li class="flex items-center gap-2 rounded-md border border-border px-2.5 py-1 text-small">
                            <span class="size-3.5 rounded-full border border-border" style="background: {{ $value }}"></span>{{ $name }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </x-docs.section>

    <x-docs.section id="dark" title="Dark mode">
        <p class="docs-prose">Dark values apply under a <code>.dark</code> class on any ancestor, usually <code>&lt;html&gt;</code>. Toggle it however you like; this site stores the choice in <code>localStorage</code>.</p>
    </x-docs.section>
</x-docs.layout>
