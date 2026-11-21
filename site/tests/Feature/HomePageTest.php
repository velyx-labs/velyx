<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_renders_every_landing_section(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('<title>Velyx · Laravel components you own, line by line</title>', false)
            ->assertSeeInOrder([
                'Laravel', 'components', 'you', 'own,', 'line', 'by', 'line.',
                'npx velyx init',
                'Create project',
                'Built for the stack you already use',
                'Three commands. Then it is your code.',
                'Your code, not a dependency.',
                'Bring your icon set.',
                'Free, MIT licensed, built in the open.',
                'Start with one component.',
                'npx velyx add button',
                'MIT License',
            ]);
    }

    public function test_home_page_links_to_github_and_buy_me_a_coffee(): void
    {
        $this->get(route('home'))
            ->assertSee('href="https://github.com/velyx-labs/velyx"', false)
            ->assertSee('href="https://buymeacoffee.com/jiordiviera"', false)
            ->assertSee('href="https://github.com/velyx-labs/velyx/tree/2.x"', false);
    }

    public function test_icon_section_previews_every_icon_set(): void
    {
        $response = $this->get(route('home'));

        foreach (['lucide', 'heroicons', 'tabler', 'phosphor', 'svg'] as $set) {
            $response->assertSee("choose('{$set}', true)", false);
        }

        $response->assertSee('data-name="alert-triangle"', false);
    }

    public function test_section_anchors_used_by_the_navigation_exist(): void
    {
        $response = $this->get(route('home'));

        foreach (['top', 'components', 'cli', 'icons', 'docs'] as $anchor) {
            $response->assertSee('id="'.$anchor.'"', false);
        }
    }
}
