<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:employee', 'authorize', 'ownership'])->group(function () {
    Route::post("/tax/create", [ProductController::class, 'tax'])->name('tax.create');
    Route::get('foc/index', [ProductController::class, 'focproduct'])->name('foc.index');
    Route::resource('products', ProductController::class);
    Route::resource('binlookup', \App\Http\Controllers\BinLookUpController::class);
    Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::resource('product_brand', ProductBrandController::class);
    Route::post('brand/import', [ProductBrandController::class, 'import'])->name('brand.import');
    Route::get('product/export', [ProductController::class, 'export'])->name('product.export');
    Route::post('product/import', [ProductController::class, 'import'])->name('product.import');
    Route::get('variant/list', [ProductController::class, 'itemlist'])->name('item.list');
    Route::get('variant/show/{id}', [ProductController::class, 'show_variant'])->name('show.variant');
    Route::get("/product/duplicate/{id}", [ProductController::class, 'duplicate'])->name('duplicate');
    Route::post("/action/confirm", [ProductController::class, 'action_confirm'])->name('action_confirm');
    Route::post("/cat/create", [ProductController::class, 'category'])->name('category.create');
    Route::post('category/import', [ProductController::class, 'cat_import'])->name('category.import');
    Route::get('product/variant/create/{id}', [ProductController::class, 'create_variant'])->name('create.variant');
    Route::post('product/variant/store', [ProductController::class, 'variant_add'])->name('variant.store');
    Route::post('product/variant/update/{id}', [ProductController::class, 'update_variant'])->name('variant.update');
    Route::get('stock/transfer/receipt/{id}', [StockTransactionController::class, 'confirm'])->name('stock_transfer.confirm');
    Route::post('stock/transfer/validate/{id}', [StockTransactionController::class, 'transfer_validate'])->name('stock_transfer.validate');
    Route::get('stockin', [StockTransactionController::class, 'stockin_form'])->name('showstockin');
    Route::post('stockin', [StockTransactionController::class, 'stock_in'])->name('stockin');
    Route::get('stockout', [StockTransactionController::class, 'stockout_form'])->name('showstockout');
    Route::post('stockout', [StockTransactionController::class, 'stockout'])->name('stockout');
    Route::get('stocks/index', [StockTransactionController::class, 'index'])->name('stocks.index');
    Route::get('stock/transfer', [StockTransactionController::class, 'transfer'])->name('show.transfer');
    Route::post('transfer', [StockTransactionController::class, 'stock_transfer'])->name('stocks.transfer');
    Route::get('transfer/index', [StockTransactionController::class, 'transfer_record'])->name('transfer.index');
    Route::get('stocks', [StockTransactionController::class, 'stock'])->name('stocks');
    Route::post('stock/import', [StockTransactionController::class, 'import'])->name('stocks.import');
    Route::get('stock/batch/{p_id}', [StockTransactionController::class, 'batch'])->name('stock.batch');
    Route::get('ecommerce/stock/index', [StockTransactionController::class, 'ecommerce_stock'])->name('ecommerce_stock');
    Route::get('add/to/stock/{id}', [InventoryController::class, 'receipt'])->name('to.stock');
    Route::get('stockout/index', [StockTransactionController::class, 'stockoutindex'])->name('stock.out.index');

    Route::get('stockout/approve/{id}', [StockTransactionController::class, 'approve'])->name('stockout.approve');
    Route::get('stock/export', [StockTransactionController::class, 'export'])->name('stock.export');
    Route::get('demage/index', [StockTransactionController::class, 'damage'])->name('damage.index');
    Route::post('stock/update/{p_id}', [StockTransactionController::class, 'update'])->name('stock.update');
    Route::get('stock/update/history/{id}', [StockTransactionController::class, 'history'])->name('update.history');
    Route::get('stock/transaction/search', [StockTransactionController::class, 'stockfilter'])->name('stock.search');
    Route::get('stock/report', [ReportController::class, 'stock'])->name('report.stock');
    Route::get('expired/product', [StockTransactionController::class, 'expired_product'])->name('expired.products');
    Route::get('expired/alert/product', [StockTransactionController::class, 'alert_product'])->name('alert.products');
    Route::resource('stockreturn', \App\Http\Controllers\StockReturnController::class);
    Route::get('mobile/warehouse/return', [\App\Http\Controllers\StockReturnController::class, 'mobilereturn'])->name('stockreturn.mobile');
    Route::get('qty/alert', [StockTransactionController::class, 'qtyalert'])->name('alert.qty');
    Route::get('stock/in/report', [ReportController::class, 'stockin'])->name('report.stockin');
    Route::get('stock/out/report', [ReportController::class, 'stockout'])->name('report.stockout');
    Route::get('report/stockreturn', [ReportController::class, 'stockreturn'])->name('report.return');
    Route::get('report/stocktansfer', [ReportController::class, 'stocktransfer'])->name('report.transfer');
    Route::get('barcode/generate', [\App\Http\Controllers\BarcodeController::class, 'barcode'])->name('barcode.generate');
    Route::get('barcode/create', [\App\Http\Controllers\BarcodeController::class, 'barcodecreate'])->name('barcode.create');
    Route::get('rfq/receipt/process/', [InventoryController::class, 'recipt_proceslist'])->name('receiptprocess');
    Route::get('receipt/show/{id}', [InventoryController::class, 'show'])->name('receipt.show');
    Route::post('receipt/product/validate/{id}', [InventoryController::class, 'product_validate'])->name('product.validate');
    Route::get('reedit/{id}', [InventoryController::class, 'reedit'])->name('receipt.rededit');
});
Route::middleware(['auth:employee'])->group(function () {
    Route::get('product/category', [ProductController::class, 'category_index'])->name('category');
    Route::get('product/category/delete/{id}', [ProductController::class, 'category_delete'])->name('category.delete');
    Route::post('product/category/update/{id}', [ProductController::class, 'category_update'])->name('category.update');
    Route::get('product/tax/delete/{id}', [ProductController::class, 'tax_delete'])->name('taxes.delete');
    Route::get('product/tax/', [ProductController::class, 'tax_index'])->name('taxes');
    Route::resource('warehouses',WarehouseController::class);
});