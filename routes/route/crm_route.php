<?php

use App\Http\Controllers\DealController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OrderlineController;
use App\Http\Controllers\QuotationController;

Route::resource('quotations', QuotationController::class);
Route::resource('quotation_items', OrderlineController::class);
Route::resource('leads', LeadController::class)->only('index', 'create', 'edit', 'store', 'destroy', 'update');
Route::get("/myfollowed/lead", [LeadController::class, 'my_followed'])->name('leads.myfollowed');
Route::get("/qualified/{id}", [LeadController::class, 'qualified'])->name("qualified");
Route::resource('deals', DealController::class)->only('index', 'create', 'edit', 'store', 'destroy', 'update');
Route::post('deal/schedule',[DealController::class,'schedule'])->name('deals.schedule');
Route::get('retail/sale/quotation',[QuotationController::class,'retailSale'])->name('quotations.retail');