<?php

use Illuminate\Http\Request;
use Modules\Tenants\Http\Controllers\TenantsController;

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
//Get current tenant info

Route::middleware('auth:sanctum')->prefix('v1')->group(function (): void {
    Route::get('/tenant', [TenantsController::class, 'currentTenant']);   

    
});  
