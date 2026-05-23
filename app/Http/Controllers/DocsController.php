<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ComponentNotFoundException;
use App\Services\ComponentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class DocsController extends Controller
{
    public function __construct(
        protected ComponentService $components,
    ) {}

    public function home(): View
    {
        return view('docs.index', [
            'title' => 'Velyx Documentation',
            'components' => $this->components->getAllComponents(),
        ]);
    }

    public function landing(): View
    {
        return view('docs.landing', [
            'title' => 'Velyx - Laravel UI Components',
        ]);
    }

    public function page(string $page): View
    {
        $normalized = Str::of($page)->trim('/')->replace('_', '-')->toString();
        $view = 'docs.pages.'.str_replace('/', '.', $normalized);
        $data = [
            'title' => Str::headline(basename($normalized)).' - Velyx',
        ];

        if (! view()->exists($view)) {
            abort(404);
        }

        if ($normalized === 'components') {
            $data['components'] = $this->components->getAllComponents();
        }

        return view($view, $data);
    }

    public function llmsTxt(): Response
    {
        $components = $this->components->getAllComponents();

        $lines = [];

        $lines[] = '# Velyx';
        $lines[] = '';
        $lines[] = '> Copy-paste UI components for Laravel. Production-ready Blade components copied directly into your project — no vendor lock-in, no runtime abstractions.';
        $lines[] = '';
        $lines[] = 'Velyx is inspired by shadcn/ui. Components land in `resources/views/components/ui/` via the CLI and become your source files to modify freely.';
        $lines[] = '';
        $lines[] = 'CLI: `npx velyx@latest`';
        $lines[] = 'Requires: Laravel 10+, Blade, Tailwind CSS v4, Alpine.js 3+ (optional)';
        $lines[] = '';
        $lines[] = '## Getting Started';
        $lines[] = '';
        $lines[] = '- [Installation]('.route('docs.page', 'installation').'): Install the CLI and add your first component';
        $lines[] = '- [Quick Start]('.route('docs.page', 'quick-start').'): From zero to a working UI in minutes';
        $lines[] = '- [Configuration]('.route('docs.page', 'configuration').'): velyx.json config options and path overrides';
        $lines[] = '- [Theming]('.route('docs.page', 'theming').'): CSS variables, design tokens, dark mode';
        $lines[] = '';
        $lines[] = '## CLI Reference';
        $lines[] = '';
        $lines[] = '- [CLI Reference]('.route('docs.page', 'cli-reference').'): All velyx commands — init, add, list, and flags';
        $lines[] = '';
        $lines[] = '## Components';
        $lines[] = '';

        foreach ($components as $name => $data) {
            $description = $data['meta']['description'] ?? '';
            $url = route('docs.components.show', $name);
            $label = str(ucfirst(str_replace('-', ' ', $name)))->title();
            $suffix = $description ? ': '.$description : '';
            $lines[] = "- [{$label}]({$url}){$suffix}";
        }

        $lines[] = '';
        $lines[] = '## Optional';
        $lines[] = '';
        $lines[] = '- [Colors]('.route('docs.page', 'design/colors').'): Color system and palette tokens';
        $lines[] = '- [Typography]('.route('docs.page', 'design/typography').'): Type scale and font configuration';
        $lines[] = '- [Spacing]('.route('docs.page', 'design/spacing').'): Spacing and layout tokens';

        return response(implode("\n", $lines), 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    public function component(string $component): View
    {
        $name = Str::of($component)->replace('_', '-')->kebab()->toString();

        try {
            $componentData = $this->components->getComponent($name);
        } catch (ComponentNotFoundException) {
            abort(404);
        }

        $customView = 'docs.pages.components.'.$name;

        return view(view()->exists($customView) ? $customView : 'docs.components.show', [
            'title' => Str::headline($name).' - Velyx Component',
            'componentData' => $componentData,
            'componentName' => $name,
        ]);
    }
}
