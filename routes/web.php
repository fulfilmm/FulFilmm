<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Repositories\Contracts\DepartmentContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login\EmployeeAuthController as AuthController;

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
Route::namespace('Auth\Login')->prefix('employees')->as('employees.')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});



Route::get('employees/export/', [EmployeeController::class, 'export']);
Route::resource('departments', DepartmentController::class);
Route::resource('employees', EmployeeController::class);
Route::resource('companies', CompanyController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
