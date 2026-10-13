<?php

namespace App\Support;

use App\Services\ComponentService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Throwable;

/**
 * Shapes config('velyx-docs.navigation') for the docs sidebar, breadcrumbs and pager.
 *
 * @phpstan-type NavItem array{label: string, path: string, url: string, icon: ?string}
 * @phpstan-type NavGroup array{name: string, items: list<NavItem>}
 * @phpstan-type NavSection array{name: string, path: string, items: list<NavItem>, groups: list<NavGroup>}
 */
class DocsNavigation
{
    /**
     * Component categories in sidebar order, keyed by the metadata category they collect.
     *
     * @var array<string, string>
     */
    private const array COMPONENT_GROUPS = [
        'forms' => 'Forms',
        'input' => 'Forms',
        'overlay' => 'Overlays',
        'navigation' => 'Navigation',
        'feedback' => 'Feedback',
        'data' => 'Data & media',
        'media' => 'Data & media',
        'layout' => 'Layout',
    ];

    private const string OTHER_GROUP = 'Other';

    public function __construct(private ComponentService $componentService) {}

    /**
     * @return list<NavSection>
     */
    public function sections(): array
    {
        return Cache::remember('docs_navigation_sections', 3600, fn (): array => $this->buildSections());
    }

    /**
     * Every page in reading order (overview first, then children).
     *
     * @return list<NavItem>
     */
    public function pages(): array
    {
        $pages = [];

        foreach ($this->sections() as $section) {
            $items = $section['groups'] === []
                ? $section['items']
                : [...$section['items'], ...array_merge(...array_column($section['groups'], 'items'))];

            array_push($pages, ...$items);
        }

        return $pages;
    }

    /**
     * @return array{previous: ?array<string, mixed>, next: ?array<string, mixed>}
     */
    public function neighbours(string $path): array
    {
        $pages = $this->pages();
        $index = $this->indexOf($pages, $path);

        if ($index === null) {
            return ['previous' => null, 'next' => null];
        }

        return [
            'previous' => $pages[$index - 1] ?? null,
            'next' => $pages[$index + 1] ?? null,
        ];
    }

    /**
     * @return list<array{label: string, url: ?string}>
     */
    public function breadcrumbs(string $path): array
    {
        $path = trim($path, '/');

        foreach ($this->sections() as $section) {
            $items = [...$section['items'], ...array_merge([], ...array_column($section['groups'], 'items'))];

            foreach ($items as $item) {
                if ($item['path'] !== $path) {
                    continue;
                }

                $isOverview = $section['path'] === $path;

                return [
                    ['label' => 'Docs', 'url' => route('docs.index')],
                    ['label' => $section['name'], 'url' => $isOverview ? null : docs_url($section['path'])],
                    ...($isOverview ? [] : [['label' => $item['label'], 'url' => null]]),
                ];
            }
        }

        return [];
    }

    /**
     * @return list<NavSection>
     */
    private function buildSections(): array
    {
        $sections = [];

        foreach (config('velyx-docs.navigation', []) as $name => $config) {
            $icons = $config['icons'] ?? [];
            $overview = $this->item($config['overview'] ?? $name, $config['url'], $icons);
            $children = [];

            foreach ($config['children'] ?? [] as $label => $path) {
                $children[] = $this->item($label, $path, $icons);
            }

            $grouped = (bool) ($config['grouped'] ?? false);

            $sections[] = [
                'name' => $name,
                'path' => trim($config['url'], '/'),
                'items' => $grouped ? [$overview] : [$overview, ...$children],
                'groups' => $grouped ? $this->groupComponents($children) : [],
            ];
        }

        return $sections;
    }

    /**
     * @param  list<NavItem>  $items
     * @return list<NavGroup>
     */
    private function groupComponents(array $items): array
    {
        $order = array_values(array_unique([...array_values(self::COMPONENT_GROUPS), self::OTHER_GROUP]));
        $groups = array_fill_keys($order, []);

        foreach ($items as $item) {
            $groups[$this->groupFor($item['path'])][] = $item;
        }

        return array_values(array_map(
            fn (string $name, array $groupItems): array => ['name' => $name, 'items' => $groupItems],
            array_keys(array_filter($groups)),
            array_filter($groups),
        ));
    }

    private function groupFor(string $path): string
    {
        try {
            $categories = $this->componentService->getMetadata(Str::afterLast($path, '/'))['meta']['categories'] ?? [];
        } catch (Throwable) {
            $categories = [];
        }

        foreach ($categories as $category) {
            if (isset(self::COMPONENT_GROUPS[$category])) {
                return self::COMPONENT_GROUPS[$category];
            }
        }

        return self::OTHER_GROUP;
    }

    /**
     * @param  array<string, string>  $icons
     * @return NavItem
     */
    private function item(string $label, string $path, array $icons): array
    {
        $path = trim($path, '/');

        return [
            'label' => $label,
            'path' => $path,
            'url' => docs_url($path),
            'icon' => $icons[$label] ?? null,
        ];
    }

    /**
     * @param  list<NavItem>  $pages
     */
    private function indexOf(array $pages, string $path): ?int
    {
        $path = trim($path, '/');

        foreach ($pages as $index => $page) {
            if ($page['path'] === $path) {
                return $index;
            }
        }

        return null;
    }
}
