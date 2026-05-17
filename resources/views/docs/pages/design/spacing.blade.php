<?php
use Livewire\Component;

new class extends Component {
};
?>

<x-docs.layout :title="$title">
    <x-docs.page-header
        eyebrow="Design"
        title="Spacing"
        description="Learn the Velyx spacing system and layout rules for building cleaner, more consistent Laravel UI screens."
    />

    <section class="space-y-10">
        <x-ui.table class="rounded-lg border">
            <x-ui.table.header class="bg-muted/50">
                <x-ui.table.row>
                    <x-ui.table.head>Scale</x-ui.table.head>
                    <x-ui.table.head>Value</x-ui.table.head>
                    <x-ui.table.head>Usage</x-ui.table.head>
                </x-ui.table.row>
            </x-ui.table.header>
            <x-ui.table.body>
                @foreach([
                    ['1', '0.25rem / 4px', 'Extra tight'],
                    ['2', '0.5rem / 8px', 'Tight'],
                    ['3', '0.75rem / 12px', 'Normal'],
                    ['4', '1rem / 16px', 'Default'],
                    ['6', '1.5rem / 24px', 'Extra loose'],
                    ['8', '2rem / 32px', 'Wide'],
                    ['12', '3rem / 48px', 'Ultra wide'],
                ] as [$scale, $value, $usage])
                    <x-ui.table.row>
                        <x-ui.table.cell class="font-mono">{{ $scale }}</x-ui.table.cell>
                        <x-ui.table.cell class="font-mono">{{ $value }}</x-ui.table.cell>
                        <x-ui.table.cell class="text-muted-foreground">{{ $usage }}</x-ui.table.cell>
                    </x-ui.table.row>
                @endforeach
            </x-ui.table.body>
        </x-ui.table>
    </section>
</x-docs.layout>
