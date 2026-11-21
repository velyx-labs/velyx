@php
    $registry = app(\App\Docs\Registry::class);
@endphp

<x-docs.layout :title="$title" :nav-key="$navKey" :around="$around" section="Getting started"
    :toc="['how' => 'How icons work', 'sets' => 'Icon sets', 'names' => 'Icon names', 'own' => 'Your own icons']">
    <x-docs.page-header section="Getting started" :title="$title" description="Components ask for icons by name. You choose the library once, and every component follows." />

    <x-docs.section id="how" title="How icons work">
        <div class="docs-prose">
            <p>
                Components never import an icon library. They write <code>&lt;x-ui.icon name="x" /&gt;</code>, and the
                <code>icon</code> component, installed by <code>velyx init</code>, maps that name to the set in your project.
            </p>
        </div>
        <x-docs.code>
            @verbatim
            <x-ui.icon name="check" class="size-4" />

            {{-- With a label, the icon is announced; without one, it is hidden from screen readers. --}}
            <x-ui.icon name="info" aria-label="More information" />
            @endverbatim
        </x-docs.code>
    </x-docs.section>

    <x-docs.section id="sets" title="Icon sets">
        <div class="overflow-x-auto rounded-lg border border-border bg-surface">
            <table class="w-full border-collapse text-left text-control">
                <thead class="border-b border-border bg-surface-subtle">
                    <tr>
                        <th scope="col" class="px-4 py-2.5 font-mono text-label font-medium tracking-[0.06em] text-ink-subtle uppercase">Set</th>
                        <th scope="col" class="px-4 py-2.5 font-mono text-label font-medium tracking-[0.06em] text-ink-subtle uppercase">Composer package</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registry->iconSets() as $key => $set)
                        <tr class="border-t border-border first:border-t-0">
                            <td class="px-4 py-[11px] text-ink">{{ $set['label'] }} <code class="ml-1 font-mono text-xs text-ink-subtle">{{ $key }}</code></td>
                            <td class="px-4 py-[11px] font-mono text-xs text-ink-muted">{{ $set['package'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="docs-prose">Choose one at init with <code>--icons</code>. To switch later, change <code>'set'</code> at the top of <code>icon.blade.php</code> and require the matching package.</p>
    </x-docs.section>

    <x-docs.section id="names" title="Icon names">
        <p class="docs-prose">These are the names components use. Any other name is passed to the set as is.</p>
        <ul class="flex flex-wrap gap-2">
            @foreach (array_keys($registry->icons()) as $name)
                <li class="velyx-preview flex items-center gap-2 rounded-md border border-border bg-surface px-3 py-1.5 text-control">
                    <x-ui.icon :name="$name" class="size-4" />
                    <code class="font-mono text-xs">{{ $name }}</code>
                </li>
            @endforeach
        </ul>
    </x-docs.section>

    <x-docs.section id="own" title="Your own icons">
        <p class="docs-prose">
            <code>icon.blade.php</code> is your file. Add entries to its <code>$icons</code> map, or point a name to any Blade component,
            such as an inline SVG in <code>resources/views/components/icons</code>.
        </p>
    </x-docs.section>
</x-docs.layout>
