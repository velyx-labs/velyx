<?php

namespace App\Docs;

use Illuminate\Contracts\View\View;

/**
 * Builds the view for each docs page. The controller serves them, and the
 * search index renders them to collect their headings.
 */
class Pages
{
    public function __construct(private Navigation $navigation, private Registry $registry) {}

    public function guide(string $slug): ?View
    {
        if (! array_key_exists($slug, config('docs.guides'))) {
            return null;
        }

        return view('docs.guides.'.$slug, [
            'title' => config('docs.guides')[$slug],
            'navKey' => 'guide:'.$slug,
            'around' => $this->navigation->around('guide:'.$slug),
        ]);
    }

    public function components(): View
    {
        return view('docs.components.index', [
            'title' => 'Components',
            'navKey' => 'components',
            'around' => $this->navigation->around('components'),
            'components' => collect(config('docs.components'))
                ->map(fn (string $title, string $slug): array => [
                    'title' => $title,
                    'url' => route('docs.component', $slug),
                    'description' => $this->registry->component($slug)['description'],
                ])
                ->all(),
        ]);
    }

    public function component(string $slug): ?View
    {
        if (! array_key_exists($slug, config('docs.components'))) {
            return null;
        }

        return view('docs.components.'.$slug, [
            'title' => config('docs.components')[$slug],
            'navKey' => 'component:'.$slug,
            'around' => $this->navigation->around('component:'.$slug),
            'manifest' => $this->registry->component($slug),
        ]);
    }
}
