<x-docs.layout :title="$title">
    <x-docs.page-header
        eyebrow="Design"
        title="Typography"
        description="Learn the Velyx typography system, text hierarchy, and font guidance for sharper Laravel product interfaces."
    />

    <section class="space-y-10">
        <div class="grid gap-4 md:grid-cols-2">
            <x-ui.card class="p-5">
                <h2 class="font-semibold">Sans Serif</h2>
                <p class="mt-2 font-mono text-sm text-muted-foreground">--font-sans</p>
                <p class="mt-4 text-sm leading-6 text-muted-foreground">Used for body copy, labels, headings, and most interface text.</p>
            </x-ui.card>

            <x-ui.card class="p-5">
                <h2 class="font-semibold">Mono</h2>
                <p class="mt-2 font-mono text-sm text-muted-foreground">--font-mono</p>
                <p class="mt-4 text-sm leading-6 text-muted-foreground">Used for code, terminal commands, keyboard hints, and technical values.</p>
            </x-ui.card>
        </div>

        <x-ui.table class="rounded-lg border">
            <x-ui.table.header class="bg-muted/50">
                <x-ui.table.row>
                    <x-ui.table.head>Class</x-ui.table.head>
                    <x-ui.table.head>Usage</x-ui.table.head>
                </x-ui.table.row>
            </x-ui.table.header>
            <x-ui.table.body>
                @foreach([
                    ['text-sm', 'Secondary text and form labels'],
                    ['text-base', 'Body text and defaults'],
                    ['text-xl', 'Subheadings'],
                    ['text-3xl', 'Section headings'],
                    ['text-5xl', 'Hero headings'],
                ] as [$class, $usage])
                    <x-ui.table.row>
                        <x-ui.table.cell class="font-mono">{{ $class }}</x-ui.table.cell>
                        <x-ui.table.cell class="text-muted-foreground">{{ $usage }}</x-ui.table.cell>
                    </x-ui.table.row>
                @endforeach
            </x-ui.table.body>
        </x-ui.table>
    </section>
</x-docs.layout>
