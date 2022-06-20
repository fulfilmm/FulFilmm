<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:employee', 'authorize', 'ownership'])->group(function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('customers', CustomerController::class);
    Route::get('customers/export/excel', [CustomerController::class, 'export'])->name('customers.export');
    Route::get('companies/export/data', [CompanyController::class, 'export'])->name('companies.export');
    Route::post('customers/import/data', [CustomerController::class, 'import'])->name('customers.import');
    Route::post('companies/import/data', [CompanyController::class, 'import'])->name('companies.import');
    Route::get('companies-card', [CompanyController::class, 'card'])->name('companies.cards');
    Route::get('customers-card', [CustomerController::class, 'card'])->name('customers.cards');
});
Route::middleware(['auth:employee'])->group(function () {
    Route::get('/contact/qualified/',[CustomerController::class,'qualified_contact'])->name('qualified_contact');
    Route::post('change/contact/type',[CustomerController::class,'ChangeContactType'])->name('changeContct');
    Route::get('suppliers',[CustomerController::class,'supplier'])->name('suppliers');
});