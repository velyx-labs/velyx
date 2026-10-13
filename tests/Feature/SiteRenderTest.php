<?php

use App\Support\DocsSearchIndex;
use Illuminate\Support\Facades\Http;

it('renders the landing page through the shared layout', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('Velyx', false)
        ->assertSee('livewire', false)
        ->assertSee('Copy the component.', false)
        ->assertSee('What ships.', false);
});

it('drops the inline style blocks and the stale repo slug from the landing', function () {
    $html = $this->get(route('home'))->assertOk()->getContent();

    expect($html)
        ->not->toContain('velyx-hero')
        ->not->toContain('velyx-showcase')
        ->not->toContain('velyx-labs/registry');
});

it('renders documentation pages through the shared layout', function () {
    $this->get(route('docs.page', 'installation'))->assertOk();
    $this->get(route('docs.components.show', 'button'))->assertOk();
    $this->get(route('docs.index'))->assertOk();
});

it('renders the component page with metadata sections and the on-this-page nav', function () {
    $html = $this->get(route('docs.components.show', 'button'))->assertOk()->getContent();

    expect($html)
        ->toContain('id="installation"')
        ->toContain('id="preview"')
        ->toContain('id="requirements"')
        ->toContain('On this page')
        ->toContain('docsToc');
});

it('serves llms.txt as plain text', function () {
    $this->get(route('llms.txt'))
        ->assertOk()
        ->assertHeader('Content-Type', 'text/plain; charset=utf-8');
});

it('resolves the theme from system preference with no forced default', function () {
    $html = $this->get(route('home'))->assertOk()->getContent();

    expect($html)
        ->toContain('prefers-color-scheme: dark')
        ->not->toContain('default to dark');
});

it('exposes the Open Graph image and web manifest in the head', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('brand/og-image.png', false)
        ->assertSee('site.webmanifest', false);
});

it('renders the header and footer with the inline mark and canonical repo link', function () {
    $html = $this->get(route('home'))->assertOk()->getContent();

    expect($html)
        ->toContain('M6 3H10M3 7L8 13L13 7')
        ->toContain('https://gitlab.com/jiordiviera/velyx');

    $this->get(route('home'))->assertDontSee('assets/img/logo', false);
});

it('reads the star count from the GitLab project API', function () {
    Http::fake([
        'gitlab.com/api/v4/projects/jiordiviera%2Fvelyx' => Http::response(['star_count' => 1234]),
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('1,234', false)
        ->assertSee('stars on GitLab', false);

    Http::assertSent(fn ($request) => str_starts_with($request->url(), 'https://gitlab.com/api/v4/projects/jiordiviera%2Fvelyx'));
});

it('boots the Simple / Neo style before paint and renders the switch', function () {
    $html = $this->get(route('home'))->assertOk()->getContent();

    expect($html)
        ->toContain("localStorage.getItem('style') === 'neo'")
        ->toContain('document.documentElement.dataset.style = style')
        ->toContain('data-style-value="simple"')
        ->toContain('data-style-value="neo"');
});

it('exposes the Neo hooks on the landing and variants on shared components', function () {
    $html = $this->get(route('home'))->assertOk()->getContent();

    expect($html)
        ->toContain('neo-highlight')
        ->toContain('neo-bento')
        ->toContain('data-slot="button"')
        ->toContain('data-variant="destructive"')
        ->toContain('data-slot="badge"');
});

it('points the support link to Buy Me a Coffee', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('https://buymeacoffee.com/jiordiviera', false)
        ->assertSee('Buy me a coffee', false);
});

it('renders the docs search with an index built from the navigation', function () {
    $items = app(DocsSearchIndex::class)->items();

    $button = collect($items)->firstWhere('title', 'Button');

    expect($button)
        ->not->toBeNull()
        ->and($button['section'])->toBe('Components')
        ->and($button['url'])->toEndWith('docs/components/button')
        ->and($button['description'])->not->toBeEmpty()
        ->and(collect($items)->pluck('title'))->toContain('Quick Start', 'Getting Started');

    $this->get(route('docs.page', 'installation'))
        ->assertOk()
        ->assertSee('Search documentation', false)
        ->assertSee('Search docs and components', false);
});

it('marks the active docs nav link for both styles', function () {
    $this->get(route('docs.components.show', 'button'))
        ->assertOk()
        ->assertSee('data-active aria-current="page"', false);
});

it('uses the svgl brand logos in the header and footer', function () {
    $html = $this->get(route('home'))->assertOk()->getContent();

    expect($html)
        ->toContain('fill="#E24329"')
        ->toContain('fill="#FFDD00"');
});

it('ships the subtle landing motion hooks', function () {
    $html = $this->get(route('home'))->assertOk()->getContent();

    expect($html)
        ->toContain('motion-rise')
        ->toContain('data-reveal')
        ->toContain('motion-lift')
        ->toContain('motion-caret')
        ->and(substr_count($html, '<span>Command palette</span>'))->toBe(2);
});
