@extends('layout.mainlayout')
@section('title',$detail_inv->invoice_id)
@section('content')
    <link rel="stylesheet" href="{{url(asset('css/invoice_css/argon.css'))}}">
    <!-- Page Content -->
    <div class="content container-fluid">
    <!-- Page Header -->
        <div id="header" class="">
        <div class=" content-layout">
            <div class="header-body">
                <div class="row  align-items-center">
                    <div class="col-xs-12 col-sm-4 col-md-5 align-items-center">
                        <h2 class="d-inline-flex mb-0 long-texts">Invoice: {{$detail_inv->invoice_id}}</h2></div>
                    <div class="col-xs-12 col-sm-8 col-md-7">
                        <div class="text-right">
                            <div class="dropup header-drop-top">
                                <button type="button" data-toggle="dropdown" aria-expanded="false"
                                        class="btn btn-white btn-sm"><i class="fa fa-chevron-down"></i>&nbsp; More
                                    Actions
                                </button>
                                <div role="menu" class="dropdown-menu">
                                    <a href="" id="print" class="dropdown-item "  onclick="printContent('print_me');" ><i class="fa fa-print"></i> Print</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" title="Delete" data-toggle="modal" data-target="#delete{{$detail_inv->id}}" class="dropdown-item action-delete">
                                       <i class="fa fa-trash"></i> Delete
                                    </button>
                                    <button type="button" title="Stock Out" data-toggle='modal' data-target='#stockout' class="dropdown-item action-delete">
                                     <i class="la la-cube"></i>  Stock Out
                                    </button>
                                </div>
                            </div>
                            <a href="{{route('invoices.create')}}"
                               class="btn btn-white btn-sm">
                                Add New
                            </a>
                            <button class="btn btn-danger btn-sm" type="button" id="create_pdf"><i class="fa fa-file-pdf-o mr-2"></i>PDF Download</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3" style="font-size: inherit !important;">
        <div class="col-md-2">
            Status
            <br> <strong><span class="float-left"><span class="text-dark badge badge-{{$detail_inv->status=='Paid'?'success':($detail_inv->status=='Partial'?'warning':($detail_inv->status=='Daft'?'white':'danger'))}}">
                       {{$detail_inv->status}}
                    </span></span></strong> <br><br></div>
        <div class="col-md-2">
            Customer
            <br> <strong><span class="float-left"><a href="{{route('customers.show',$detail_inv->customer->id)}}">
                      {{$detail_inv->customer->name}}
                    </a></span></strong> <br><br></div>
        <div class="col-md-2">
            Order ID
            <br> <strong><span class="float-left"><a href="https://app.akaunting.com/142258/sales/customers/1005081">
                      {{$detail_inv->order->order_id??"None"}}
                    </a></span></strong> <br><br></div>
        <div class="col-md-2">
            Tax
            <br> <strong><span class="float-left"><a href="https://app.akaunting.com/142258/sales/customers/1005081">
                      {{$detail_inv->tax->name??"None"}}({{$detail_inv->tax->rate??0}}%)
                    </a></span></strong> <br><br></div>
        <div class="col-md-2">
            Amount due
            <br>
            <strong>
                <span class="float-left" id="overdue_amount">{{$detail_inv->due_amount}}</span></strong> <br><br></div>
        <div class="col-md-2">
            Due on
            <br> <strong><span class="float-left">
                    {{\Illuminate\Support\Carbon::parse($detail_inv->due_date)->toFormattedDateString()}}               </span></strong> <br><br></div>
    </div>

   @if($detail_inv->due_amount!=0)
            <div class="card">
                <div class="card-body">
                    <div data-timeline-content="axis" data-timeline-axis-style="dashed" class="timeline timeline-one-side">
                        <div class="timeline-block"><span class="timeline-step badge-primary"><i class="la la-plus text-white"></i></span>
                            <div class="timeline-content"><h2 class="font-weight-500">
                                    Create Invoice
                                </h2>
                                <small>
                                    Status:
                                </small>
                                <small>
                                    Created on {{$detail_inv->created_at->toFormattedDateString()}}
                                </small>
                                <div class="mt-3"><a href="{{route('invoices.edit',$detail_inv->id)}}"
                                                     class="btn btn-primary btn-sm btn-alone header-button-top">
                                        Edit
                                    </a></div>
                            </div>
                        </div>
                        <div class="timeline-block"><span class="timeline-step badge-danger"><i
                                        class="la la-envelope text-white"></i></span>
                            <div class="timeline-content"><h2 class="font-weight-500">
                                    Send Invoice
                                </h2>
                                <small>
                                    Status:
                                </small>
                                <small>
                                    {{$detail_inv->send_email?'Sent':'Not sent'}}
                                </small>
                                <div class="row mt-3">
                                    <form action="{{route('invoices.update',$detail_inv->id)}}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="mark_sent" value="1">
                                        <button type="submit" class="btn btn-{{$detail_inv->mark_sent==0?'white':'success'}} btn-sm header-button-top">@if($detail_inv->mark_sent==1)<i class="la la-check-circle-o"></i> @endif Mark Sent</button>
                                    </form>
                                    <a href="{{route('invoice.sendmail',$detail_inv->id)}}">
                                        <button type="button" class="el-tooltip btn btn-{{$detail_inv->send_email?'danger':'white'}} btn-sm btn-tooltip header-button-top ml-2"
                                                                                                    aria-describedby="el-tooltip-9140" tabindex="0">
                                           <i class="fa fa-{{$detail_inv->send_email?'check-circle':''}} mr-2"></i>Send Email
                                        </button>
                                    </a>
                                   </div>
                            </div>
                        </div>
                        <div class="timeline-block"><span class="timeline-step badge-success"><i
                                        class="la la-money text-white"></i></span>
                            <div class="timeline-content"><h2 class="font-weight-500">
                                    Get Paid
                                </h2>
                                <small>
                                    Status:
                                </small>
                                <small>
                                    {{$detail_inv->status}}
                                </small>
                                <div class="mt-3">
                                    <button id="button-payment" class="btn btn-white btn-sm header-button-bottom" data-toggle='modal' data-target='#add_payment'>
                                        Cash Receiver
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-block"><span class="timeline-step badge-primary"><i
                                        class="la la-truck text-white"></i></span>
                            <div class="timeline-content"><h2 class="font-weight-500">
                                    Stock Out
                                </h2>
                                <small>
                                    Status:
                                </small>
                                <small>
                                    Somethings
                                </small>
                                <div class="mt-3">
                                    <button id="button-stockout" class="btn btn-primary btn-sm header-button-bottom" data-toggle='modal' data-target='#stockout'>
                                        Stock Out
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       @endif
    <div class="row form" >
        <div class="col-12 ">
            <div class="row" >
                <div class="col-lg-12" >
                    <div class="card shadow"  >
                        <div class="card-body" id="print_me" style="padding-top: 50px;">
                            <div class="row pb-4 mx-0 card-header-border">
                                <div class="col-lg-6 col-7 col-md-6 mb-3">
                                    <img class="is-squared"
                                         src="{{$company!=null ? url(asset('/img/profiles/'.$company->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}" style="max-width: 100px;max-height: 100px;">
                                    <span>{{$company->name??''}}</span><br><span>{{$company->email??''}}</span><br>
                                    <span>{{$company->phone??''}}</span><br>
                                    <span>{{$company->address??''}}</span>
                                </div>
                                <div class="col-lg-3 col-3">
                                    <div class="text-left">
                                        <h5 class="font-weight-bold mb-2">Invoice number</h5>
                                        <b class="mb-0">{{$detail_inv->invoice_id}}</b>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="text-right">
                                        <h5 class="font-weight-bold mb-2">Invoice Date</h5>
                                        <p class="mb-0">{{\Illuminate\Support\Carbon::parse($detail_inv->invoice_date)->toFormattedDateString()}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-4 pb-5 mx-0">
                                <div class="col-lg-6 col-6">
                                    <div class="text-left">
                                        <h5 class="font-weight-bold mb-3">Invoice From</h5>
                                        <p class="mb-0 mb-1">{{$detail_inv->employee->name}}</p>
                                        <p class="mb-0 mb-1">{{$detail_inv->employee->address}}</p>
                                        <p class="mb-0 mb-1">{{$detail_inv->employee->phone}}</p>
                                        <p class="mb-0 mb-2">{{$detail_inv->employee->email}}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-6">
                                    <div class="text-right">
                                        <h5 class="font-weight-bold mb-3">Invoice To</h5>
                                        <p class="mb-0 mb-1">{{$detail_inv->customer->company->name}}</p>
                                        <p class="mb-0 mb-1">{{$detail_inv->customer->name}}</p>
                                        <p class="mb-0 mb-1">{{$detail_inv->customer->address}}</p>
                                        <p class="mb-0 mb-2">{{$detail_inv->customer->phone}}</p>
                                        <p class="mb-0 mb-2">{{$detail_inv->customer->email}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item p-0">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>ITEM</th>
                                                        <th class="d-none d-sm-table-cell">DESCRIPTION</th>
                                                        <th>UNIT Price</th>
                                                        <th>QUANTITY</th>
                                                        <th>Unit</th>
                                                        <th class="text-right">TOTAL</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($invoic_item as $item)
                                                        <tr>
                                                            <td>{{$item->id}}</td>
                                                            <td>{{$item->variant->product_name}}({{$item->variant->variant??''}})</td>
                                                            <td class="d-none d-sm-table-cell">{!!$item->description !!}</td>
                                                            <td>{{$item->unit_price}}
                                                            <td>{{$item->quantity}}</td>
                                                            <td>{{$item->unit->unit}}</td>
                                                            <td class="text-right">{{$item->total}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-end">
                                                Total: <p class="ml-2 mb-0 font-weight-bold">  {{$detail_inv->total}} MMK </p>
                                            </div>

                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-end ">
                                                Discount: <p class="ml-2 mb-0 font-weight-bold">  {{$detail_inv->discount}} MMK</p>
                                            </div>

                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-end ">
                                                Tax: <p class="ml-2 mb-0 font-weight-bold"> {{$detail_inv->tax_amount}} MMK </p>
                                            </div>

                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-end ">
                                                Delivery Fee: <p class="ml-2 mb-0 font-weight-bold"> {{$detail_inv->delivery_fee}} MMK </p>
                                            </div>

                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-end mb-2">
                                                Grand Total: <p class="ml-2 mb-0 font-weight-bold">  {{$detail_inv->grand_total}} MMK</p>
                                            </div>

                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-12 col-12 col-md-12">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center p-4">
                                        <div class="flex align-items-start flex-column col-12">
                                            <h6>Notes</h6>
                                            <p class="mb-0 my-2">{{$detail_inv->other_information}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="accordion">
                <div class="card shadow">
                    <div id="accordion-histories-header" data-toggle="collapse" data-target="#accordion-histories-body"
                         aria-expanded="false" aria-controls="accordion-histories-body" class="card-header"><h4
                                class="mb-0">Histories<i class="fa fa-chevron-down float-right"></i></h4></div>
                    <div id="accordion-histories-body" aria-labelledby="accordion-histories-header"
                         class="hide collapse" style="">
                        <div class="table-responsive">
                            <table class="table table-flush table-hover">
                                <thead class="thead-light">
                                <tr class="row table-head-line">
                                    <th class="col-xs-4 col-sm-3">
                                        Date
                                    </th>
                                    <th class="col-xs-4 col-sm-3 text-left">
                                        Status
                                    </th>
                                    <th class="col-xs-4 col-sm-6 text-left long-texts">
                                        Description
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($history as $hist)
                                    <tr class="row align-items-center border-top-1 tr-py">
                                        <td class="col-xs-4 col-sm-3">
                                            {{\Carbon\Carbon::parse($hist->created_at)->toFormattedDateString()}}
                                        </td>
                                        <td class="col-xs-4 col-sm-3 text-left">
                                            {{$hist->status}}
                                        </td>
                                        <td class="col-xs-4 col-sm-6 text-left long-texts">
                                            {{$hist->description}}
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="accordion">
                <div class="card shadow">
                    <div id="accordion-transactions-header" data-toggle="collapse"
                         data-target="#accordion-transactions-body" aria-expanded="false"
                         aria-controls="accordion-transactions-body" class="card-header collapsed"><h4 class="mb-0">
                            Transactions <i class="fa fa-chevron-down float-right"></i></h4></div>
                    <div id="accordion-transactions-body" aria-labelledby="accordion-transactions-header"
                         class=" collapse" style="">
                        <div class="table-responsive">
                            <table class="table table-flush table-hover">
                                <thead class="thead-light">
                                <tr class="row table-head-line">
                                    <th class="col-xs-5 col-sm-4">
                                        Date
                                    </th>
                                    <th class="col-xs-4 col-sm-4">
                                        Amount
                                    </th>
                                    <th class="col-xs-3 col-sm-4 d-none d-sm-block">
                                        Account
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--@foreach($data['transaction'] as $transaction)--}}
                                      {{--<tr class="row">--}}
                                          {{--<td class="col-xs-4 col-sm-4">{{\Carbon\Carbon::parse($transaction->revenue->transaction_date)->toFormattedDateString()}}</td>--}}
                                          {{--<td class="col-xs-4 col-sm-4">{{$transaction->revenue->amount??'N/A'}}</td>--}}
                                          {{--<td class="col-xs-4 col-sm-4 d-none d-sm-block">{{$transaction->account->name}}</td>--}}
                                      {{--</tr>--}}
                                    {{--@endforeach--}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="modal fade" id="add_payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Payment</h5>
                        <button type="button" aria-hidden="true"  data-dismiss="modal" class="close">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('income.store')}}" accept-charset="UTF-8" id="transaction" role="form" novalidate="novalidate" enctype="multipart/form-data"
                          class="form-loading-button needs-validation">
                    @csrf
                        <input type="hidden" name="type" value="Revenue">
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="advance_id" value="{{isset($advan_pay->id)?$advan_pay->id:''}}">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Type Title">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="date" id="date" name="transaction_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-money"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="amount" name="amount" value="{{$detail_inv->due_amount}}">
                                            <div class="input-group-prepend">
                                                <select name="currency" id="" class="select">
                                                    <option value="MMK">MMK</option>
                                                    <option value="USD">USD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account">Account</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend" style="width: 12%">
                                                <span class="input-group-text"><i class="fa fa-bank"></i></span>
                                            </div>
                                            <select name="account" id="account" class="form-control" style="width: 83%">
                                                @foreach($data['account'] as $account)
                                                    <option value="{{$account->id}}" {{$advan_pay==null?'':($advan_pay->account_id==$account->id?'selected':"")}}>{{$account->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="customer_id">Customer</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend" style="width: 12%;">
                                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                                            </div>
                                            <input type="hidden" name="customer_id" id="customer_id" value="{{$detail_inv->customer->id}}">
                                            <input type="text" class="form-control" value="{{$detail_inv->customer->name}}" readonly>
                                            {{--<select name="customer_id" id="customer_id" class="form-control" style="width: 83%;">--}}
                                                {{--@foreach($data['customers'] as $customer)--}}
                                                    {{--<option value="{{$customer->id}}" {{$customer->id==$detail_inv->customer->id?'selected':''}}>{{$customer->name}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="approve">Casher</label>
                                        <select name="approver_id" id="" class="form-control select2">
                                           @foreach($emps as $emp)
                                            @if($emp->department->name=='Finance Department')
                                                <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                @endif
                                               @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="revenue_description">Description</label>
                                        <textarea name="description" id="revenue_description" cols="30" rows="5" class="form-control">

                                </textarea>
                                    </div>
                                </div>
                                <div class="col-md-6" id="cat_div">
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend" style="width: 10%">
                                                <span class="input-group-text"><i class="fa fa-folder"></i></span>
                                            </div>
                                            <select name="category" id="category" class="form-control " style="width: 80%" >
                                                @foreach($data['category'] as $cat)
                                                    <option value="{{$cat->name}} {{$cat->name==' Invoice'?'selected':''}}">{{$cat->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-prepend" style="width: 10%">
                                                <a href="" class="input-group-text" data-toggle='modal' data-target='#add_cat'><i
                                                            class="fa fa-plus"></i></a>
                                            </div>
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
                                                    <option value="Advance Payment" {{$advan_pay!=null?'selected':''}}>Advance Payment</option>
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
                                            <input type="text" class="form-control" name="reference" id="reference" value="{{$advan_pay==null?'':$advan_pay->order->order_id??''}}">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="invoice_id" value="{{$detail_inv->id}}">
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row save-buttons">
                                <div class="col-md-12"><a href="{{route('invoices.show',$detail_inv->id)}}"
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
        <div class="modal fade" id="stockout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Stock Out</h5>
                        <button type="button" aria-hidden="true"  data-dismiss="modal" class="close">×</button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('stockout')}}" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="customer_id" value="{{$detail_inv->customer->id}}">
                                <input type="hidden" name="type" value="Invoice">
                                <input type="hidden" name="invoice_id" value="{{$detail_inv->id}}">
                                <input type="hidden" >
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="variantion_id">Product <span class="text-danger"> * </span></label>
                                        <select name="variantion_id" id="variant_id" class="form-control select">
                                            @foreach($invoic_item as $item)
                                                <option value="{{$item->variant->id}}">{{$item->variant->product_name}} ({{$item->variant->variant}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emp">Employee <span class="text-danger"> * </span></label>
                                        <select name="emp_id" id="emp" class="form-control select">
                                            @foreach($emps as $emp)
                                                <option value="{{$emp->id}}">{{$emp->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="approver">Approver <span class="text-danger"> * </span></label>
                                        <select name="approver_id" id="approver" class="form-control select">
                                            @foreach($emps as $emp)
                                                @if($emp->role->name=='Manager')
                                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="warehouse">Warehouse <span class="text-danger"> * </span></label>
                                        <input type="text" class="form-control" value="{{$detail_inv->warehouse->name}}" readonly>
                                        <input type="hidden" name="warehouse_id" class="form-control" value="{{$detail_inv->warehouse_id}}">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="qty">Quantity <span class="text-danger"> * </span></label>
                                        <input type="hidden" name="sell_unit" id="unit_id">
                                        <input type="hidden" name="qty" id="real_qty">
                                        <div class="input-group">
                                            <input type="number" id="stockout_qty" class="form-control" value="{{old('qty')}}">
                                                <input type="text" id="unit" class="form-control">
                                        </div>
                                    </div>
                                    @error('qty')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="courier">Courier <span class="text-danger"> * </span></label>
                                        <select name="courier_id" id="courier" class="form-control select">
                                            <option value="">Select Courier</option>
                                            @foreach($data['customers'] as $courier)
                                                @if($courier->customer_type=='Courier')
                                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="desc">Description</label>
                                        <textarea name="description" id="desc" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group ">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary text-center">Stock Out</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal custom-modal fade" id="delete{{$detail_inv->id}}">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       &times;
                    </button>
                </div>
                <form action="{{route('invoices.destroy',$detail_inv->id)}}" method="POST">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <strong>Do you want to Delete Approval {{$detail_inv->invoice_id}}?</strong>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button"class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success ">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="print_me"  style="visibility: hidden">
    @include('transaction.add_category')

        <script src="{{url(asset('js/html2pdf.js'))}}"></script>
        <script>
            function printContent(el){
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
                    html2pdf().from(element).save('{{$detail_inv->invoice_id}}');
                }


            $(document).ready(function () {
                var item_id=$('#variant_id option:selected').val();
                @foreach($invoic_item as $item)
                if(item_id=='{{$item->variant->id}}') {
                    $('#unit').val('{{$item->unit->unit}}');
                    $('#unit_id').val({{$item->sell_unit}});
                    $('#stockout_qty').val({{$item->quantity}});
                    $('#real_qty').val({{$item->quantity}});
                }
                @endforeach
                $('#variant_id').on('change',function () {
                    var item_id=$('#variant_id option:selected').val();
                    @foreach($invoic_item as $item)
                            if(item_id=='{{$item->variant->id}}') {
                        $('#unit').val('{{$item->unit->unit}}');
                        $('#unit_id').val({{$item->sell_unit}});
                        $('#stockout_qty').val({{$item->quantity}});
                        $('#real_qty').val({{$item->quantity}});
                    }
                    @endforeach
                });


            });
        </script>
    </div>
    </div>
    <!-- /Page Content -->
@endsection
