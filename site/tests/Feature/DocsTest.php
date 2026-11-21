<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DocsTest extends TestCase
{
    /**
     * @return array<string, array{string}>
     */
    public static function pages(): array
    {
        $urls = [
            '/docs/introduction', '/docs/installation', '/docs/cli', '/docs/icons', '/docs/theming',
            '/docs/components', '/docs/components/button', '/docs/components/input', '/docs/components/label',
            '/docs/components/card', '/docs/components/badge',
        ];

        return array_combine($urls, array_map(fn (string $url): array => [$url], $urls));
    }

    public function test_every_configured_page_is_covered(): void
    {
        $configured = collect(config('docs.guides'))->keys()->map(fn (string $slug): string => '/docs/'.$slug)
            ->merge(collect(config('docs.components'))->keys()->map(fn (string $slug): string => '/docs/components/'.$slug));

        $this->assertEmpty($configured->diff(array_keys(self::pages()))->all());
    }

    #[DataProvider('pages')]
    public function test_every_docs_page_renders(string $url): void
    {
        $this->get($url)->assertOk()->assertSee('Velyx docs</title>', false);
    }

    public function test_docs_pages_load_livewire_and_alpine(): void
    {
        $this->get('/docs/components/button')->assertSee('livewire.js', false);
    }

    public function test_docs_root_redirects_to_the_introduction(): void
    {
        $this->get('/docs')->assertRedirect('/docs/introduction');
    }

    public function test_unknown_pages_are_not_found(): void
    {
        $this->get('/docs/nope')->assertNotFound();
        $this->get('/docs/components/nope')->assertNotFound();
    }

    public function test_component_page_reads_the_registry(): void
    {
        $manifest = json_decode(file_get_contents(config('docs.registry').'/components/card.json'), true);

        $this->get('/docs/components/card')
            ->assertSee('v'.$manifest['version'])
            ->assertSee($manifest['description'])
            ->assertSee('resources/views/components/ui/card/header.blade.php')
            ->assertSee('velyx add card');
    }

    public function test_examples_render_the_real_components_and_show_their_source(): void
    {
        $this->get('/docs/components/button')
            ->assertSee('class="velyx-preview', false)
            ->assertSee('bg-destructive text-destructive-foreground', false)
            ->assertSee('<span class="tok-str">&quot;destructive&quot;</span>', false);
    }

    public function test_sidebar_marks_the_current_page_and_links_its_neighbours(): void
    {
        $this->get('/docs/components/input')
            ->assertSee('aria-current="page"', false)
            ->assertSeeInOrder(['Previous', 'Button', 'Next', 'Label']);
    }

    public function test_each_example_gets_its_own_section_and_preview(): void
    {
        $response = $this->get('/docs/components/button');

        foreach (['default', 'secondary', 'outline', 'ghost', 'destructive', 'link', 'sizes', 'icon', 'with-icon', 'as-link', 'disabled'] as $id) {
            $response->assertSee('<section id="'.$id.'"', false)->assertSee('href="#'.$id.'"', false);
        }

        $this->assertSame(12, substr_count($response->getContent(), 'class="velyx-preview'));
    }

    public function test_every_example_file_is_used_by_its_page(): void
    {
        foreach (glob(resource_path('views/docs/examples/*/*.blade.php')) as $file) {
            $group = basename(dirname($file));
            $key = basename($file, '.blade.php');
            $page = file_get_contents(resource_path("views/docs/components/{$group}.blade.php"));

            $this->assertTrue(
                str_contains($page, "'{$key}' =>") || str_contains($page, "name=\"{$group}.{$key}\""),
                "docs/examples/{$group}/{$key}.blade.php is not used on the {$group} page.",
            );
        }
    }

    public function test_search_index_lists_pages_and_their_sections(): void
    {
        $entries = collect($this->getJson(route('docs.search'))->assertOk()->json());

        $this->assertTrue($entries->contains(fn (array $entry): bool => $entry['kind'] === 'page' && $entry['url'] === route('docs.component', 'card')));
        $this->assertTrue($entries->contains(fn (array $entry): bool => $entry['kind'] === 'heading'
            && $entry['title'] === 'Outline'
            && $entry['page'] === 'Badge'
            && $entry['url'] === route('docs.component', 'badge').'#outline'));
        $this->assertTrue($entries->contains(fn (array $entry): bool => $entry['title'] === 'velyx init' && $entry['group'] === 'Getting started'));
    }

    public function test_every_page_has_the_search_dialog(): void
    {
        $this->get('/docs/cli')->assertSee('aria-label="Search documentation"', false)->assertSee('docs\/search.json', false);
        $this->get('/')->assertSee('aria-label="Search documentation"', false);
    }

    public function test_every_page_has_the_theme_toggle(): void
    {
        foreach (['/', '/docs/cli'] as $url) {
            $this->get($url)->assertSee('title="Toggle theme (D)"', false)->assertSee('startViewTransition', false);
        }
    }

    #[DataProvider('pages')]
    public function test_every_docs_page_has_a_markdown_copy(string $url): void
    {
        $response = $this->get($url.'.md')->assertOk()->assertHeader('Content-Type', 'text/markdown; charset=UTF-8');

        $this->assertMatchesRegularExpression('/^# \S/', $response->getContent());
        $prose = preg_replace('/^( *)```[^\n]*\n.*?^\1```$/ms', '', $response->getContent());
        $this->assertStringNotContainsString('<div', $prose);
        $this->assertStringNotContainsString('class="', $prose);
    }

    public function test_markdown_keeps_code_and_drops_previews(): void
    {
        $markdown = $this->get('/docs/components/button.md')->getContent();

        $this->assertStringContainsString("```bash\nnpx velyx add button\n```", $markdown);
        $this->assertStringContainsString("## Destructive\n\nFor actions that delete or cannot be undone.\n\n```blade\n<x-ui.button variant=\"destructive\">", $markdown);
        $this->assertStringContainsString("2. Copy this file into `resources/views/components/ui`.\n\n   ```blade title=\"resources/views/components/ui/button.blade.php\"\n   @props([", $markdown);
        $this->assertStringNotContainsString('Copy page', $markdown);
        $this->assertStringNotContainsString('View code', $markdown);
    }

    public function test_unknown_markdown_pages_are_not_found(): void
    {
        $this->get('/docs/nope.md')->assertNotFound();
        $this->get('/docs/components/nope.md')->assertNotFound();
    }

    public function test_pages_have_copy_and_neighbour_actions(): void
    {
        $this->get('/docs/components/input')
            ->assertSee('Copy page')
            ->assertSee('href="'.url('/docs/components/input.md').'"', false)
            ->assertSee('title="Previous: Button"', false)
            ->assertSee('title="Next: Label"', false)
            ->assertSee('https://claude.ai/new?q=', false);
    }

    public function test_long_source_files_fold_behind_expand(): void
    {
        $this->get('/docs/components/button')->assertSee("expanded ? 'Collapse' : 'Expand'", false);
        $this->get('/docs/components/label')->assertDontSee("expanded ? 'Collapse' : 'Expand'", false);
    }

    public function test_installation_offers_starting_points(): void
    {
        $this->get('/docs/installation')->assertSeeInOrder(['New Laravel app', 'Livewire starter kit', 'Existing project', 'By hand']);
    }

    public function test_the_table_of_contents_links_to_sponsoring(): void
    {
        $this->get('/docs/cli')->assertSee('https://buymeacoffee.com/jiordiviera', false)->assertSee('Support Velyx');
    }

    public function test_new_pages_are_flagged_in_the_sidebar(): void
    {
        $this->get('/docs/cli')->assertDontSee('(new)');

        config(['docs.new' => ['component:card']]);

        $this->get('/docs/cli')->assertSeeInOrder(['Card', '(new)', 'Badge']);
    }
}
