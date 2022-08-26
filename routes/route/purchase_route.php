<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\PurchaseItemController;
use App\Http\Controllers\PurchaseOrderItemController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\RFQController;
use App\Http\Controllers\RFQItemController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:employee', 'authorize', 'ownership'])->group(function () {
    Route::get('sent/mail/{po_id}', [\App\Http\Controllers\PurchaseOrderController::class, 'send'])->name('po_mail.prepare');
    Route::post('po/mail/send', [\App\Http\Controllers\PurchaseOrderController::class, 'sending'])->name('po_mail.sent');
    Route::resource('purchase_request', PurchaseRequestController::class);//
    Route::post('pr/status/{id}', [PurchaseRequestController::class, 'status_change'])->name('pr.status');
    Route::resource('rfqs', RFQController::class);//
    Route::get('prepare/rfqs/{id}', [RFQController::class, 'prepare_rfq'])->name('rfq.prepare');

    Route::post('bill/item/store', [\App\Http\Controllers\BillItemController::class, 'store'])->name('billitems.store');
    Route::post('bill/item/update/{id}', [\App\Http\Controllers\BillItemController::class, 'update'])->name('billitems.update');
    Route::get('bill/item/delete/{id}', [\App\Http\Controllers\BillItemController::class, 'destroy'])->name('destroy.billitem');
    Route::get('purchase/order/create/{rfq_id}', [\App\Http\Controllers\PurchaseOrderController::class, 'rfq_to_po_create'])->name('purchase.orders');
    Route::resource('purchaseorders', \App\Http\Controllers\PurchaseOrderController::class);//
    Route::get('po/confirm/{id}', [\App\Http\Controllers\PurchaseOrderController::class, 'confirm'])->name('purchaseorders.confirm');
    Route::get('po/to/bill/create/{po_id}', [BillController::class, 'po_to_bill'])->name('po.bill');
    Route::get('delivery/to/bill/create/{deli_id}', [BillController::class, 'deli_bill'])->name('delivery.bill');
});
Route::middleware(['auth:employee'])->group(function () {
    Route::post('/pr/item/add', [PurchaseItemController::class, 'store'])->name('purchaseitem.store');
    Route::post('/pr/item/update/{id}', [PurchaseItemController::class, 'update'])->name('purchaseitem.update');
    Route::post('pr/comment', [PurchaseRequestController::class, 'comment'])->name('pr.comment');
    Route::get('pr/comment/delet/{id}', [PurchaseRequestController::class, 'cmt_delete'])->name('pr_comment.delete');
    Route::post('/pr/item/delete', [PurchaseItemController::class, 'delete'])->name('pritem.delete');
    Route::post('/rfq/item/add', [RFQItemController::class, 'store'])->name('rfqitem.store');
    Route::post('/rfq/item/update/{id}', [RFQItemController::class, 'update'])->name('rfqitem.update');
    Route::post('/rfq/item/delete', [RFQItemController::class, 'destroy'])->name('rfqitem.delete');
    Route::get('/rfq/sendmail/{vendor_id}', [RFQController::class, 'prepareemail'])->name('rfq.preparemail');
    Route::post('rfqs/send', [RFQController::class, 'sendmail'])->name('rfq.sendmail');
    Route::get('/rfq/status/change/{id}/{status}', [RFQController::class, 'statuschange'])->name('rfq.statuschange');
    Route::get('/rfq/receive/product/{id}', [RFQController::class, 'productReceive'])->name('rfq.productreceive');
    Route::post('/po/item/add', [PurchaseOrderItemController::class, 'store'])->name('poitem.store');
    Route::post('/po/item/update/{id}', [PurchaseOrderItemController::class, 'update'])->name('poitem.update');
    Route::post('/po/item/delete', [PurchaseOrderItemController::class, 'destroy'])->name('poitem.delete');
    Route::get('/rfq/duplicate/{id}',[RFQController::class,'duplicate_rfq'])->name('rfqs.duplicate');
});