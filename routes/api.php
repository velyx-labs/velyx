<?php

use App\Http\Controllers\Api\ComponentController;
use App\Http\Controllers\Api\PreviewSourceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Registry API v1
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Registry API v1 endpoints
Route::domain(config('app.domains.api'))->prefix('v1')->group(function () {
    // Component endpoints
    Route::prefix('components')->as('components.')->group(function () {
        Route::get('/', [ComponentController::class, 'index'])->name('index');
        Route::get('/{name}', [ComponentController::class, 'show'])->name('show');
        Route::get('/{name}/versions', [ComponentController::class, 'versions'])->name('versions');
    });

    Route::get('/previews/{component}/source', PreviewSourceController::class)->name('previews.source');
});
