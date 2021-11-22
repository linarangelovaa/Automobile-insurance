<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\VehicleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::post('login', [ApiController::class, 'login']);



Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'vehicles'], function () {

        Route::get('', [VehicleController::class, 'index'])->name('vehicles.index');
        Route::get('/list', [VehicleController::class, 'list'])->name('vehicles.list');
        Route::get('/create',           [VehicleController::class, 'create'])->name('vehicles.create');
        Route::get('/{vehicle}',          [VehicleController::class, 'show'])->name('vehicles.show');
        Route::get('/{id}/edit',     [VehicleController::class, 'edit'])->name('vehicles.edit');

        Route::post('',                 [VehicleController::class, 'store'])->name('vehicles.store');
        Route::post('{vehicle}',           [VehicleController::class, 'update'])->name('vehicles.update');
        Route::delete('delete/{id}',        [VehicleController::class, 'destroy'])->name('vehicles.destroy');
    });
});