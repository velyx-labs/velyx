<?php

use Illuminate\Support\Facades\Blade;

uses(Tests\TestCase::class);

it('renders badge variants with their role colors', function () {
    expect(Blade::render('<x-ui.badge variant="success" icon="check">Deployed</x-ui.badge>'))
        ->toContain('text-success')
        ->toContain('<svg')
        ->toContain('Deployed');
});

it('composes a card from its parts', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui.card as="article">
            <x-ui.card.header>
                <x-ui.card.title>Team plan</x-ui.card.title>
                <x-ui.card.description>For teams shipping every day.</x-ui.card.description>
            </x-ui.card.header>
            <x-ui.card.content>$49 / month</x-ui.card.content>
            <x-ui.card.footer><x-ui.button>Upgrade</x-ui.button></x-ui.card.footer>
        </x-ui.card>
        BLADE);

    expect($html)
        ->toContain('<article')
        ->toContain('bg-card')
        ->toContain('<h3')
        ->toContain('Team plan')
        ->toContain('text-muted-foreground')
        ->toContain('Upgrade');
});
