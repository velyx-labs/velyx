<?php

use Illuminate\Support\Facades\Blade;

uses(Tests\TestCase::class);

$map = json_decode(file_get_contents(__DIR__.'/../../../icons/icons.json'), true);

$cases = [];
foreach (array_keys($map['libraries']) as $set) {
    foreach (array_keys($map['icons']) as $icon) {
        $cases["{$set}: {$icon}"] = [$set, $icon];
    }
}

it('renders every mapped icon in every set', function (string $set, string $icon) {
    $html = Blade::render('<x-ui.icon :name="$icon" :set="$set" class="size-4" />', compact('icon', 'set'));

    expect($html)->toContain('<svg')->toContain('aria-hidden="true"')->toContain('size-4');
})->with($cases);

it('passes unmapped names straight to the set', function () {
    expect(Blade::render('<x-ui.icon name="rocket" />'))->toContain('<svg');
});

it('becomes an image with a label instead of being hidden', function () {
    $html = Blade::render('<x-ui.icon name="check" aria-label="Done" />');

    expect($html)->toContain('role="img"')->not->toContain('aria-hidden');
});
