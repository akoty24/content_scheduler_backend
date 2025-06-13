<?php

use Illuminate\Http\Request;
use Modules\Teams\Http\Controllers\TeamsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->prefix('v1')->group(function (): void {
        Route::get('/teams', [TeamsController::class, 'index']);   
        Route::post('/teams', [TeamsController::class, 'store']);
});