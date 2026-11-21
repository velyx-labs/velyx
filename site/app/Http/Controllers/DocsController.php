<?php

namespace App\Http\Controllers;

use App\Docs\Pages;
use App\Docs\SearchIndex;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

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

    public function search(SearchIndex $index): JsonResponse
    {
        return response()->json($index->entries())->setCache(['public' => true, 'max_age' => 300]);
    }
}
