<?php

namespace App\Support;

use App\Services\ComponentService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Throwable;

class DocsSearchIndex
{
    public function __construct(private ComponentService $componentService) {}

    /**
     * Searchable entries for the site-wide docs search, built from the docs navigation.
     *
     * @return list<array{title: string, section: string, url: string, description: string}>
     */
    public function items(): array
    {
        return Cache::remember('docs_search_index', 3600, fn (): array => $this->build());
    }

    /**
     * @return list<array{title: string, section: string, url: string, description: string}>
     */
    private function build(): array
    {
        $items = [];

        foreach (config('velyx-docs.navigation', []) as $section => $group) {
            $items[] = $this->entry($section, $section, $group['url']);

            foreach ($group['children'] ?? [] as $label => $url) {
                $items[] = $this->entry($label, $section, $url);
            }
        }

        return $items;
    }

    /**
     * @return array{title: string, section: string, url: string, description: string}
     */
    private function entry(string $title, string $section, string $path): array
    {
        return [
            'title' => $title,
            'section' => $section,
            'url' => docs_url($path),
            'description' => $this->componentDescription($path),
        ];
    }

    private function componentDescription(string $path): string
    {
        if (! Str::startsWith($path, 'docs/components/')) {
            return '';
        }

        try {
            return (string) ($this->componentService->getMetadata(Str::after($path, 'docs/components/'))['meta']['description'] ?? '');
        } catch (Throwable) {
            return '';
        }
    }
}
