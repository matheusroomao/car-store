<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('registration', [App\Http\Controllers\LoginController::class, 'store'])->name('public.registration.store');

Route::group(['middleware' => ['auth:sanctum']], function ($route) {
    Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
    Route::post('/me', [\App\Http\Controllers\LoginController::class, 'me'])->name('me');
    Route::get('/brands', [\App\Http\Controllers\Admin\BrandController::class,'index'])->name('brand');
    Route::get('/items', [\App\Http\Controllers\Admin\ItemController::class,'index'])->name('item');
    Route::apiResource('/cars', \App\Http\Controllers\Admin\CarController::class)->names('car');
    Route::apiResource('/car-items', \App\Http\Controllers\Admin\CarItemController::class)->names('car.item');
});
Route::group(['middleware' =>['auth:sanctum', 'auth.admin'], 'prefix' => 'admin'], function ($route) {
    Route::apiResource('/users', \App\Http\Controllers\Admin\UserController::class)->names('admin.user');
    Route::apiResource('/brands', \App\Http\Controllers\Admin\BrandController::class)->names('admin.brand');
    Route::apiResource('/items', \App\Http\Controllers\Admin\ItemController::class)->names('admin.item');
    Route::apiResource('/car-items', \App\Http\Controllers\Admin\CarItemController::class)->names('admin.car.item');
    Route::apiResource('/cars', \App\Http\Controllers\Admin\CarController::class)->names('admin.car');
});