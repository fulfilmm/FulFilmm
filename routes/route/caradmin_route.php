<?php

use App\Http\Controllers\CarBooking\CarsController;
use App\Http\Controllers\CarBooking\MaintainController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:employee'])->group(function () {
    //**  Route By Nyan  */
    //Car Booking System
    Route::get('/car-list', [CarsController::class, 'index']) -> name('carList');
    Route::get('/car-list/{any}' , [CarsController::class,'show']) -> where('any', '.*');
    Route::get('/download/{contract}' , [CarsController::class, 'download']);
    Route::get('/download/car-list/attach/{data}' , [CarsController::class, 'downloadAttach']);
    Route::get('/maintainance' , [ MaintainController::class, 'index']) -> name('maintain');
    Route::get('/maintain/{any}' , [MaintainController::class, 'show']) -> where('any', '.*');
    Route::get('/download/maintain/attaches/{data}' , [MaintainController::class, 'download']);
    Route::get('/download/maintain_record/attaches/{data}' , [MaintainController::class, 'downloadRecord']);

    //** end */
});