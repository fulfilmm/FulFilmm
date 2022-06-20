<?php

use App\Http\Controllers\CaseTypeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\RequestTicket;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketPieChartReport;
use App\Http\Controllers\TicketSender;

Route::post("ticket/assign", [TicketController::class, 'assignee'])->name('tickets.assign');
Route::post('status/{id}', [TicketController::class, 'status_change'])->name('change_status');
Route::post("reassign/ticket", [TicketController::class, 'reassign'])->name('reassign');
Route::get("/piechart/report", [TicketPieChartReport::class, 'index'])->name('piechart');
Route::post('priority/change/{id}', [TicketController::class, 'priority_change'])->name('priority.change');
Route::resource('request_tickets', RequestTicket::class);
Route::get('open/ticket/{id}', [RequestTicket::class, 'openTicket'])->name('openticket');
Route::post("add/new/customer", [DealController::class, 'add_newcustomer'])->name('add_new_customer');
Route::resource('comments', CommentController::class);
Route::resource('cases', CaseTypeController::class);
Route::resource('priorities', PriorityController::class);
Route::resource('senders', TicketSender::class);
Route::resource('tickets', TicketController::class)->only('index', 'edit', 'create', 'store', 'destroy', 'update');