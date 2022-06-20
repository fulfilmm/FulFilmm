<?php

use App\Http\Controllers\Invoice\InvoiceDataController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\SaleOrderController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:employee', 'authorize', 'ownership'])->group(function () {
    Route::get("invoice/sendmail/{id}", [InvoiceController::class, 'sending_form'])->name('invoice.sendmail');
    Route::post("invoice/mail/send", [InvoiceController::class, 'email'])->name('send');
    Route::post('invoice/status/{id}', [InvoiceController::class, 'status_change'])->name('invoice.statuschange');
    Route::resource("invoices", InvoiceController::class);
    Route::get('retail/invoice/create', [InvoiceController::class, 'retail_inv'])->name('invoice.rental');
    Route::get('inv/view/{type}', [InvoiceController::class, 'invoice_view'])->name('invoice.list');
    Route::get('inv/export/{type}', [InvoiceController::class, 'export'])->name('invoices.export');
});
Route::middleware(['auth:employee'])->group(function () {
    Route::post("/invoices/search", [InvoiceController::class, 'search'])->name('invoices.search');
    Route::resource("invoice_items", InvoiceItemController::class);
    Route::get('order/to/invoice/{id}', [SaleOrderController::class, 'generate_invoice'])->name('generate_inv');
    Route::post('order/comment', [SaleOrderController::class, 'comment'])->name('orders.comment');
    Route::get('order/comment/{id}', [SaleOrderController::class, 'comment_delete'])->name('order_comment.delete');
    Route::get('order/{status}/{id}', [SaleOrderController::class, 'status_change'])->name('order.status');
    Route::post('order/assign/{id}', [SaleOrderController::class, 'assign'])->name('order.assign');
    Route::resource('saleorders', SaleOrderController::class);
    Route::get('/invoice_vue' , [InvoiceDataController::class, 'index']) -> name('invoice_vue.index');
    Route::get('invoice/{any}', [InvoiceDataController::class,'show']) -> where('any', '.*');
    Route::get('inv/cancel/{id}',[InvoiceController::class,'cancel'])->name('invoice.cancel');
});
?>

