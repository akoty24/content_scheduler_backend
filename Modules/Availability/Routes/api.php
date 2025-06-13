<?php

use Illuminate\Http\Request;
use Modules\Availability\Http\Controllers\AvailabilityController;

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
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::post('/teams/{id}/availability', action: [AvailabilityController::class, 'store']);
    Route::get('/teams/{id}/generate-slots', [AvailabilityController::class, 'generateSlots']);

});