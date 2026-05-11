<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ComponentNotFoundException;
use App\Services\ComponentService;
use Illuminate\Contracts\View\View;
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
