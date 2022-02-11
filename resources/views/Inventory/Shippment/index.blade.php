@extends('layout.mainlayout')
@section('title','Delivery List')
@if(\Illuminate\Support\Facades\Auth::guard('customer')->check())
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
    @endif
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Delivery</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Delivery</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12" style="overflow: auto">
            <table class="table ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Courier</th>
                        <th>Warehouse</th>
                        <th>Shipping Address</th>
                        <th>Customer</th>
                        <th>Invoice ID</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                   @foreach($deliveries as $deli)
                    <tr>
                        <th><a href="{{route('deliveries.show',$deli->id)}}">{{$deli->delivery_id}}</a></th>
                        <td>{{\Carbon\Carbon::parse($deli->delivery_date)->toFormattedDateString()}}</td>

                        <td>{{$deli->courier->name??''}}</td>
                        <td>{{$deli->warehouse->name??''}}</td>
                        <td>{{$deli->shipping_address??''}}</td>
                        <td>{{$deli->customer->name??''}}</td>
                        <td>@if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                                <a href="{{route('invoices.show',$deli->invoice->id)}}">{{$deli->invoice->invoice_id}}</a>
                                @else
                                {{$deli->invoice->invoice_id??''}}
                            @endif
                        </td>

                        <td>
                            <a href="{{route('deliveries.show',$deli->id)}}" class="btn btn-white btn-sm"><i class="fa fa-eye"></i></a>
                            <a href="{{route('deliveries.edit',$deli->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a></td>
                    </tr>
                       @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
           $('.table').DataTable();
        });
    </script>
    @endsection