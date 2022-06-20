<?php

use App\Http\Controllers\CompanySetting;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('password/reset',[EmployeeController::class,'reset_form'])->name('reset.password');
Route::post('password/reset',[EmployeeController::class,'password_reset'])->name('password.reset');
Route::middleware(['auth:employee', 'authorize', 'ownership'])->group(function () {
    Route::resource('companysettings', CompanySetting::class);
    Route::get('setting/prefix', [CompanySetting::class, 'edit'])->name('companysettings.prefix');
    Route::post('setting/prefix', [CompanySetting::class, 'update'])->name('companysetting.setprefix');
    Route::get('setting/email', [CompanySetting::class, 'emailSetting'])->name('emailsetting');
    Route::post('setting/email', [CompanySetting::class, 'mailsetting'])->name('mail.setting');
    Route::resource('roles', RoleController::class);
    Route::put('roles/assign-permission/{id}', [RoleController::class, 'assignPermission'])->name('roles.assignPermission');
    Route::get('add/permission', [RoleController::class, 'permission_create'])->name('permission.create');
    Route::post('add/permission', [RoleController::class, 'permission_store'])->name('permission.store');
});
Route::middleware(['auth:employee'])->group(function () {
    Route::get('theme/color', [SettingsController::class, 'theme_setting'])->name('theme.setting');
    Route::post('theme/color', [SettingsController::class, 'theme_color'])->name('theme.color');
    Route::get('employee/change/password',[EmployeeController::class,'password_edit'])->name('password.edit');
    Route::post('employee/update/password/{id}',[EmployeeController::class,'password_update'])->name('emp_password.update');
    Route::get('notification/index',[\App\Http\Controllers\NotificationController::class,'index'])->name('notifications.index');
    Route::get('notification/delete/{id}',[\App\Http\Controllers\NotificationController::class,'destroy'])->name('notifications.delete');
    Route::get('notification/{uuid}',[\App\Http\Controllers\NotificationController::class,'show'])->name('notifications.show');
});