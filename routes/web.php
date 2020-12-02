<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepartmentController;
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

//export routes
Route::get('customers/export', [CustomerController::class, 'export'])->name('customers.export');
Route::get('departments/export', [DepartmentController::class, 'export'])->name('departments.export');
Route::get('employees/export/', [EmployeeController::class, 'export'])->name('employees.export');
Route::get('companies/export', [CompanyController::class, 'export'])->name('companies.export');

Route::namespace('Auth\Login')->prefix('employees')->as('employees.')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

//resource routes
Route::resource('departments', DepartmentController::class);
Route::resource('employees', EmployeeController::class);
Route::resource('companies', CompanyController::class);
Route::resource('customers', CustomerController::class);


