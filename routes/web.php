<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityTaskController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login\EmployeeAuthController as AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\RoleController;

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

Route::middleware(['auth:employee', 'authorize', 'ownership'])->group(function () {
    //resource routes
    Route::resource('roles', RoleController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('comments', CommentController::class);
    Route::resource('activities', ActivityController::class);
    Route::resource('activity_tasks', ActivityTaskController::class);
    Route::resource('groups', GroupController::class);

    //export routes
    Route::get('customers/export', [CustomerController::class, 'export'])->name('customers.export');
    Route::get('departments/export', [DepartmentController::class, 'export'])->name('departments.export');
    Route::get('employees/export/', [EmployeeController::class, 'export'])->name('employees.export');
    Route::get('companies/export', [CompanyController::class, 'export'])->name('companies.export');

    //import routes
    Route::post('customers/import', [CustomerController::class, 'import'])->name('customers.import');
    Route::post('departments/import', [DepartmentController::class, 'import'])->name('departments.import');
    Route::post('employees/import', [EmployeeController::class, 'import'])->name('employees.import');
    Route::post('companies/import', [CompanyController::class, 'import'])->name('companies.import');
});



//list routes post
Route::put('roles/assign-permission/{id}', [RoleController::class, 'assignPermission'])->name('roles.assignPermission');

//list routes
Route::get('companies-card', [CompanyController::class, 'card'])->name('companies.cards');
