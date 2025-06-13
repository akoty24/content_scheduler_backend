<?php

use Illuminate\Http\Request;
use Modules\Bookings\Http\Controllers\BookingsController;

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
    Route::get('/bookings', [BookingsController::class, 'index']);
    Route::post('/bookings', [BookingsController::class, 'store']);
    Route::delete('/bookings/{id}', [BookingsController::class, 'destroy']);
});