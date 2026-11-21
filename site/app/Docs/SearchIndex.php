<?php

namespace App\Docs;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

/**
 * Every docs page and section heading, for the ⌘K search. Pages are
 * rendered once to read their "On this page" links, then cached until a
 * docs view or the registry changes.
 */
class SearchIndex
{
    public function __construct(private Navigation $navigation, private Pages $pages) {}

    /**
     * @return list<array{title: string, page: string, group: string, url: string, kind: string}>
     */
    public function entries(): array
    {
        return Cache::rememberForever('docs.search.'.$this->fingerprint(), fn (): array => $this->build());
    }

    /**
     * @return list<array{title: string, page: string, group: string, url: string, kind: string}>
     */
    private function build(): array
    {
        $entries = [];

        foreach ($this->navigation->sections() as $section) {
            foreach ($section['links'] as $link) {
                $entries[] = [
                    'title' => $link['title'],
                    'page' => $link['title'],
                    'group' => $section['title'],
                    'url' => $link['url'],
                    'kind' => 'page',
                ];

                foreach ($this->headings($link['key']) as $id => $heading) {
                    $entries[] = [
                        'title' => $heading,
                        'page' => $link['title'],
                        'group' => $section['title'],
                        'url' => $link['url'].'#'.$id,
                        'kind' => 'heading',
                    ];
                }
            }
        }

        return $entries;
    }

    /**
     * The "On this page" links of one page, as [id => label].
     *
     * @return array<string, string>
     */
    private function headings(string $key): array
    {
        [$kind, $slug] = array_pad(explode(':', $key, 2), 2, null);

        $view = match ($kind) {
            'guide' => $this->pages->guide($slug),
            'component' => $this->pages->component($slug),
            default => null,
        };

        if (! $view instanceof View) {
            return [];
        }

        $html = $view->render();

        if (! preg_match('~<aside[^>]*aria-label="On this page"[^>]*>(.*?)</aside>~s', $html, $toc)) {
            return [];
        }

        preg_match_all('~<a\s+href="#([\w-]+)"[^>]*>\s*(.*?)\s*</a>~s', $toc[1], $links, PREG_SET_ORDER);

        return collect($links)
            ->mapWithKeys(fn (array $link): array => [$link[1] => html_entity_decode(strip_tags($link[2]))])
            ->all();
    }

    /**
     * Changes whenever a docs view or the registry index changes.
     */
    private function fingerprint(): string
    {
        $files = collect(File::allFiles(resource_path('views/docs')))
            ->merge(File::allFiles(resource_path('views/components/docs')))
            ->map(fn ($file): string => $file->getPathname().':'.$file->getMTime());

        $registry = config('docs.registry').'/index.json';
        $files->push($registry.':'.(File::exists($registry) ? File::lastModified($registry) : 0));

        return md5($files->implode('|'));
    }
}
