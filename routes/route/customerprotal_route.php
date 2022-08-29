<?php

use App\Http\Controllers\AdvancePaymentController;
use App\Http\Controllers\Auth\Login\CustomerAuth;
use App\Http\Controllers\CustomerProtal;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\RequestTicket;
use App\Http\Controllers\SaleOrderController;
use App\Http\Controllers\ShippmentController;
use Illuminate\Support\Facades\Route;

Route::namespace('Auth\Login')->group(function () {
    Route::post('login', [CustomerAuth::class, 'login'])->name('customers.customerlogin');
    Route::post('logout', [CustomerAuth::class, 'logout'])->name('customers.logout');
});
Route::middleware(['guadcheck'])->group(function () {
    Route::resource("invoice_items", InvoiceItemController::class);
    Route::resource('saleorders', SaleOrderController::class);
    Route::resource('deliveries', ShippmentController::class);
    Route::resource('advancepayments',AdvancePaymentController::class)->only('index','show');
    Route::get('delivery/transaction',[ShippmentController::class,'transaction'])->name('delivery.transaction');


});
Route::middleware(['auth:customer'])->group(function () {
    Route::get('customer/home/', [CustomerProtal::class, 'home'])->name('home');
    Route::get('customer/quotation', [CustomerProtal::class, 'quotation'])->name('customer.quotation');
    Route::get('customer/password/change/',[CustomerProtal::class,'change_password'])->name('customers.changepassword');
    Route::get('customer/order', [CustomerProtal::class, 'dashboard'])->name('customer.orders');
    Route::get('customer/order/{id}', [CustomerProtal::class, 'dashboard'])->name('order.show');
    Route::resource('orders', SaleOrderController::class);
    Route::post('customer/password/update/{id}',[CustomerProtal::class,'password_update'])->name('password.update');
    Route::post('delivery/comment',[ShippmentController::class,'comment'])->name('delivery.comment');
    Route::get('delivery/state/{state}/{id}',[ShippmentController::class,'statuschange'])->name('delivery.state');
    Route::get('customer/invoice',[CustomerProtal::class,'invoice'])->name('customer.invoice');
    Route::get('customer/invoice/show/{id}',[CustomerProtal::class,'invoice_show'])->name('customer.invoice_show');
    Route::get('customer/ticket',[CustomerProtal::class,'ticket'])->name('customer.ticket');
    Route::get('customer/ticket/show/{id}',[CustomerProtal::class,'ticket_show'])->name('customer.ticket_show');


});
Route::get('delivery/customer/receipt/{id}',[ShippmentController::class,'receipt'])->name('receipt.confirm');
Route::get('delivery/tracking/{uuid}',[ShippmentController::class,'tracking'])->name('tracking');