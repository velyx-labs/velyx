<?php

use App\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::home')->name('home');

Route::redirect('/docs', '/docs/introduction')->name('docs');
Route::get('/docs/search.json', [DocsController::class, 'search'])->name('docs.search');
Route::get('/docs/components.md', [DocsController::class, 'componentsMarkdown'])->name('docs.components.markdown');
Route::get('/docs/components/{slug}.md', [DocsController::class, 'componentMarkdown'])->where('slug', '[a-z0-9-]+')->name('docs.component.markdown');
Route::get('/docs/{slug}.md', [DocsController::class, 'guideMarkdown'])->where('slug', '[a-z0-9-]+')->name('docs.guide.markdown');
Route::get('/docs/components', [DocsController::class, 'components'])->name('docs.components');
Route::get('/docs/components/{slug}', [DocsController::class, 'component'])->name('docs.component');
Route::get('/docs/{slug}', [DocsController::class, 'guide'])->name('docs.guide');
