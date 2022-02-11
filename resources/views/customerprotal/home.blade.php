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
            <div class="card-group m-b-30">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="d-block">Finish Delivery</span>
                            </div>

                        </div>
                        <h3 class="mb-3">{{$delivery_finish}}</h3>
                        <div class="progress mb-2" style="height: 5px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <a href="{{route('deliveries.index')}}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between ">
                                <div>
                                    <span class="d-block">Inprogress Delivery </span>
                                </div>
                            </div>
                            <h3 class="mb-3">{{$delivery_unfinish}}</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width:100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </a>
                </div>

                {{--<div class="card">--}}
                    {{--<div class="card-body">--}}
                        {{--<div class="d-flex justify-content-between">--}}
                            {{--<div>--}}
                                {{--<span class="d-block">Remaining Delivery Fee</span>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                        {{--<h3 class="mb-3">{{$remaining_deli_fee}}</h3>--}}

                        {{--<div class="progress mb-2" style="height: 5px;">--}}
                            {{--<div class="progress-bar bg-primary" role="progressbar" style="width:100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>--}}

                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="d-block">Total Delivery Fee</span>
                            </div>

                        </div>
                        <h3 class="mb-3">{{$deli_fee_total}}</h3>
                        <div class="progress mb-2" style="height: 5px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width:100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection