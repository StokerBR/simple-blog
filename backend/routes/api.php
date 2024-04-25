<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;

Route::post('token', [AccessTokenController::class, "issueToken"]);

Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'listPosts']);
    Route::get('/{id}', [PostController::class, 'getPost'])->where('id', '[0-9]+');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get    ('/own', [PostController::class, 'ownPosts']);
        Route::get    ('/{id}/edit', [PostController::class, 'edit'])->where('id', '[0-9]+');
        Route::post   ('/', [PostController::class, 'insert']);
        Route::put    ('/{id}', [PostController::class, 'update'])->where('id', '[0-9]+');
        Route::delete ('/{id}', [PostController::class, 'delete'])->where('id', '[0-9]+');
    });

    Route::get('/categories', [PostController::class, 'getCategories']);
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
