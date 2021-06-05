<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::group(['middleware'=> 'auth:sanctum'], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::group(['prefix' => 'profile'], function () {
            Route::get('/', [ProfileController::class, 'index']);
            Route::put('/', [ProfileController::class, 'update']);
        });
        Route::get('{user:username}/posts', [PostController::class, 'index']);
        Route::get('{user:username}', [UserController::class, 'show']);
    });

    Route::group(['prefix' => 'posts'], function () {
        Route::get('/', [PostController::class, 'index']);
        Route::get('{post}', [PostController::class, 'show']);
        Route::post('/', [PostController::class, 'store']);
        Route::put('{post}', [PostController::class, 'update'])->middleware('can:update,post');
        Route::delete('{post}', [PostController::class, 'destroy'])->middleware('can:delete,post');

        Route::group(['prefix' => '{post}/comments'], function () {
            Route::get('/', [CommentController::class, 'index']);
            Route::post('/', [CommentController::class, 'store']);
        });
    });

    Route::group(['prefix' => 'comments'], function () {
        Route::put('{comment}', [CommentController::class, 'update'])->middleware('can:update,comment');
        Route::delete('{comment}', [CommentController::class, 'destroy'])->middleware('can:delete,comment');
    });
});

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});
