@extends('layout.mainlayout')
@section('title','Courier Home')
@section('noti')
    <li class="nav-item dropdown">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i> <span class="badge badge-pill">{{count($new_deli)}}</span>
        </a>
        <div class="dropdown-menu notifications">
            <div class="topnav-dropdown-header">
                <span class="notification-title">Notifications</span>
                {{--                <a href="javascript:void(0)" class="clear-noti"> Clear All </a>--}}
            </div>
            <div class="noti-content">
                <ul class="notification-list">
                    @foreach($new_deli as $alert)
                        <li class="notification-message">
                            <a href="{{route('deliveries.show',$alert->id)}}">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="noti-details">{{$alert->employee->name??\Illuminate\Support\Facades\Auth::guard('employee')->user()->name}}
                                            <span class="noti-title">Assigned to you {{$alert->delivery_id}}</span></p>
                                        <p class="noti-time"><span class="notification-time">{{\Carbon\Carbon::parse($alert->created_at)->toFormattedDateString()}} at {{date('h:i a', strtotime(\Carbon\Carbon::parse($alert->created_at)))}}</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </li>
@endsection
@section('content')
    <div class="container-fluid content">
        <div class="row">
            <div class="col-md-12">
                @if(\Illuminate\Support\Facades\Auth::guard('customer')->user()->customer_type=='Courier')
                    <div class="row">
                        <div class="col  my-2">
                            <div class="alert-success alert mb-0 shadow">
                                <a href="{{route('deliveries.index')}}">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-file-text fa-lg"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Total Delivery</div>
                                            <span class="small">{{$total_delivery??0}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col  my-2">
                            <div class="alert-success alert mb-0 shadow">
                                <a href="{{route('deliveries.index')}}">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-file-text fa-lg"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">In-progress Delivery</div>
                                            <span class="small">{{$delivery_unfinish}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col  my-2">
                            <div class="alert-success alert mb-0 shadow">
                                <a href="{{route('deliveries.index')}}">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-file-text fa-lg"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Finish Delivery</div>
                                            <span class="small">{{$delivery_finish}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col  my-2">
                            <div class="alert-success alert mb-0 shadow">
                                <a href="{{route('deliveries.index')}}">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-file-text fa-lg"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Rejected</div>
                                            <span class="small">{{$delivery_cancel??0}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col  my-2">
                            <div class="alert-success alert mb-0 shadow">
                                <a href="{{url('advancepayments')}}">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-money fa-lg"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Advance Amount</div>
                                            <span class="small">{{$advance_amount??0.0}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col  my-2">
                            <div class="alert-success alert mb-0 shadow">
                                <a href="{{url('customer/ticket')}}">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-ticket fa-lg"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Ticket</div>
                                            <span class="small">{{$ticket_count??0}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col  my-2">
                            <div class="alert-success alert mb-0 shadow">
                                <a href="{{url('customer/invoice')}}">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-file-text fa-lg"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Total Invoice</div>
                                            <span class="small">{{$invoice_count??0}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col  my-2">
                            <div class="alert-success alert mb-0 shadow">
                                <a href="{{url('orders')}}">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-file-text fa-lg"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Orders</div>
                                            <span class="small">{{$order_count??0}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col  my-2">
                            <div class="alert-success alert mb-0 shadow">
                                <a href="{{url('orders')}}">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Credit Amount</div>
                                            <span class="small">{{\Illuminate\Support\Facades\Auth::guard('customer')->user()->current_credit??0}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection