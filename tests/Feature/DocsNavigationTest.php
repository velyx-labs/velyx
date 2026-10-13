<?php

use App\Support\DocsNavigation;

beforeEach(fn () => cache()->forget('docs_navigation_sections'));

it('groups components by their primary metadata category', function () {
    $sections = collect(app(DocsNavigation::class)->sections())->keyBy('name');
    $groups = collect($sections['Components']['groups'])->mapWithKeys(
        fn (array $group): array => [$group['name'] => collect($group['items'])->pluck('label')->all()]
    );

    expect($groups->keys()->all())->toBe(['Forms', 'Overlays', 'Navigation', 'Feedback', 'Data & media', 'Layout'])
        ->and($groups['Forms'])->toContain('Button', 'Checkbox', 'Input')
        ->and($groups['Overlays'])->toContain('Dialog', 'Tooltip')
        ->and($groups['Layout'])->toContain('Accordion', 'Card')
        ->and($groups->flatten()->count())->toBe(count(config('velyx-docs.navigation.Components.children')));
});

it('puts each section overview first, with icons from the config', function () {
    $gettingStarted = collect(app(DocsNavigation::class)->sections())->firstWhere('name', 'Getting Started');

    expect($gettingStarted['items'][0])
        ->toMatchArray(['label' => 'Installation', 'path' => 'docs/installation', 'icon' => 'download'])
        ->and(collect($gettingStarted['items'])->pluck('label')->all())
        ->toBe(['Installation', 'Quick Start', 'CLI Reference', 'Configuration']);
});

it('builds breadcrumbs and neighbours in reading order', function () {
    $navigation = app(DocsNavigation::class);

    expect(collect($navigation->breadcrumbs('docs/components/button'))->pluck('label')->all())
        ->toBe(['Docs', 'Components', 'Button'])
        ->and(collect($navigation->breadcrumbs('docs/installation'))->pluck('label')->all())
        ->toBe(['Docs', 'Getting Started']);

    $neighbours = $navigation->neighbours('docs/quick-start');

    expect($neighbours['previous']['label'])->toBe('Installation')
        ->and($neighbours['next']['label'])->toBe('CLI Reference')
        ->and($navigation->neighbours('docs/unknown'))->toBe(['previous' => null, 'next' => null]);
});

it('renders the redesigned sidebar, breadcrumbs, pager and component header', function () {
    $html = $this->get(route('docs.components.show', 'button'))->assertOk()->getContent();

    expect($html)
        ->toContain('Filter pages…')
        ->toContain('aria-label="Breadcrumb"')
        ->toContain('aria-label="Pagination"')
        ->toContain('Copy link')
        ->toContain('View source')
        ->toContain('/-/tree/main/registry/components/button')
        ->toContain('Edit this page on GitLab')
        ->toContain('Velyx CLI')
        ->toContain('Data &amp; media');
});

it('links guide pages to their Blade source for editing', function () {
    $this->get(route('docs.page', 'quick-start'))
        ->assertOk()
        ->assertSee('/-/blob/main/resources/views/docs/pages/quick-start.blade.php', false);
});
