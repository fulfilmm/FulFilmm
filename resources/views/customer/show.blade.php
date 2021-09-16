@extends('layout.mainlayout')
@section('title','Customer Information')
@section('content')
    <!-- Page Content -->
    <link rel="stylesheet" href="https://templates.iqonic.design/datum/laravel/public/css/backend.css?v=1.0.0">
     <link rel="stylesheet" href="https://templates.iqonic.design/datum/laravel/public/css/custom.css">
    <div class="content container-fluid">
    <!-- /Page Content -->
        {{--<div class="row mb--3">--}}
            {{--<div class="col-md-3">--}}
                {{--<div class="card bg-gradient-success border-0">--}}
                    {{--<div class="card-body">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col">--}}
                                {{--<h5 class="text-uppercase  mb-0 text-white">General Paid</h5>--}}
                                {{--<div class="dropdown-divider"></div>--}}
                                {{--<span class="h2 font-weight-bold mb-0 text-white">{{$data['paid_total']}}MMK</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--<div class="card bg-gradient-warning border-0">--}}
                    {{--<div class="card-body">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col">--}}
                                {{--<h5 class="text-uppercase text-muted mb-0 text-white">Open Invoice</h5>--}}
                                {{--<div class="dropdown-divider"></div>--}}
                                {{--<span class="h2 font-weight-bold mb-0 text-white">{{$data['open']}} MMK</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--<div class="card bg-gradient-danger border-0">--}}
                    {{--<div class="card-body">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col">--}}
                                {{--<h5 class="text-uppercase mb-0 text-white">Overdue Invoice</h5>--}}
                                {{--<div class="dropdown-divider"></div>--}}
                                {{--<span class="h2 font-weight-bold mb-0 text-white">{{$data['overdue']}}MMK</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--<div class="card bg-gradient-primary border-0">--}}
                    {{--<div class="card-body">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col">--}}
                                {{--<h5 class="text-uppercase mb-0 text-white">Ticket</h5>--}}
                                {{--<div class="dropdown-divider"></div>--}}
                                {{--<span class="h2 font-weight-bold mb-0 text-white">3 Tickets</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="row">--}}
            {{--<div class="col-3 card">--}}
                {{--<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">--}}
                    {{--<a class="nav-link active mb-3" id="v-pills-home-tab" data-toggle="pill" href="#invoice" role="tab" aria-controls="v-pills-home" aria-selected="true">--}}
                        {{--Invoice--}}
                        {{--<span class="badge badge-primary badge-pill float-right">{{count($data['invoice'])}}</span>--}}
                    {{--</a>--}}
                    {{--<a class="nav-link mb-3" id="v-pills-profile-tab" data-toggle="pill" href="#ticket" role="tab" aria-controls="v-pills-profile" aria-selected="false"> Ticket--}}
                        {{--<span class="badge badge-primary badge-pill float-right">{{count($data['tickets'])}}</span></a>--}}
                    {{--<a class="nav-link mb-3" id="v-pills-messages-tab" data-toggle="pill" href="#quotation" role="tab" aria-controls="v-pills-messages" aria-selected="false">--}}
                        {{--Quotation--}}
                        {{--<span class="badge badge-primary badge-pill float-right">{{count($data['quotation.blade.php'])}}</span>--}}
                    {{--</a>--}}
                    {{--<a class="nav-link mb-3" id="v-pills-settings-tab" data-toggle="pill" href="#deal" role="tab" aria-controls="v-pills-settings" aria-selected="false">--}}
                        {{--Deal--}}
                        {{--<span class="badge badge-primary badge-pill float-right">{{count($data['deal'])}}</span>--}}
                    {{--</a>--}}
                    {{--<a class="nav-link mb-3" id="v-pills-settings-tab" data-toggle="pill" href="#lead" role="tab" aria-controls="v-pills-settings" aria-selected="false">--}}
                        {{--Lead--}}
                        {{--<span class="badge badge-primary badge-pill float-right">{{count($data['lead'])}}</span>--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<ul class="list-group mb-4">--}}
                    {{--<li class="list-group-item border-0">--}}
                        {{--<div class="font-weight-600">Email</div>--}}
                        {{--<div><small class="long-texts" title="">{{$data['customer']->email}}</small></div>--}}
                    {{--</li>--}}
                    {{--<li class="list-group-item border-0 border-top-1">--}}
                        {{--<div class="font-weight-600">Phone</div>--}}
                        {{--<div><small class="long-texts" title="">{{$data['customer']->phone}}</small></div>--}}
                    {{--</li>--}}

                    {{--<li class="list-group-item border-0 border-top-1">--}}
                        {{--<div class="font-weight-600">Company</div>--}}
                        {{--<div><small class="long-texts" title="">{{$data['customer']->company->name}}</small></div>--}}
                    {{--</li>--}}
                    {{--<li class="list-group-item border-0 border-top-1">--}}
                        {{--<div class="font-weight-600">Address</div>--}}
                        {{--<div><small>{{$data['customer']->address ??''}}</small></div>--}}
                    {{--</li>--}}

                    {{--@if ($customer->reference)--}}
                    {{--@stack('customer_reference_start')--}}
                    {{--<li class="list-group-item border-0 border-top-1">--}}
                    {{--<div class="font-weight-600">{{ trans('general.reference') }}</div>--}}
                    {{--<div><small class="long-texts" title="{{ $customer->reference }}">{{ $customer->reference }}</small></div>--}}
                    {{--</li>--}}
                    {{--@stack('customer_reference_end')--}}
                    {{--@endif--}}
                {{--</ul>--}}
            {{--</div>--}}
            {{--<div class="col-9 col-xl-9 card">--}}
                {{--<div class="tab-content" id="v-pills-tabContent">--}}
                    {{--<div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="v-pills-home-tab">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-md-12">--}}
                                {{--<div class="nav-wrapper">--}}
                                    {{--<ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">--}}
                                        {{--<li class="nav-item border">--}}
                                            {{--<a class="nav-link mb-sm-3 mb-md-0 active" id="invoices-tab" data-toggle="tab" href="#invoices-content" role="tab" aria-controls="invoices-content" aria-selected="true">--}}
                                                {{--Invoice--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                        {{--<li class="nav-item border">--}}
                                            {{--<a class="nav-link mb-sm-3 mb-md-0" id="transactions-tab" data-toggle="tab" href="#transactions-content" role="tab" aria-controls="transactions-content" aria-selected="false">--}}
                                                {{--Transactions--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                    {{--</ul>--}}
                                {{--</div>--}}
                                {{--<div class="col-12">--}}
                                {{--<div class="tab-content" id="cutomer-tab-content">--}}
                                    {{--<div class="tab-pane fade show active" id="invoices-content" role="tabpanel" aria-labelledby="invoices-tab">--}}
                                        {{--<table class="table " id="tbl-invoices">--}}
                                            {{--<thead>--}}
                                            {{--<tr class="row table-head-line">--}}
                                                {{--<th class="col-xs-4 col-sm-1"> Id</th>--}}
                                                {{--<th class="col-xs-4 col-sm-3 text-right">Customer Name</th>--}}
                                                {{--<th class="col-sm-3 d-none d-sm-block text-left">Due Date</th>--}}
                                                {{--<th class="col-xs-4 col-sm-2">Status</th>--}}
                                                {{--<th class="col-sm-3 d-none d-sm-block text-left">Total Amount</th>--}}

                                            {{--</tr>--}}
                                            {{--</thead>--}}
                                            {{--<tbody>--}}
                                            {{--@foreach($data['invoice'] as $item)--}}
                                                {{--<tr class="row align-items-center border-top-1 tr-py">--}}
                                                    {{--<td class="col-xs-4 col-sm-1"><a href="{{ route('invoices.show', $item->id) }}">{{ $item->invoice_id }}</a></td>--}}
                                                    {{--<td class="col-xs-4 col-sm-3 text-right">{{$item->customer->name}}</td>--}}
                                                    {{--<td class="col-sm-3 d-none d-sm-block text-left">{{\Carbon\Carbon::parse($item->due_date)->toFormattedDateString()}}</td>--}}
                                                    {{--<td class="col-xs-4 col-sm-2"><span class="badge badge-pill badge-success my--2">{{$item->status}}</span></td>--}}
                                                    {{--<td class="col-sm-3 d-none d-sm-block text-left">{{$item->grand_total}}</td>--}}
                                                {{--</tr>--}}
                                            {{--@endforeach--}}
                                            {{--</tbody>--}}
                                        {{--</table>--}}

                                        {{--<div class="card-footer py-4 table-action">--}}
                                            {{--<div class="row">--}}
                                                {{--@include('partials.admin.pagination', ['items' => $invoices, 'type' => 'invoices'])--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="tab-pane fade" id="transactions-content" role="tabpanel" aria-labelledby="transactions-tab">--}}
                                        {{--<table class="table" id="tbl-transactions">--}}
                                            {{--<thead class="thead-light">--}}
                                            {{--<tr class="row table-head-line">--}}
                                                {{--<th class="col-xs-6 col-sm-2">Date</th>--}}
                                                {{--<th class="col-xs-6 col-sm-2 text-right">Amount</th>--}}
                                                {{--<th class="col-sm-4 d-none d-sm-block">Category</th>--}}
                                                {{--<th class="col-sm-4 d-none d-sm-block">Payment Type</th>--}}
                                            {{--</tr>--}}
                                            {{--</thead>--}}

                                            {{--<tbody>--}}
                                            {{--@foreach($transactions as $item)--}}
                                            {{--<tr class="row align-items-center border-top-1 tr-py">--}}
                                            {{--<td class="col-xs-6 col-sm-2"><a href="{{ route('revenues.show', $item->id) }}">@date($item->paid_at)</a></td>--}}
                                            {{--<td class="col-xs-6 col-sm-2 text-right">@money($item->amount, $item->currency_code, true)</td>--}}
                                            {{--<td class="col-sm-4 d-none d-sm-block">{{ $item->category->name }}</td>--}}
                                            {{--<td class="col-sm-4 d-none d-sm-block">{{ $item->account->name }}</td>--}}
                                            {{--</tr>--}}
                                            {{--@endforeach--}}
                                            {{--</tbody>--}}
                                        {{--</table>--}}

                                        {{--<div class="card-footer py-4 table-action">--}}
                                            {{--<div class="row">--}}
                                                {{--@include('partials.admin.pagination', ['items' => $transactions, 'type' => 'transactions'])--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="tab-pane fade" id="ticket" role="tabpanel" aria-labelledby="v-pills-profile-tab">--}}
                        {{--<div class="table-responsive">--}}
                            {{--<table class="table" id="ticket">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th>#</th>--}}
                                    {{--<th style="min-width: 100px;">Ticket Id</th>--}}
                                    {{--<th style="min-width: 150px">Ticket Subject</th>--}}
                                    {{--<th style="min-width: 130px">Created Date</th>--}}
                                    {{--<th style="min-width: 150px;">Created Employee</th>--}}
                                    {{--<th>Priority</th>--}}
                                    {{--<th class="text-center">Status</th>--}}
                                    {{--<th style="min-width: 150px;">Last Status Change </th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}
                                {{--<tbody>--}}
                                {{--@foreach($data['tickets'] as $ticket)--}}
                                    {{--<tr>--}}
                                        {{--<td>{{$ticket->id}}</td>--}}
                                        {{--<td><a href="{{route('tickets.show',$ticket->id)}}">#{{$ticket->ticket_id}}</a></td>--}}
                                        {{--<td>{{$ticket->title}}</td>--}}
                                        {{--<td>{{$ticket->created_at->toFormattedDateString()}}</td>--}}
                                        {{--<td>{{$ticket->created_by->name}}</td>--}}

                                        {{--<td style="min-width: 150px;">--}}
                                            {{--<a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-{{$ticket->ticket_priority->color}}"></i> {{$ticket->ticket_priority->priority}}</a>--}}

                                        {{--</td>--}}
                                        {{--<td style="min-width: 150px;">--}}
                                            {{--@foreach($status_color as $staus=>$color)--}}
                                                {{--@if($staus==$ticket->ticket_status->name)--}}
                                                    {{--<a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o mr-1" style="color:{{$color}}"></i>{{$ticket->ticket_status->name}}</a>--}}
                                                {{--@endif--}}
                                            {{--@endforeach--}}
                                        {{--</td>--}}
                                        {{--<td>{{$ticket->updated_at->diffForHumans()}}</td>--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}
                                {{--</tbody>--}}
                            {{--</table>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="tab-pane fade" id="quotation" role="tabpanel" aria-labelledby="v-pills-messages-tab">--}}
                        {{--<div class="col-md-12">--}}
                            {{--<div class="table-responsive">--}}
                                {{--<div style="overflow-x: auto">--}}
                                    {{--<table class="table">--}}
                                        {{--<thead>--}}
                                        {{--<tr>--}}
                                            {{--<th>ID</th>--}}
                                            {{--<th>Customer</th>--}}
                                            {{--<th>Sale Person</th>--}}
                                            {{--<th>Payment Term</th>--}}
                                            {{--<th>Total</th>--}}
                                            {{--<th>Action</th>--}}
                                        {{--</tr>--}}
                                        {{--</thead>--}}
                                        {{--<tbody>--}}
                                        {{--@foreach($data['quotation.blade.php'] as $quotation)--}}
                                            {{--<tr>--}}
                                                {{--<td><a href="{{route('quotations.show',$quotation->id)}}">#{{$quotation->quotation_id}}</a></td>--}}
                                                {{--<td>{{$quotation->customer->name}}</td>--}}
                                                {{--<td>{{$quotation->sale_person->name}}</td>--}}
                                                {{--<td>{{$quotation->payment_term}}</td>--}}
                                                {{--<td>{{$quotation->grand_total}}</td>--}}
                                                {{--<td class="text-center">--}}
                                                    {{--<div class="dropdown dropdown-action">--}}
                                                        {{--<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
                                                        {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                                            {{--<a class="dropdown-item" href="{{url("quotation.blade.php$quotation->id")}}" ><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
                                                            {{--<a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_quotation{{$quotation->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="modal fade" id="delete_quotation{{$quotation->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
                                                        {{--<div class="modal-dialog" role="document">--}}
                                                            {{--<div class="modal-content  modal-sm mr-auto ml-auto">--}}
                                                                {{--<div class="modal-header">--}}
                                                                    {{--<h5 class="modal-title" id="exampleModalLabel">Delete Quotation</h5>--}}
                                                                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                                                                        {{--<span aria-hidden="true">&times;</span>--}}
                                                                    {{--</button>--}}
                                                                {{--</div>--}}
                                                                {{--<div class="modal-body">--}}
                                                                    {{--<div class="text-center">--}}
                                                {{--<span>--}}
                                                    {{--Are you sure delete "{{$quotation->quotation_id}}"?--}}
                                              {{--</span>--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}
                                                                {{--<div class="text-center">--}}
                                                                    {{--<button data-dismiss="modal" class="btn btn-outline-primary">No</button>--}}
                                                                    {{--<a href="{{route("quotations.destroy",$quotation->id)}}" class="btn btn-danger  my-2">Yes</a>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</td>--}}
                                            {{--</tr>--}}
                                        {{--@endforeach--}}
                                        {{--</tbody>--}}
                                    {{--</table>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="tab-pane fade" id="deal" role="tabpanel" aria-labelledby="v-pills-settings-tab">--}}
                        {{--<div class="col-md-12">--}}
                            {{--<div class="table-responsive">--}}
                                {{--<div style="overflow-x: auto">--}}
                                    {{--<table class="table">--}}
                                        {{--<thead>--}}
                                        {{--<tr>--}}
                                            {{--<th>Deal Name</th>--}}
                                            {{--<th>Amount</th>--}}
                                            {{--<th>Organization</th>--}}
                                            {{--<th>Expected Close Date</th>--}}
                                            {{--<th>Sale Stage</th>--}}
                                            {{--<th>Assign To</th>--}}
                                            {{--<th>Action</th>--}}
                                        {{--</tr>--}}
                                        {{--</thead>--}}
                                        {{--<tbody>--}}
                                        {{--@foreach($data['deal'] as $deal)--}}
                                            {{--<tr>--}}
                                                {{--<td><a href="{{route('deals.show',$deal->id)}}">{{$deal->name}}</a></td>--}}
                                                {{--<td>{{$deal->amount}} <strong class="float-right">{{$deal->unit}}</strong></td>--}}
                                                {{--<td>{{$deal->customer_company->name}}</td>--}}
                                                {{--<td>{{$deal->close_date}}</td>--}}
                                                {{--<td>{{$deal->sale_stage}}</td>--}}
                                                {{--<td>{{$deal->employee->name}}</td>--}}
                                                {{--<td>--}}
                                                    {{--<a href="#" class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v ml-2 mt-2" style="font-size: 18px;"></i></a>--}}
                                                    {{--<div class="dropdown-menu">--}}
                                                        {{--<a href="{{route('deals.edit',$deal->id)}}" class="dropdown-item"><i class="fa fa-edit mr-2"></i>Edit</a>--}}
                                                        {{--<a href="{{route('deals.destroy',$deal->id)}}" class="dropdown-item"><i class="fa fa-trash-o mr-2"></i>Delete</a>--}}
                                                    {{--</div>--}}
                                                {{--</td>--}}
                                            {{--</tr>--}}

                                        {{--@endforeach--}}
                                        {{--</tbody>--}}
                                    {{--</table>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="tab-pane fade" id="lead" role="tabpanel" aria-labelledby="v-pills-settings-tab">--}}
                        {{--<div class="table-responsive">--}}
                            {{--<div style="overflow-x: auto">--}}
                                {{--@dd($followers)--}}
                                {{--<table id="lead" class="table  table-nowrap custom-table mb-0 ">--}}
                                    {{--<thead>--}}
                                    {{--<tr>--}}
                                        {{--<th>#</th>--}}
                                        {{--<th>Lead ID</th>--}}
                                        {{--<th>Customer Name</th>--}}
                                        {{--<th>Customer Email</th>--}}
                                        {{--<th>Phone</th>--}}
                                        {{--<th>Lead Title</th>--}}
                                        {{--<th>Sale Person</th>--}}
                                        {{--<th>Priority</th>--}}
                                        {{--<th>Status</th>--}}
                                        {{--<th>Industry</th>--}}
                                        {{--<th>Created</th>--}}
                                        {{--<th class="text-right">Actions</th>--}}
                                    {{--</tr>--}}
                                    {{--</thead>--}}
                                    {{--<tbody>--}}
                                    {{--@foreach($data['lead'] as $lead)--}}
                                        {{--<tr>--}}
                                            {{--<td>{{$lead->id}}</td>--}}
                                            {{--<td>{{$lead->lead_id}}</td>--}}
                                            {{--<td>--}}
                                                {{--<h2 class="table-avatar">--}}
                                                    {{--@if($lead->customer->profile==null)--}}
                                                        {{--<a href="#" class="avatar"><img alt="" src="img/profiles/avatar-11.jpg"></a>--}}
                                                        {{--<a href="#">{{$lead->customer->customer_name}}</a>--}}
                                                    {{--@else--}}
                                                        {{--<a href="{{url("/profile/".$lead->customer->id)}}" ><img alt="" class="avatar" src="{{asset("/profile/".$lead->customer->profile)}}"></a>--}}
                                                        {{--<a href="{{url("/profile/".$lead->customer->id)}}">{{$lead->customer->customer_name}}</a>--}}
                                                    {{--@endif--}}
                                                {{--</h2>--}}
                                            {{--</td>--}}
                                            {{--<td>{{$lead->customer->email}}</td>--}}
                                            {{--<td>{{$lead->customer->phone}}</td>--}}
                                            {{--<td><a href="{{route('leads.show',$lead->id)}}">{{$lead->title}}</a></td>--}}
                                            {{--<td><a href="">--}}
                                                    {{--@if($lead->customer->profile==null)--}}
                                                        {{--<a href="{{url("/emp/profile/$lead->sale_man_id")}}" class="avatar"><img alt="" src="img/profiles/avatar-11.jpg"></a>--}}
                                                        {{--{{$lead->saleMan->name}}--}}
                                                    {{--@else--}}
                                                        {{--<a href="{{url("/emp/profile/$lead->sale_man_id")}}" >--}}
                                                            {{--<img alt="" class="avatar" src="{{asset("/profile/".$lead->saleMan->emp_profile)}}"></a>--}}
                                                        {{--{{$lead->saleMan->name}}--}}
                                                {{--</a>--}}
                                                {{--@endif--}}
                                                {{--</a>--}}
                                            {{--</td>--}}
                                            {{--<td>--}}
                                                {{--{{$lead->priority}}--}}
                                            {{--</td>--}}
                                            {{--<td>@if($lead->is_qulified==1)--}}
                                                    {{--<span class="badge bg-inverse-success">Qualified</span>--}}
                                                {{--@else--}}
                                                    {{--<span class="badge bg-inverse-danger">Unqualified</span>--}}
                                                {{--@endif--}}
                                            {{--</td>--}}
                                            {{--<td>{{$lead->tags->tag_industry}}--}}
                                            {{--</td>--}}
                                            {{--<td>{{$lead->created_at->toFormattedDateString()}}</td>--}}
                                            {{--<td class="text-right">--}}
                                                {{--<div class="dropdown dropdown-action">--}}
                                                    {{--<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
                                                    {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                                        {{--<a class="dropdown-item" href="{{route('leads.edit',$lead->id)}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
                                                        {{--<a class="dropdown-item" href="{{url("/lead/delete/$lead->id")}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
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
        {{--</div>--}}
        {{--<div class="row">--}}
            {{--<div class="col-lg-12">--}}
                {{--<div class="d-flex flex-wrap align-items-center justify-content-between mb-3">--}}
                    {{--<div class="d-flex align-items-center justify-content-between">--}}
                        {{--<nav aria-label="breadcrumb">--}}
                            {{--<ol class="breadcrumb p-0 mb-0">--}}
                                {{--<li class="breadcrumb-item"><a href="https://templates.iqonic.design/datum/laravel/public/customer">Customers</a></li>--}}
                                {{--<li class="breadcrumb-item active" aria-current="page">Customer View</li>--}}
                            {{--</ol>--}}
                        {{--</nav>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="col-lg-12 mb-3 d-flex justify-content-between">
                <h4 class="font-weight-bold d-flex align-items-center">Customer View</h4>
                <a href="https://templates.iqonic.design/datum/laravel/public/customer" class="btn btn-primary btn-sm d-flex align-items-center justify-content-between ml-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="ml-2">Back</span>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div>
                                <ul class="list-style-1 mb-0">
                                    <li class="list-item d-flex justify-content-start align-items-center">
                                        <div class="avatar">
                                            <img class="avatar avatar-img avatar-60 rounded-circle" src="https://templates.iqonic.design/datum/laravel/public/images/user/1.jpg" alt="01.jpg" />
                                        </div>
                                        <div class="list-style-detail ml-4 mr-2">
                                            <h5 class="font-weight-bold">Kate Smith</h5>
                                            <p class="mb-0 mt-1 text-muted">Botsford and Sons</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="row mt-3">
                                <div class="col-6 text-center mb-2">
                                    <button class="btn btn-block btn-sm btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                        <span class="">Message</span>
                                    </button>
                                </div>
                                <div class="col-6 text-center">
                                    <button class="btn btn-block btn-sm btn-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                        <span class="">Edit Profile</span>
                                    </button>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">Email ID</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 ">kate@yahoo.com</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">Birthday</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 ">01 Feb 1990</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">Phone</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 ">+99 8756214524</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">Country</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 ">USA</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">State/Region</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 ">West Virginia</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">Address</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 ">Baker Street, no. 7</p>
                                    </td>
                                </tr>
                            </table>
                        </li>
                        <li class="list-group-item">
                            <h6 class="font-weight-bold">Total Spending</h6>
                            <div id="chart-apex-column-001" style="height: 250px;width: 100%" class="custom-chart"></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body p-0">
                        <ul class="nav tab-nav-pane nav-tabs pt-2 mb-0">
                            <li class="pb-2 mb-0 nav-item"><a data-toggle="tab" class="font-weight-bold text-uppercase px-5 py-2 active" href="#invoice">Invoices</a></li>
                            <li class="pb-2 mb-0 nav-item"><a data-toggle="tab" class="font-weight-bold text-uppercase px-5 py-2" href="#activity">Activity</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="invoice" class="tab-pane fade show active">
                                <div class="d-flex justify-content-between align-items-center p-3">
                                    <h5>Invoice List</h5>
                                    <button class="btn btn-secondary btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Export
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table data-table mb-0">
                                        <thead class="table-color-heading">
                                        <tr class="text-muted">
                                            <th scope="col">ID</th>
                                            <th scope="col">Date </th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" class="text-right">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>IN-902559</td>
                                            <td>12 Jan 2020</td>
                                            <td>
                                                Order OR-561488
                                            </td>
                                            <td>
                                                <p class="mb-0 text-success d-flex justify-content-start align-items-center">
                                                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">
                                                        <circle cx="12" cy="12" r="8" fill="#3cb72c"></circle></svg>
                                                    Paid
                                                </p>
                                            </td>
                                            <td class="text-right">$104.98</td>
                                        </tr>
                                        <tr>
                                            <td>IN-552149</td>
                                            <td>15 Jan 2020</td>
                                            <td>
                                                Order OR-568842
                                            </td>
                                            <td>
                                                <p class="mb-0 text-warning d-flex justify-content-start align-items-center">
                                                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">
                                                        <circle cx="12" cy="12" r="8" fill="#db7e06"></circle></svg>
                                                    Pending
                                                </p>
                                            </td>
                                            <td class="text-right">$99.98</td>
                                        </tr>
                                        <tr>
                                            <td>IN-941529</td>
                                            <td>12 Jan 2020</td>
                                            <td>
                                                Order OR-598550
                                            </td>
                                            <td>
                                                <p class="mb-0 text-success d-flex justify-content-start align-items-center">
                                                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">
                                                        <circle cx="12" cy="12" r="8" fill="#3cb72c"></circle></svg>
                                                    Paid
                                                </p>
                                            </td>
                                            <td class="text-right">$966.12</td>
                                        </tr>
                                        <tr>
                                            <td>IN-125623</td>
                                            <td>16 Jan 2020</td>
                                            <td>
                                                Order OR-325548
                                            </td>
                                            <td>
                                                <p class="mb-0 text-success d-flex justify-content-start align-items-center">
                                                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">
                                                        <circle cx="12" cy="12" r="8" fill="#3cb72c"></circle></svg>
                                                    Completed
                                                </p>
                                            </td>
                                            <td class="text-right">$65.00</td>
                                        </tr>
                                        <tr>
                                            <td>IN-911211</td>
                                            <td>18 Jan 2020</td>
                                            <td>
                                                Order OR-125475
                                            </td>
                                            <td>
                                                <p class="mb-0 text-danger d-flex justify-content-start align-items-center">
                                                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">
                                                        <circle cx="12" cy="12" r="8" fill="#F42B3D"></circle></svg>Cancelled
                                                </p>
                                            </td>
                                            <td class="text-right">$108.99</td>
                                        </tr>
                                        <tr>
                                            <td>IN-902210</td>
                                            <td>19 Jan 2020</td>
                                            <td>
                                                Order OR-595508
                                            </td>
                                            <td>
                                                <p class="mb-0 text-success d-flex justify-content-start align-items-center">
                                                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">
                                                        <circle cx="12" cy="12" r="8" fill="#3cb72c"></circle></svg>
                                                    Paid
                                                </p>
                                            </td>
                                            <td class="text-right">$199.99</td>
                                        </tr>
                                        <tr>
                                            <td>IN-902445</td>
                                            <td>20 Jan 2020</td>
                                            <td>
                                                Order OR-884155
                                            </td>
                                            <td>
                                                <p class="mb-0 text-warning d-flex justify-content-start align-items-center">
                                                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">
                                                        <circle cx="12" cy="12" r="8" fill="#db7e06"></circle></svg>
                                                    Pending
                                                </p>
                                            </td>
                                            <td class="text-right">$99.99</td>
                                        </tr>
                                        <tr>
                                            <td>IN-901020</td>
                                            <td>22 Jan 2020</td>
                                            <td>
                                                Order OR-500008
                                            </td>
                                            <td>
                                                <p class="mb-0 text-success d-flex justify-content-start align-items-center">
                                                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">
                                                        <circle cx="12" cy="12" r="8" fill="#3cb72c"></circle></svg>
                                                    Paid
                                                </p>
                                            </td>
                                            <td class="text-right">$449.00</td>
                                        </tr>
                                        <tr>
                                            <td>IN-9036510</td>
                                            <td>22 Jan 2020</td>
                                            <td>
                                                Order OR-489523
                                            </td>
                                            <td>
                                                <p class="mb-0 text-danger d-flex justify-content-start align-items-center">
                                                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">
                                                        <circle cx="12" cy="12" r="8" fill="#F42B3D"></circle></svg>Cancelled
                                                </p>
                                            </td>
                                            <td class="text-right">$1,299.05</td>
                                        </tr>
                                        <tr>
                                            <td>IN-120010</td>
                                            <td>23 Jan 2020</td>
                                            <td>
                                                Order OR-965508
                                            </td>
                                            <td>
                                                <p class="mb-0 text-success d-flex justify-content-start align-items-center">
                                                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">
                                                        <circle cx="12" cy="12" r="8" fill="#3cb72c"></circle></svg>
                                                    Paid
                                                </p>
                                            </td>
                                            <td class="text-right">$6,325.99</td>
                                        </tr>
                                        <tr>
                                            <td>IN-302240</td>
                                            <td>15 Jan 2020</td>
                                            <td>
                                                Order OR-654412
                                            </td>
                                            <td>
                                                <p class="mb-0 text-success d-flex justify-content-start align-items-center">
                                                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">
                                                        <circle cx="12" cy="12" r="8" fill="#3cb72c"></circle></svg>
                                                    Paid
                                                </p>
                                            </td>
                                            <td class="text-right">$699.00</td>
                                        </tr>
                                        <tr>
                                            <td>IN-662210</td>
                                            <td>26 Jan 2020</td>
                                            <td>
                                                Order OR-965508
                                            </td>
                                            <td>
                                                <p class="mb-0 text-danger d-flex justify-content-start align-items-center">
                                                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">
                                                        <circle cx="12" cy="12" r="8" fill="#F42B3D"></circle></svg>Cancelled
                                                </p>
                                            </td>
                                            <td class="text-right">$150.03</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="activity" class="tab-pane fade p-3">
                                <h3 class="mb-3">Activity</h3>
                                <div class="iq-timeline0 m-0 d-flex align-items-center justify-content-between position-relative">
                                    <ul class="list-inline p-0 m-0">
                                        <li>
                                            <div class="pt-3">
                                                <p class="mb-0 text-muted font-weight-bold text-uppercase">13, September 2020</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-dots timeline-dot1 border-primary text-primary"></div>
                                            <h6 class="float-left mb-1 font-weight-bold">Signed Out</h6>
                                            <div class="d-inline-block w-100">
                                                <p class="mb-0">Santander crea una sociedad para gestionar las sucursales que cierra</p>
                                                <div class="d-inline-block w-100">
                                                    <p>Probablemente, la bodega más sostenible de españa</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-dots timeline-dot1 border-primary text-primary"></div>
                                            <h6 class="float-left mb-1 font-weight-bold">Create Invoice IN-302240</h6>
                                            <div class="d-inline-block w-100">
                                                <p>Repsol sopesa elegir primero un socio para su área de renovables y después sacarla a Bolsa</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-dots timeline-dot1 border-primary text-primary"></div>
                                            <h6 class="float-left mb-1 font-weight-bold">Signed In</h6>
                                            <div class="d-inline-block w-100">
                                                <p>El Ibex busca nuevos máximos en la última jornada de abril</p>
                                            </div>
                                            <div class="pt-3">
                                                <p class="mb-0 text-muted font-weight-bold text-uppercase">14, September 2020</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-dots timeline-dot1 border-primary text-primary"></div>
                                            <h6 class="float-left mb-1 font-weight-bold">Signed Out</h6>
                                            <div class="d-inline-block w-100">
                                                <p>Ecoener se atreve con la Bolsa y se estrenará con una valoración de 336 millones</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-dots timeline-dot1 border-primary text-primary"></div>
                                            <h6 class="float-left mb-1 font-weight-bold">Create Invoice IN-662210</h6>
                                            <div class="d-inline-block w-100">
                                                <p class="mb-0">BBVA supera la crisis del Covid y gana 1.210 millones en el primer trimestre</p>
                                            </div>
                                            <div class="d-inline-block w-100">
                                                <p>Probablemente, la bodega más sostenible de españa</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-dots timeline-dot1 border-primary text-primary"></div>
                                            <h6 class="float-left mb-1 font-weight-bold">Signed In</h6>
                                            <div class="d-inline-block w-100">
                                                <p class="mb-0">El mercado se prepara para una corrección en mayo tras el rally bursátil</p>
                                            </div>
                                            <div class="d-inline-block w-100">
                                                <p>Repsol sopesa elegir primero un socio para su área de renovables y después sacarla a Bolsa</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Backend Bundle JavaScript -->
    <script src="https://templates.iqonic.design/datum/laravel/public/js/backend-bundle.min.js"></script>
    <script src="{{url(asset('js/customerprotal_js/chart01.js'))}}"></script>



@endsection