<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/hello', function () {
    return 'hello';
});


Route::controller(LoginRegisterController::class)->group(callback: function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');

    Route::middleware('auth:sanctum')->group(callback: function () {
        Route::post('/logout', [LoginRegisterController::class, 'logout']);

        Route::controller(UserController::class)->group(function () {
            Route::get('/users', 'index');
            Route::get('/users/profile', 'profile');
            Route::get('/users/{id}', 'show');
            Route::post('/users', 'store');
            Route::delete('/users/{id}', 'destroy');
            Route::put('/users/{id}', 'update');
            Route::put('/users/change-status/{id}', 'changeStatus');
        });

        Route::controller(ArticleController::class)->group(function () {
            Route::get('/articles', 'index');
            Route::post('/articles', 'store');
            Route::get('/articles/{id}', 'show');
            Route::get('/articles-ids', 'getCategories');
            Route::delete('/articles/{id}', 'destroy');
            Route::put('/articles/{id}', 'update');
            Route::put('/articles/change-status/{id}', 'changeStatus');
        });

        Route::controller(ItemController::class)->group(function () {
            Route::get('/items', 'index');
            Route::post('/items', 'store');
            Route::get('/items/{id}', 'show');
            Route::delete('/items/{id}', 'destroy');
            Route::put('/items/{id}', 'update');
          Route::put('/items/change-status/{id}', 'changeStatus');
        });
    });
});
