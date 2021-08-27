@extends('layout.mainlayout')
@section('title','Customer Information')
@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Customer</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Customer</li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ul>
                </div>
            </div>
        </div>
    <!-- /Page Content -->
        <div class="row mb--3">
            <div class="col-md-3">
                <div class="card bg-gradient-success border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-uppercase  mb-0 text-white">General Paid</h5>
                                <div class="dropdown-divider"></div>
                                <span class="h2 font-weight-bold mb-0 text-white">{{$data['paid_total']}}MMK</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-gradient-warning border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-uppercase text-muted mb-0 text-white">Open Invoice</h5>
                                <div class="dropdown-divider"></div>
                                <span class="h2 font-weight-bold mb-0 text-white">{{$data['open']}} MMK</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-gradient-danger border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-uppercase mb-0 text-white">Overdue Invoice</h5>
                                <div class="dropdown-divider"></div>
                                <span class="h2 font-weight-bold mb-0 text-white">{{$data['overdue']}}MMK</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-gradient-primary border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-uppercase mb-0 text-white">Ticket</h5>
                                <div class="dropdown-divider"></div>
                                <span class="h2 font-weight-bold mb-0 text-white">3 Tickets</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3 card">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active mb-3" id="v-pills-home-tab" data-toggle="pill" href="#invoice" role="tab" aria-controls="v-pills-home" aria-selected="true">
                        Invoice
                        <span class="badge badge-primary badge-pill float-right">{{count($data['invoice'])}}</span>
                    </a>
                    <a class="nav-link mb-3" id="v-pills-profile-tab" data-toggle="pill" href="#ticket" role="tab" aria-controls="v-pills-profile" aria-selected="false"> Ticket
                        <span class="badge badge-primary badge-pill float-right">{{count($data['tickets'])}}</span></a>
                    <a class="nav-link mb-3" id="v-pills-messages-tab" data-toggle="pill" href="#quotation" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                        Quotation
                        <span class="badge badge-primary badge-pill float-right">{{count($data['quotation'])}}</span>
                    </a>
                    <a class="nav-link mb-3" id="v-pills-settings-tab" data-toggle="pill" href="#deal" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                        Deal
                        <span class="badge badge-primary badge-pill float-right">{{count($data['deal'])}}</span>
                    </a>
                    <a class="nav-link mb-3" id="v-pills-settings-tab" data-toggle="pill" href="#lead" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                        Lead
                        <span class="badge badge-primary badge-pill float-right">{{count($data['lead'])}}</span>
                    </a>
                </div>
                <ul class="list-group mb-4">
                    <li class="list-group-item border-0">
                        <div class="font-weight-600">Email</div>
                        <div><small class="long-texts" title="">{{$data['customer']->email}}</small></div>
                    </li>
                    <li class="list-group-item border-0 border-top-1">
                        <div class="font-weight-600">Phone</div>
                        <div><small class="long-texts" title="">{{$data['customer']->phone}}</small></div>
                    </li>

                    <li class="list-group-item border-0 border-top-1">
                        <div class="font-weight-600">Company</div>
                        <div><small class="long-texts" title="">{{$data['customer']->company->name}}</small></div>
                    </li>
                    <li class="list-group-item border-0 border-top-1">
                        <div class="font-weight-600">Address</div>
                        <div><small>{{$data['customer']->address ??''}}</small></div>
                    </li>

                    {{--@if ($customer->reference)--}}
                    {{--@stack('customer_reference_start')--}}
                    {{--<li class="list-group-item border-0 border-top-1">--}}
                    {{--<div class="font-weight-600">{{ trans('general.reference') }}</div>--}}
                    {{--<div><small class="long-texts" title="{{ $customer->reference }}">{{ $customer->reference }}</small></div>--}}
                    {{--</li>--}}
                    {{--@stack('customer_reference_end')--}}
                    {{--@endif--}}
                </ul>
            </div>
            <div class="col-9 col-xl-9 card">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="nav-wrapper">
                                    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                        <li class="nav-item border">
                                            <a class="nav-link mb-sm-3 mb-md-0 active" id="invoices-tab" data-toggle="tab" href="#invoices-content" role="tab" aria-controls="invoices-content" aria-selected="true">
                                                Invoice
                                            </a>
                                        </li>
                                        <li class="nav-item border">
                                            <a class="nav-link mb-sm-3 mb-md-0" id="transactions-tab" data-toggle="tab" href="#transactions-content" role="tab" aria-controls="transactions-content" aria-selected="false">
                                                Transactions
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12">
                                <div class="tab-content" id="cutomer-tab-content">
                                    <div class="tab-pane fade show active" id="invoices-content" role="tabpanel" aria-labelledby="invoices-tab">
                                        <table class="table " id="tbl-invoices">
                                            <thead>
                                            <tr class="row table-head-line">
                                                <th class="col-xs-4 col-sm-1"> Id</th>
                                                <th class="col-xs-4 col-sm-3 text-right">Customer Name</th>
                                                <th class="col-sm-3 d-none d-sm-block text-left">Due Date</th>
                                                <th class="col-xs-4 col-sm-2">Status</th>
                                                <th class="col-sm-3 d-none d-sm-block text-left">Total Amount</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data['invoice'] as $item)
                                                <tr class="row align-items-center border-top-1 tr-py">
                                                    <td class="col-xs-4 col-sm-1"><a href="{{ route('invoices.show', $item->id) }}">{{ $item->invoice_id }}</a></td>
                                                    <td class="col-xs-4 col-sm-3 text-right">{{$item->customer->name}}</td>
                                                    <td class="col-sm-3 d-none d-sm-block text-left">{{\Carbon\Carbon::parse($item->due_date)->toFormattedDateString()}}</td>
                                                    <td class="col-xs-4 col-sm-2"><span class="badge badge-pill badge-success my--2">{{$item->status}}</span></td>
                                                    <td class="col-sm-3 d-none d-sm-block text-left">{{$item->grand_total}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                        <div class="card-footer py-4 table-action">
                                            <div class="row">
                                                {{--@include('partials.admin.pagination', ['items' => $invoices, 'type' => 'invoices'])--}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="transactions-content" role="tabpanel" aria-labelledby="transactions-tab">
                                        <table class="table" id="tbl-transactions">
                                            <thead class="thead-light">
                                            <tr class="row table-head-line">
                                                <th class="col-xs-6 col-sm-2">Date</th>
                                                <th class="col-xs-6 col-sm-2 text-right">Amount</th>
                                                <th class="col-sm-4 d-none d-sm-block">Category</th>
                                                <th class="col-sm-4 d-none d-sm-block">Payment Type</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            {{--@foreach($transactions as $item)--}}
                                            {{--<tr class="row align-items-center border-top-1 tr-py">--}}
                                            {{--<td class="col-xs-6 col-sm-2"><a href="{{ route('revenues.show', $item->id) }}">@date($item->paid_at)</a></td>--}}
                                            {{--<td class="col-xs-6 col-sm-2 text-right">@money($item->amount, $item->currency_code, true)</td>--}}
                                            {{--<td class="col-sm-4 d-none d-sm-block">{{ $item->category->name }}</td>--}}
                                            {{--<td class="col-sm-4 d-none d-sm-block">{{ $item->account->name }}</td>--}}
                                            {{--</tr>--}}
                                            {{--@endforeach--}}
                                            </tbody>
                                        </table>

                                        <div class="card-footer py-4 table-action">
                                            <div class="row">
                                                {{--@include('partials.admin.pagination', ['items' => $transactions, 'type' => 'transactions'])--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ticket" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <div class="table-responsive">
                            <table class="table" id="ticket">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width: 100px;">Ticket Id</th>
                                    <th style="min-width: 150px">Ticket Subject</th>
                                    <th style="min-width: 130px">Created Date</th>
                                    <th style="min-width: 150px;">Created Employee</th>
                                    <th>Priority</th>
                                    <th class="text-center">Status</th>
                                    <th style="min-width: 150px;">Last Status Change </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['tickets'] as $ticket)
                                    <tr>
                                        <td>{{$ticket->id}}</td>
                                        <td><a href="{{route('tickets.show',$ticket->id)}}">#{{$ticket->ticket_id}}</a></td>
                                        <td>{{$ticket->title}}</td>
                                        <td>{{$ticket->created_at->toFormattedDateString()}}</td>
                                        <td>{{$ticket->created_by->name}}</td>

                                        <td style="min-width: 150px;">
                                            <a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-{{$ticket->ticket_priority->color}}"></i> {{$ticket->ticket_priority->priority}}</a>

                                        </td>
                                        <td style="min-width: 150px;">
                                            @foreach($status_color as $staus=>$color)
                                                @if($staus==$ticket->ticket_status->name)
                                                    <a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o mr-1" style="color:{{$color}}"></i>{{$ticket->ticket_status->name}}</a>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{$ticket->updated_at->diffForHumans()}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="quotation" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div style="overflow-x: auto">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Customer</th>
                                            <th>Sale Person</th>
                                            <th>Payment Term</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['quotation'] as $quotation)
                                            <tr>
                                                <td><a href="{{route('quotations.show',$quotation->id)}}">#{{$quotation->quotation_id}}</a></td>
                                                <td>{{$quotation->customer->name}}</td>
                                                <td>{{$quotation->sale_person->name}}</td>
                                                <td>{{$quotation->payment_term}}</td>
                                                <td>{{$quotation->grand_total}}</td>
                                                <td class="text-center">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="{{url("/quotation/edit/$quotation->id")}}" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_quotation{{$quotation->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="delete_quotation{{$quotation->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content  modal-sm mr-auto ml-auto">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Quotation</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="text-center">
                                                <span>
                                                    Are you sure delete "{{$quotation->quotation_id}}"?
                                              </span>
                                                                    </div>
                                                                </div>
                                                                <div class="text-center">
                                                                    <button data-dismiss="modal" class="btn btn-outline-primary">No</button>
                                                                    <a href="{{route("quotations.destroy",$quotation->id)}}" class="btn btn-danger  my-2">Yes</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="deal" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div style="overflow-x: auto">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Deal Name</th>
                                            <th>Amount</th>
                                            <th>Organization</th>
                                            <th>Expected Close Date</th>
                                            <th>Sale Stage</th>
                                            <th>Assign To</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['deal'] as $deal)
                                            <tr>
                                                <td><a href="{{route('deals.show',$deal->id)}}">{{$deal->name}}</a></td>
                                                <td>{{$deal->amount}} <strong class="float-right">{{$deal->unit}}</strong></td>
                                                <td>{{$deal->customer_company->name}}</td>
                                                <td>{{$deal->close_date}}</td>
                                                <td>{{$deal->sale_stage}}</td>
                                                <td>{{$deal->employee->name}}</td>
                                                <td>
                                                    <a href="#" class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v ml-2 mt-2" style="font-size: 18px;"></i></a>
                                                    <div class="dropdown-menu">
                                                        <a href="{{route('deals.edit',$deal->id)}}" class="dropdown-item"><i class="fa fa-edit mr-2"></i>Edit</a>
                                                        <a href="{{route('deals.destroy',$deal->id)}}" class="dropdown-item"><i class="fa fa-trash-o mr-2"></i>Delete</a>
                                                    </div>
                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="lead" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                        <div class="table-responsive">
                            <div style="overflow-x: auto">
                                {{--@dd($followers)--}}
                                <table id="lead" class="table  table-nowrap custom-table mb-0 ">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Lead ID</th>
                                        <th>Customer Name</th>
                                        <th>Customer Email</th>
                                        <th>Phone</th>
                                        <th>Lead Title</th>
                                        <th>Sale Person</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Industry</th>
                                        <th>Created</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data['lead'] as $lead)
                                        <tr>
                                            <td>{{$lead->id}}</td>
                                            <td>{{$lead->lead_id}}</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    @if($lead->customer->profile==null)
                                                        <a href="#" class="avatar"><img alt="" src="img/profiles/avatar-11.jpg"></a>
                                                        <a href="#">{{$lead->customer->customer_name}}</a>
                                                    @else
                                                        <a href="{{url("/profile/".$lead->customer->id)}}" ><img alt="" class="avatar" src="{{asset("/profile/".$lead->customer->profile)}}"></a>
                                                        <a href="{{url("/profile/".$lead->customer->id)}}">{{$lead->customer->customer_name}}</a>
                                                    @endif
                                                </h2>
                                            </td>
                                            <td>{{$lead->customer->email}}</td>
                                            <td>{{$lead->customer->phone}}</td>
                                            <td><a href="{{route('leads.show',$lead->id)}}">{{$lead->title}}</a></td>
                                            <td><a href="">
                                                    @if($lead->customer->profile==null)
                                                        <a href="{{url("/emp/profile/$lead->sale_man_id")}}" class="avatar"><img alt="" src="img/profiles/avatar-11.jpg"></a>
                                                        {{$lead->saleMan->name}}
                                                    @else
                                                        <a href="{{url("/emp/profile/$lead->sale_man_id")}}" >
                                                            <img alt="" class="avatar" src="{{asset("/profile/".$lead->saleMan->emp_profile)}}"></a>
                                                        {{$lead->saleMan->name}}
                                                </a>
                                                @endif
                                                </a>
                                            </td>
                                            <td>
                                                {{$lead->priority}}
                                            </td>
                                            <td>@if($lead->is_qulified==1)
                                                    <span class="badge bg-inverse-success">Qualified</span>
                                                @else
                                                    <span class="badge bg-inverse-danger">Unqualified</span>
                                                @endif
                                            </td>
                                            <td>{{$lead->tags->tag_industry}}
                                            </td>
                                            <td>{{$lead->created_at->toFormattedDateString()}}</td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="{{route('leads.edit',$lead->id)}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <a class="dropdown-item" href="{{url("/lead/delete/$lead->id")}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                    </div>
                                                </div>
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
        </div>
    </div>



@endsection