<?php

namespace App\Http\Controllers;

use App\Docs\Markdown;
use App\Docs\Pages;
use App\Docs\SearchIndex;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DocsController extends Controller
{
    public function guide(Pages $pages, string $slug): View
    {
        return $pages->guide($slug) ?? abort(404);
    }

    public function components(Pages $pages): View
    {
        return $pages->components();
    }

    public function component(Pages $pages, string $slug): View
    {
        return $pages->component($slug) ?? abort(404);
    }

    public function guideMarkdown(Pages $pages, Markdown $markdown, string $slug): Response
    {
        return $this->markdown($markdown, $pages->guide($slug) ?? abort(404));
    }

    public function componentsMarkdown(Pages $pages, Markdown $markdown): Response
    {
        return $this->markdown($markdown, $pages->components());
    }

    public function componentMarkdown(Pages $pages, Markdown $markdown, string $slug): Response
    {
        return $this->markdown($markdown, $pages->component($slug) ?? abort(404));
    }

    public function search(SearchIndex $index): JsonResponse
    {
        return response()->json($index->entries())->setCache(['public' => true, 'max_age' => 300]);
    }

    private function markdown(Markdown $markdown, View $view): Response
    {
        return response($markdown->fromView($view), 200, ['Content-Type' => 'text/markdown; charset=UTF-8'])
            ->setCache(['public' => true, 'max_age' => 300]);
    }
}
