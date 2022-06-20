<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\RFQController;

Route::get('sent/mail/{po_id}',[\App\Http\Controllers\PurchaseOrderController::class,'send'])->name('po_mail.prepare');
Route::post('po/mail/send',[\App\Http\Controllers\PurchaseOrderController::class,'sending'])->name('po_mail.sent');
Route::resource('purchase_request',PurchaseRequestController::class);//
Route::post('pr/status/{id}',[PurchaseRequestController::class,'status_change'])->name('pr.status');
Route::resource('rfqs',RFQController::class);//
Route::get('prepare/rfqs/{id}',[RFQController::class,'prepare_rfq'])->name('rfq.prepare');

Route::post('bill/item/store',[\App\Http\Controllers\BillItemController::class,'store'])->name('billitems.store');
Route::post('bill/item/update/{id}',[\App\Http\Controllers\BillItemController::class,'update'])->name('billitems.update');
Route::get('bill/item/delete/{id}',[\App\Http\Controllers\BillItemController::class,'destroy'])->name('destroy.billitem');
Route::get('purchase/order/create/{rfq_id}',[\App\Http\Controllers\PurchaseOrderController::class,'rfq_to_po_create'])->name('purchase.orders');
Route::resource('purchaseorders',\App\Http\Controllers\PurchaseOrderController::class);//
Route::get('po/confirm/{id}',[\App\Http\Controllers\PurchaseOrderController::class,'confirm'])->name('purchaseorders.confirm');
Route::get('po/to/bill/create/{po_id}',[BillController::class,'po_to_bill'])->name('po.bill');
Route::get('delivery/to/bill/create/{deli_id}',[BillController::class,'deli_bill'])->name('delivery.bill');