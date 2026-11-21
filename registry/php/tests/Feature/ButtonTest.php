<?php

use Illuminate\Support\Facades\Blade;

uses(Tests\TestCase::class);

it('renders a primary button by default', function () {
    $html = Blade::render('<x-ui.button>Deploy</x-ui.button>');

    expect($html)
        ->toContain('<button')
        ->toContain('type="button"')
        ->toContain('bg-primary text-primary-foreground')
        ->toContain('Deploy');
});

it('applies the variant and size', function () {
    $html = Blade::render('<x-ui.button variant="destructive" size="sm">Delete</x-ui.button>');

    expect($html)->toContain('bg-destructive')->toContain('h-8');
});

it('renders a link when href is given', function () {
    $html = Blade::render('<x-ui.button href="/settings" variant="outline">Settings</x-ui.button>');

    expect($html)->toContain('<a href="/settings"')->not->toContain('<button');
});

it('disables itself and shows a spinner while its Livewire action runs', function () {
    $html = Blade::render('<x-ui.button wire:click="deploy(1)">Deploy</x-ui.button>');

    expect($html)
        ->toContain('wire:loading.attr="disabled"')
        ->toContain('wire:target="deploy"')
        ->toContain('animate-spin');
});

it('renders leading and trailing icons', function () {
    $html = Blade::render('<x-ui.button icon="check" icon-trailing="chevron-down">Save</x-ui.button>');

    expect(substr_count($html, '<svg'))->toBe(2);
});
