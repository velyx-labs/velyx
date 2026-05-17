<?php

use App\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Route;

Route::domain(config('app.domains.web'))->group(function () {

    Route::livewire('/', 'pages::home')->name('home');

    Route::redirect('/docs', '/docs/installation');
    Route::get('/docs-index', [DocsController::class, 'home'])->name('docs.index');
    Route::get('/docs/components/{component}', [DocsController::class, 'component'])->name('docs.components.show');
    Route::get('/docs/{page}', [DocsController::class, 'page'])
        ->where('page', '.*')
        ->name('docs.page');

});
