@extends('layout.mainlayout')
@section('title',$bill->bill_id)
@section('content')
    <link rel="stylesheet" href="{{url(asset('css/invoice_css/argon.css'))}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div id="header" class="">
            <div class=" content-layout">
                <div class="header-body">
                    <div class="row  align-items-center">
                        <div class="col-xs-12 col-sm-4 col-md-5 align-items-center">
                            <h2 class="d-inline-flex mb-0 long-texts">Bill: {{$bill->bill_id}}</h2></div>
                        <div class="col-xs-12 col-sm-8 col-md-7">
                            <div class="text-right">
                                <div class="dropup header-drop-top">
                                    <button type="button" data-toggle="dropdown" aria-expanded="false"
                                            class="btn btn-white btn-sm"><i class="fa fa-chevron-down"></i>&nbsp; More
                                        Actions
                                    </button>
                                    <div role="menu" class="dropdown-menu">
                                        <a href="" id="print" class="dropdown-item "
                                           onclick="printContent('print_me');"><i class="fa fa-print"></i> Print</a>
                                        <div class="dropdown-divider"></div>
                                        <button type="button" title="Delete" data-toggle="modal"
                                                data-target="#delete{{$bill->id}}" class="dropdown-item action-delete">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                                <button class="btn btn-danger btn-sm" type="button" id="create_pdf"><i
                                            class="fa fa-file-pdf-o mr-2"></i>PDF Download
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3" style="font-size: inherit !important;">
            <div class="col-md-2">
                Status
                <br> <strong><span class="float-left"><span
                                class="text-dark badge badge-{{$bill->status=='Paid'?'success':($bill->status=='Partial'?'warning':($bill->status=='Daft'?'white':'danger'))}}">
                       {{$bill->status}}
                    </span></span></strong> <br><br></div>
            <div class="col-md-2">
                Customer
                <br> <strong><span class="float-left"><a href="{{route('customers.show',$bill->supplier->id)}}">
                      {{$bill->supplier->name}}
                    </a></span></strong> <br><br></div>
            {{--<div class="col-md-2">--}}
            {{--Tax--}}
            {{--<br> <strong><span class="float-left"><a href="https://app.akaunting.com/142258/sales/customers/1005081">--}}
            {{--{{$detail_inv->tax->name??"None"}}({{$detail_inv->tax->rate??0}}%)--}}
            {{--</a></span></strong> <br><br></div>--}}
            <div class="col-md-2">
                Amount due
                <br>
                <strong>
                    <span class="float-left" id="overdue_amount">{{$bill->due_amount}}</span></strong> <br><br></div>
            <div class="col-md-2">
                Due on
                <br> <strong><span class="float-left">
                    {{\Illuminate\Support\Carbon::parse($bill->due_date)->toFormattedDateString()}}               </span></strong>
                <br><br></div>
        </div>

        @if($bill->due_amount!=0)
            <div class="card">
                <div class="card-body">
                    <div data-timeline-content="axis" data-timeline-axis-style="dashed"
                         class="timeline timeline-one-side">
                        <div class="timeline-block"><span class="timeline-step badge-primary"><i
                                        class="la la-plus text-white"></i></span>
                            <div class="timeline-content"><h2 class="font-weight-500">
                                    Create Bill
                                </h2>
                                <small>
                                    Status:
                                </small>
                                <small>
                                    Created on {{$bill->created_at->toFormattedDateString()}}
                                </small>
                                {{--<div class="mt-3"><a href="{{route('bills.edit',$bill->id)}}"--}}
                                {{--class="btn btn-primary btn-sm btn-alone header-button-top">--}}
                                {{--Edit--}}
                                {{--</a></div>--}}
                            </div>
                        </div>
                        {{--<div class="timeline-block"><span class="timeline-step badge-danger"><i--}}
                        {{--class="la la-envelope text-white"></i></span>--}}
                        {{--<div class="timeline-content">--}}
                        {{--<h2 class="font-weight-500">--}}
                        {{--Send Invoice--}}
                        {{--</h2>--}}
                        {{--<small>--}}
                        {{--Status:--}}
                        {{--</small>--}}
                        {{--<small>--}}
                        {{--{{$bill->send_email?'Sent':'Not sent'}}--}}
                        {{--</small>--}}
                        {{--<div class="mt-3"><a href=""--}}
                        {{--class="btn btn-white btn-sm header-button-top">--}}
                        {{--Mark Sent--}}
                        {{--</a>--}}
                        {{--<a href="{{route('invoice.sendmail',$detail_inv->id)}}">--}}
                        {{--<button type="button" class="el-tooltip btn btn-{{$detail_inv->send_email?'danger':'white'}} btn-sm btn-tooltip disabled header-button-top"--}}
                        {{--aria-describedby="el-tooltip-9140" tabindex="0">--}}
                        {{--<i class="fa fa-{{$detail_inv->send_email?'check-circle':''}} mr-2"></i>Send Email--}}
                        {{--</button>--}}
                        {{--</a>--}}
                        {{--<a href="https://app.akaunting.com/142258/signed/invoices/1201302?signature=4b75ab08f681bfb43e37e90a7d50fcd207d2819ebe4d53671d59e93d7018998a"--}}
                        {{--target="_blank" class="btn btn-white btn-sm header-button-top">--}}
                        {{--Share--}}
                        {{--</a></div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="timeline-block"><span class="timeline-step badge-success"><i
                                        class="la la-money text-white"></i></span>
                            <div class="timeline-content"><h2 class="font-weight-500">
                                    Get Paid
                                </h2>
                                <small>
                                    Status:
                                </small>
                                <small>
                                    {{$bill->status}}
                                </small>
                                <div class="mt-3">
                                    <button id="button-payment" class="btn btn-success btn-sm header-button-bottom"
                                            data-toggle='modal' data-target='#add_payment'>
                                        Make Payment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row form">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" id="print_me" style="padding-top: 50px;">
                        <div class="row pb-4 mx-0 card-header-border">
                            <div class="col-lg-4 col-4 col-md-4 mb-3">
                                <img class="is-squared"
                                     src="{{$company!=null ? url(asset('/img/profiles/'.$company->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}"
                                     style="max-width: 100px;max-height: 100px;">

                            </div>
                            <div class="col-lg-4 col-4">
                                <h3 class="text-center">{{$company->name??''}}</h3>
                                <h6 class="text-center">{{$company->email??''}}</h6>
                                <h6 class='text-center'>{{$company->phone??''}}</h6>
                                <h6 class="text-center">{{$company->address??''}}</h6>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="text-right">
                                    <b class="mb-0">{{$bill->bill_id}}</b>
                                    <p class="mb-0">Bill Date
                                        : {{\Illuminate\Support\Carbon::parse($bill->bill_date)->toFormattedDateString()}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-4 pb-5 mx-0">
                            <div class="col-lg-6 col-6">
                                <div class="text-left">
                                    <h5 class="font-weight-bold mb-3">Billing Employee </h5>
                                    <p class="mb-0 mb-1">{{$bill->employee->name}}</p>
                                    <p class="mb-0 mb-1">{{$bill->employee->address}}</p>
                                    <p class="mb-0 mb-1">{{$bill->employee->phone}}</p>
                                    <p class="mb-0 mb-2">{{$bill->employee->email}}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-6">
                                <div class="text-right">
                                    <h5 class="font-weight-bold mb-3">Bill To</h5>
                                    <p class="mb-0 mb-1">{{$bill->supplier->company->name}}</p>
                                    <p class="mb-0 mb-1">{{$bill->supplier->name}}</p>
                                    <p class="mb-0 mb-1">{{$bill->supplier->address}}</p>
                                    <p class="mb-0 mb-2">{{$bill->supplier->phone}}</p>
                                    <p class="mb-0 mb-2">{{$bill->supplier->email}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="list-group list-group-flush">
                                    @if(count($bill_item)!=0)
                                        <li class="list-group-item p-0">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>Item</th>
                                                        <th class="d-none d-sm-table-cell">DESCRIPTION</th>
                                                        <th class='d-none d-sm-table-cell'>TOTAL</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($bill_item as $item)
                                                        <tr>
                                                            <td>
                                                                @if($item->type=='Purchase')
                                                                    <a href="{{route('purchaseorders.show',$item->purchaseorder->id)}}">
                                                                        {{$item->purchaseorder->po_id}}</a>
                                                                @else
                                                                    <a href="{{route('deliveries.show',$item->delivery->id)}}">  {{$item->delivery->delivery_id}}</a>
                                                                @endif
                                                            </td>
                                                            <td class="d-none d-sm-table-cell">{{$item->description}}</td>
                                                            <td>{{$item->amount}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-end">
                                                Total: <p class="ml-2 mb-0 font-weight-bold">  {{$bill->grand_total}}
                                                    MMK </p>
                                            </div>

                                        </li>
                                    @else
                                        <li class="list-group-item p-0">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>Invoice No</th>
                                                        <th class="d-none d-sm-table-cell">PO ID</th>
                                                        <th class='d-none d-sm-table-cell'>TOTAL</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>{{$bill->invoice_id}}</td>
                                                        <td>{{$bill->po_id??''}}</td>
                                                        <td>{{$bill->grand_total}} MMK</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </li>

                                @endif
                            </div>


                            </ul>
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex flex-wrap justify-content-between align-items-center p-4">
                                <div class="flex align-items-start flex-column">
                                    <h6>Notes</h6>
                                    <p class="mb-0 my-2">{{$bill->other_info}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="row">--}}
    {{--<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">--}}
    {{--<div class="accordion">--}}
    {{--<div class="card">--}}
    {{--<div id="accordion-histories-header" data-toggle="collapse" data-target="#accordion-histories-body"--}}
    {{--aria-expanded="false" aria-controls="accordion-histories-body" class="card-header"><h4--}}
    {{--class="mb-0">Histories<i class="fa fa-chevron-down float-right"></i></h4></div>--}}
    {{--<div id="accordion-histories-body" aria-labelledby="accordion-histories-header"--}}
    {{--class="hide collapse" style="">--}}
    {{--<div class="table-responsive">--}}
    {{--<table class="table table-flush table-hover">--}}
    {{--<thead class="thead-light">--}}
    {{--<tr class="row table-head-line">--}}
    {{--<th class="col-xs-4 col-sm-3">--}}
    {{--Date--}}
    {{--</th>--}}
    {{--<th class="col-xs-4 col-sm-3 text-left">--}}
    {{--Status--}}
    {{--</th>--}}
    {{--<th class="col-xs-4 col-sm-6 text-left long-texts">--}}
    {{--Description--}}
    {{--</th>--}}
    {{--</tr>--}}
    {{--</thead>--}}
    {{--<tbody>--}}
    {{--@foreach($history as $hist)--}}
    {{--<tr class="row align-items-center border-top-1 tr-py">--}}
    {{--<td class="col-xs-4 col-sm-3">--}}
    {{--{{\Carbon\Carbon::parse($hist->created_at)->toFormattedDateString()}}--}}
    {{--</td>--}}
    {{--<td class="col-xs-4 col-sm-3 text-left">--}}
    {{--{{$hist->status}}--}}
    {{--</td>--}}
    {{--<td class="col-xs-4 col-sm-6 text-left long-texts">--}}
    {{--{{$hist->description}}--}}
    {{--</td>--}}
    {{--</tr>--}}

    {{--@endforeach--}}
    {{--</tbody>--}}
    {{--</table>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">--}}
    {{--<div class="accordion">--}}
    {{--<div class="card">--}}
    {{--<div id="accordion-transactions-header" data-toggle="collapse"--}}
    {{--data-target="#accordion-transactions-body" aria-expanded="false"--}}
    {{--aria-controls="accordion-transactions-body" class="card-header collapsed"><h4 class="mb-0">--}}
    {{--Transactions <i class="fa fa-chevron-down float-right"></i></h4></div>--}}
    {{--<div id="accordion-transactions-body" aria-labelledby="accordion-transactions-header"--}}
    {{--class=" collapse" style="">--}}
    {{--<div class="table-responsive">--}}
    {{--<table class="table table-flush table-hover">--}}
    {{--<thead class="thead-light">--}}
    {{--<tr class="row table-head-line">--}}
    {{--<th class="col-xs-5 col-sm-4">--}}
    {{--Date--}}
    {{--</th>--}}
    {{--<th class="col-xs-4 col-sm-4">--}}
    {{--Amount--}}
    {{--</th>--}}
    {{--<th class="col-xs-3 col-sm-4 d-none d-sm-block">--}}
    {{--Account--}}
    {{--</th>--}}
    {{--</tr>--}}
    {{--</thead>--}}
    {{--<tbody>--}}
    {{--@foreach($data['transaction'] as $transaction)--}}
    {{--<tr class="row">--}}
    {{--<td class="col-xs-4 col-sm-4">{{\Carbon\Carbon::parse($transaction->revenue->transaction_date)->toFormattedDateString()}}</td>--}}
    {{--<td class="col-xs-4 col-sm-4">{{$transaction->revenue->amount}}</td>--}}
    {{--<td class="col-xs-4 col-sm-4 d-none d-sm-block">{{$transaction->account->name}}</td>--}}
    {{--</tr>--}}
    {{--@endforeach--}}
    {{--</tbody>--}}
    {{--</table>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    </div>
    <div class="modal fade" id="add_payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Expense</h5>
                    <button type="button" aria-hidden="true" data-dismiss="modal" class="close">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('expense.store')}}" accept-charset="UTF-8" id="transaction"
                          role="form" novalidate="novalidate" enctype="multipart/form-data"
                          class="form-loading-button needs-validation">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="type" value="Expense">
                                <input type="hidden" name="bill_id" value="{{$bill->id}}">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Title</label>
                                        <input type="text" class="form-control" name="title" placeholder="Enter Title">
                                        @error('title')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="date" id="date" name="transaction_date" class="form-control">
                                    </div>
                                    @error('transaction_date')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-money"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="amount" name="amount"
                                                   value="{{$bill->due_amount??''}}">
                                            <div class="input-group-prepend">
                                                <select name="currency" id="" class="select">
                                                    <option value="MMK">MMK</option>
                                                    <option value="USD">USD</option>
                                                </select>
                                            </div>
                                        </div>
                                        @error('amount')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                {{--<label for="account">Account</label>--}}
                                {{--<div class="input-group">--}}
                                {{--<div class="input-group-prepend">--}}
                                {{--<span class="input-group-text"><i class="fa fa-bank"></i></span>--}}
                                {{--</div>--}}
                                {{--<select name="coa_account" id="account" class="form-control">--}}
                                {{--@foreach($data['coas'] as $account)--}}
                                {{--<option value="{{$account->id}}">{{$account->code.'-'.$account->name}}</option>--}}
                                {{--@endforeach--}}
                                {{--</select>--}}
                                {{--</div>--}}
                                {{--@error('account')--}}
                                {{--<span class="text-danger">{{$message}}</span>--}}
                                {{--@enderror--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account">Bank Account</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-bank"></i></span>
                                            </div>
                                            <select name="account" id="account" class="form-control">
                                                @foreach($data['account'] as $account)
                                                    <option value="{{$account->id}}">{{$account->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('account')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="customer_id">Supplier</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                                            </div>
                                            <select name="customer_id" id="customer_id" class="form-control">
                                                <option value="">None</option>
                                                @foreach($data['customers'] as $customer)
                                                    <option value="{{$customer->id}}" {{$customer->id==$bill->vendor_id?'selected':''}}>{{$customer->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('customer_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6" id="cat_div">
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-folder"></i></span>
                                            </div>
                                            <select name="category" id="category" class="form-control">
                                                @foreach($data['category'] as $cat)
                                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-prepend">
                                                <a href="" class="input-group-text" data-toggle='modal'
                                                   data-target='#add_cat'><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        @error('category')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="revenue_description">Description</label>
                                        <textarea name="description" id="desc" cols="30" rows="5" class="form-control">
                                   {!! $exp_claim->description??'' !!}
                                </textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="recurring">Recurring</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-refresh"></i></span>
                                        </div>
                                        <select name="recurring" id="recurring" class="form-control">
                                            @foreach($data['recurring'] as $recurring)
                                                <option value="{{$recurring}}">{{$recurring}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_method">Casher</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                                            </div>
                                            <select name="approver_id" id="payment_method" class="form-control ">
                                                @foreach($data['emps'] as $emps)
                                                    @if($emps->department->name=='Finance Department')
                                                        <option value="{{$emps->id}}">{{$emps->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_method">Payment Method</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                                            </div>
                                            <select name="payment_method" id="payment_method" class="form-control ">
                                                @foreach($data['payment_method'] as $payment_method)
                                                    <option value="{{$payment_method}}">{{$payment_method}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label for="reference">Reference</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-file-text-o"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="reference" id="reference">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="attach">Attachment</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-paperclip"></i></span>
                                            </div>
                                            <input type="file" name="attachment" class="form-control" id="attach">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row save-buttons">
                                <div class="col-md-12"><a href="https://app.akaunting.com/142258/sales/revenues"
                                                          class="btn btn-outline-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-icon btn-success"><!----> <span
                                                class="btn-inner--text">Save</span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal custom-modal fade" id="delete{{$bill->id}}">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        &times;
                    </button>
                </div>
                <form action="{{route('bills.destroy',$bill->id)}}" method="POST">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <strong>Do you want to Delete Bill {{$bill->bill_id}}?</strong>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success ">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="print_me" style="visibility: hidden">
        <script src="{{url(asset('js/html2pdf.js'))}}"></script>
        @include('transaction.add_category')
        <script>
            function printContent(el) {
                // document.title = ;
                var restorepage = $('body').html();
                $('#myTab').remove();
                var printcontent = $('#' + el).clone();
                printcontent.append('<div class="row" style="position: fixed;bottom: 110px; left: 50px" ><div class="row justify-content-between"> <div class="col-12 text-center"><span>{{$company->web_link??''}}</span></div></div></div>');
                printcontent.append('<div class="row" style="position: fixed;bottom: 90px; left: 50px" ><div class="row justify-content-between"> <div class="col-12 text-center"><span>{{$company->email??''}}</span></div></div></div>');
                printcontent.append('<div class="row" style="position: fixed;bottom: 70px; left: 50px" ><div class="row justify-content-between"> <div class="col-12 text-center"><span>{{$company->phone??''}}</span></div></div></div>');
                printcontent.append('<div class="row" style="position: fixed;bottom: 50px; left: 50px" ><div class="row justify-content-between"> <div class="col-12 text-center"><span>{{$company->address??''}}</span></div></div></div>');
                $('body').empty().html(printcontent);
                $('.footer').hide();
                window.print();
                $('body').html(restorepage);
            }

            $('#create_pdf').on('click', function () {
                generatePDF();
            });

            function generatePDF() {
                // Choose the element that our invoice is rendered in.
                var element = document.getElementById('print_me');
                // Choose the element and save the PDF for our user.
                html2pdf().from(element).save('{{$bill->bill_id}}');
            }

        </script>
        <!-- /Page Content -->
@endsection
