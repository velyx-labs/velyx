<?php

namespace App\Docs;

/**
 * The docs sidebar, and the previous / next links derived from its order.
 */
class Navigation
{
    /**
     * @return list<array{title: string, links: list<array{title: string, url: string, key: string}>}>
     */
    public function sections(): array
    {
        $guides = collect(config('docs.guides'))
            ->map(fn (string $title, string $slug): array => [
                'title' => $title,
                'url' => route('docs.guide', $slug),
                'key' => 'guide:'.$slug,
            ])
            ->values()
            ->all();

        $components = collect(config('docs.components'))
            ->map(fn (string $title, string $slug): array => [
                'title' => $title,
                'url' => route('docs.component', $slug),
                'key' => 'component:'.$slug,
            ])
            ->values()
            ->prepend(['title' => 'All components', 'url' => route('docs.components'), 'key' => 'components'])
            ->all();

        return [
            ['title' => 'Getting started', 'links' => $guides],
            ['title' => 'Components', 'links' => $components],
        ];
    }

    /**
     * @return array{previous: array{title: string, url: string, key: string}|null, next: array{title: string, url: string, key: string}|null}
     */
    public function around(string $key): array
    {
        $links = collect($this->sections())->flatMap(fn (array $section): array => $section['links'])->values();
        $index = $links->search(fn (array $link): bool => $link['key'] === $key);

        if ($index === false) {
            return ['previous' => null, 'next' => null];
        }

        return [
            'previous' => $links->get($index - 1),
            'next' => $links->get($index + 1),
        ];
    }
}
