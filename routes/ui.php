<?php
use Illuminate\Support\Facades\Route;


//Route::view('/example' ,'example.index');
////for ui testing
//Route::view('/login', 'auth.login');
Route::view('/chat', 'raw-ui.chat');
//Route::view('/','index')->middleware(['auth:employee']);
//Route::view('/error-404', 'error.error-404');
//Route::view('/error-500', 'error.error-500');
//Route::view('/forms', 'forms.form-basic-inputs');
//Route::view('tasks', 'activity.tasks');
