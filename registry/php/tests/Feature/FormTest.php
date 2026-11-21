<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

uses(Tests\TestCase::class);

it('renders an input with the token classes', function () {
    $html = Blade::render('<x-ui.input type="email" name="email" placeholder="you@example.com" />');

    expect($html)
        ->toContain('type="email"')
        ->toContain('name="email"')
        ->toContain('border-input')
        ->not->toContain('aria-invalid="true"');
});

it('marks the input invalid when the error bag has its field', function () {
    View::share('errors', (new ViewErrorBag)->put('default', new MessageBag(['email' => 'Required.'])));

    expect(Blade::render('<x-ui.input name="email" />'))->toContain('aria-invalid="true"');
    expect(Blade::render('<x-ui.input wire:model="email" />'))->toContain('aria-invalid="true"');
});

it('renders a label with a hidden required mark and a hint', function () {
    $html = Blade::render('<x-ui.label for="name" required hint="Optional">Name</x-ui.label>');

    expect($html)
        ->toContain('for="name"')
        ->toContain('<span class="text-destructive" aria-hidden="true">*</span>')
        ->toContain('Optional');
});
