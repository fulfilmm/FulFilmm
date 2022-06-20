<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\OfficeBranchController;

Route::resource('employees', EmployeeController::class);
Route::resource('groups', GroupController::class);
Route::resource('departments', DepartmentController::class);
Route::get('departments/export/data', [DepartmentController::class, 'export'])->name('departments.export');
Route::get('employees/export/data', [EmployeeController::class, 'export'])->name('employees.export');
Route::post('departments/import/data', [DepartmentController::class, 'import'])->name('departments.import');
Route::post('employees/import/data', [EmployeeController::class, 'import'])->name('employees.import');
Route::get('employees-card', [EmployeeController::class, 'card'])->name('employees.cards');
Route::get('departments-card', [DepartmentController::class, 'card'])->name('departments.cards');
Route::get('employee/search',[EmployeeController::class,'search'])->name('employee.search');
Route::post('branches/import',[OfficeBranchController::class,'import'])->name('branch.import');
Route::resource('officebranch',OfficeBranchController::class);