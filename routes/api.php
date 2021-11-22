<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [ApiController::class, 'login']);



Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'v1/vehicles'], function () {
    Route::get('', [ApiController::class, 'index']);
    Route::get('/{vehicle}', [ApiController::class, 'show']);
    Route::post('', [ApiController::class, 'store'])->name('vehicles.store');
    Route::put('/{vehicle}', [ApiController::class, 'update']);
    Route::delete('/{vehicle}', [ApiController::class, 'destroy']);
});