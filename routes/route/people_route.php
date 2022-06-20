<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\OfficeBranchController;
use App\Http\Controllers\Auth\Login\EmployeeAuthController as AuthController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:employee', 'authorize', 'ownership'])->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('groups', GroupController::class);
    Route::resource('departments', DepartmentController::class);
    Route::get('departments/export/data', [DepartmentController::class, 'export'])->name('departments.export');
    Route::get('employees/export/data', [EmployeeController::class, 'export'])->name('employees.export');
    Route::post('departments/import/data', [DepartmentController::class, 'import'])->name('departments.import');
    Route::post('employees/import/data', [EmployeeController::class, 'import'])->name('employees.import');
    Route::get('employees-card', [EmployeeController::class, 'card'])->name('employees.cards');
    Route::get('departments-card', [DepartmentController::class, 'card'])->name('departments.cards');
    Route::get('employee/search', [EmployeeController::class, 'search'])->name('employee.search');
    Route::post('branches/import', [OfficeBranchController::class, 'import'])->name('branch.import');
    Route::resource('officebranch', OfficeBranchController::class);
});
Route::middleware(['auth:employee'])->group(function () {
    Route::post('employee/logout', [AuthController::class, 'logout'])->name('employee.logout');
    Route::post('emp/add/office',[OfficeBranchController::class,'add_emp'])->name('empadd.office');
    Route::get('branch/report/{branch_id}',[OfficeBranchController::class,'report'])->name('branch.report');
    Route::get('settings', [SettingsController::class, 'settings'])->name('settings.settings');
    Route::post('update-profile', [SettingsController::class, 'updateProfile'])->name('settings.profile-update');
});