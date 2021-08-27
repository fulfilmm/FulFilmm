<?php

use App\Http\Controllers\Api\ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login\EmployeeAuthController as AuthController;

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
Route::middleware(['api'])->prefix('auth')->group(function () {
    Route::resource('products',App\Http\Controllers\Api\ProductController::class);
    Route::resource('employees',\App\Http\Controllers\Api\EmployeeController::class);
    Route::post('logout',[ApiAuthController::class,'login'])->name('logout');
});
Route::post('auth/login',[ApiAuthController::class,'login'])->name('login');