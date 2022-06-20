<?php

use App\Http\Controllers\CompanySetting;
use App\Http\Controllers\RoleController;
Route::resource('companysettings', CompanySetting::class);
Route::get('setting/prefix', [CompanySetting::class, 'edit'])->name('companysettings.prefix');
Route::post('setting/prefix', [CompanySetting::class, 'update'])->name('companysetting.setprefix');
Route::get('setting/email', [CompanySetting::class, 'emailSetting'])->name('emailsetting');
Route::post('setting/email', [CompanySetting::class, 'mailsetting'])->name('mail.setting');
Route::resource('roles', RoleController::class);
Route::put('roles/assign-permission/{id}', [RoleController::class, 'assignPermission'])->name('roles.assignPermission');
Route::get('add/permission',[RoleController::class,'permission_create'])->name('permission.create');
Route::post('add/permission',[RoleController::class,'permission_store'])->name('permission.store');