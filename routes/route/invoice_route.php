<?php
use App\Http\Controllers\InvoiceController;

Route::get("invoice/sendmail/{id}", [InvoiceController::class, 'sending_form'])->name('invoice.sendmail');
Route::post("invoice/mail/send", [InvoiceController::class, 'email'])->name('send');
Route::post('invoice/status/{id}', [InvoiceController::class, 'status_change'])->name('invoice.statuschange');
Route::resource("invoices", InvoiceController::class);
Route::get('retail/invoice/create',[InvoiceController::class,'retail_inv'])->name('invoice.rental');
Route::get('inv/view/{type}',[InvoiceController::class,'invoice_view'])->name('invoice.list');
Route::get('inv/export/{type}',[InvoiceController::class,'export'])->name('invoices.export');
?>