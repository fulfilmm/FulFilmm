<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ExpenseClaimController;
use App\Http\Controllers\ExpensesRecordController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\MinutesController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:employee', 'authorize', 'ownership'])->group(function () {
    Route::resource('expenseclaims', ExpenseClaimController::class);
    Route::get('expenseclaims/status/{status}/{id}', [ExpenseClaimController::class, 'status'])->name('exp_claim.status');
    Route::get('expclaims/cash/claim/{id}', [ExpenseClaimController::class, 'CashClaim'])->name('cash.claim');
    Route::post('expenseclaims/comment/{id}', [ExpenseClaimController::class, 'comment'])->name('exp_claim.comment');
    Route::get('expenseclaims/comment/delete/{id}', [ExpenseClaimController::class, 'commentDelete'])->name('exp_claim.comment_delete');
    Route::post('minutes/assign', [MinutesController::class, 'assign_minutes'])->name('assign.minutes');
    Route::get('booking', [RoomController::class, 'booking'])->name('booking');
    Route::post('savebooking', [RoomController::class, 'booking_save'])->name('savebooking');
    Route::get('booking/cancel/{id}', [RoomController::class, 'bookigCancel'])->name('cancel');
    Route::resource('minutes', MinutesController::class);
    Route::resource('meetings', MeetingController::class)->only('index', 'create', 'store', 'destroy', 'update');
    Route::resource('rooms', RoomController::class);
    Route::get("approvals/request/me", [ApprovalController::class, 'request_to_me'])->name('request.me');
    Route::resource('approvals', ApprovalController::class)->only('index', 'create', 'store', 'destroy', 'update');
    Route::get('requestation/cc', [ApprovalController::class, 'cc_requestation'])->name('requestation.cc');
    Route::get('requestation/search', [ApprovalController::class, 'requestatin_search'])->name('requestation.search');
    Route::get('approval/search', [ApprovalController::class, 'approval_search'])->name('approval.search');
    Route::get('cc/search', [ApprovalController::class, 'cc_search'])->name('cc.search');
    Route::get('confirm/request/item/{id}', [ApprovalController::class, 'item_confirm'])->name('item.comfirm');
});
Route::middleware(['meeting_view_relative_emp', 'auth:employee', 'authorize', 'ownership'])->group(function () {

    Route::resource('meetings', MeetingController::class)->only('show');
    Route::resource('approvals', ApprovalController::class)->only('show');

});
Route::middleware(['auth:employee'])->group(function () {
    Route::get('exp_claim/financial/approve/{id}',[ExpenseClaimController::class,'financial_approve'])->name('exp_claim.financial_approve');
    Route::get('filter/minute/{id}', [MinutesController::class, 'filter'])->name('filter.minutes');
    Route::post('approval/post/comment/{id}', [CommentController::class, 'approval_cmt'])->name('approval_cmt');
    Route::get('approval/cmt/delete/{id}', [CommentController::class, 'delete_approval_cmt'])->name('approval_cmt.delete');
    Route::post('complete/minutes', [MinutesController::class, 'complete'])->name('complete.minutes');
    Route::resource('expense_record', ExpensesRecordController::class);
    Route::get('schedule',[\App\Http\Controllers\ScheduleController::class,'index'])->name('schedule.index');
    Route::resource('assignments',\App\Http\Controllers\AssigmentController::class);
    Route::post('todo/comment',[\App\Http\Controllers\AssigmentController::class,'comment'])->name('todo.comment');
    Route::resource('todo_checklists',\App\Http\Controllers\CheckListController::class);
    Route::get('todo/remark',[\App\Http\Controllers\CheckListController::class,'remark'])->name('remark');
    Route::resource('petty_cash',\App\Http\Controllers\PettyCashController::class);
    Route::post('petty/cash/item/delete',[\App\Http\Controllers\PettyCashController::class,'item_delete']);
});