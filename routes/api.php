<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PlatformController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::get('/user', [AuthController::class, 'profile']);
    Route::get('/home', [HomeController::class, 'home']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Posts
    Route::get('/posts',          [PostController::class, 'index']);
    Route::post('/posts',         [PostController::class, 'store']);
    Route::get('/posts/{id}',     [PostController::class, 'show']);
    Route::put('/posts/{id}',     [PostController::class, 'update']);
    Route::delete('/posts/{id}',  [PostController::class, 'destroy']);

    // Platforms
    Route::get('/platforms',            [PlatformController::class, 'index']);
    Route::get('/platforms/user', [PlatformController::class, 'userPlatforms']);
    Route::get('/platforms/{platform}',     [PlatformController::class, 'show']);
    Route::post('/platforms/toggle',    [PlatformController::class, 'toggle']);
    Route::get('/platforms/{platform}/posts', [PlatformController::class, 'userPosts']);

});
