@extends(\Illuminate\Support\Facades\Auth::guard('employee')->check()?'layout.mainlayout':'layouts.app')
@section('title','Order View')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Order</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Order</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap align-items-center justify-content-between my-schedule mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                    </div>
                    <div class="create-workform">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <div class="modal-product-search d-flex">

                                <a href="{{\Illuminate\Support\Facades\Auth::guard('customer')->check()?route('orders.create'):route('saleorders.create')}}" class="btn btn-primary position-relative d-flex align-items-center justify-content-between">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Order
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="col-lg-12">
                <div class="d-flex flex-wrap align-items-center justify-content-between my-schedule mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <input type="text" class="form-control mr-3" id="order_id" placeholder="Order ID">
                        <input type="text" class="form-control mr-3" id="order_id" placeholder="Status">
                        <input type="text" class="form-control mr-3" id="order_id" placeholder="Customer Name">
                        <input type="text" class="form-control mr-3" id="order_id" placeholder="From Date">
                        <input type="text" class="form-control " id="order_id" placeholder="To Date">

                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-block card-stretch">
                            <div class="card-body p-0">
                                <div class="d-flex justify-content-between align-items-center p-3">
                                    <h5 class="font-weight-bold">Orders List</h5>
                                    {{--<button class="btn btn-secondary btn-sm">--}}
                                        {{--<svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
                                            {{--<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />--}}
                                        {{--</svg>--}}
                                        {{--Export--}}
                                    {{--</button>--}}
                                </div>
                                <div class="table-responsive">
                                    <table class="table data-table mb-0">
                                        <thead class="table-color-heading">
                                        <tr class="text-light">
                                            <th scope="col" class="w-01 pr-0">
                                                <div class="d-flex justify-content-start align-items-end mb-1">
                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                        <input type="checkbox" class="custom-control-input m-0" id="customCheck">
                                                        <label class="custom-control-label" for="customCheck"></label>
                                                    </div>
                                                </div>
                                            </th>
                                            <th scope="col">
                                                <label class="text-muted m-0" for="text1">ID</label>

                                            </th>
                                            <th scope="col" class="dates">
                                                <label class="text-muted mb-0" for="validationServer01">Date</label>

                                            </th>
                                            <th scope="col">
                                                <label class="text-muted mb-0" for="text2">Customer</label>

                                            </th>
                                            <th scope="col" class="text-right">
                                                <label class="text-muted mb-0" for="text3">Total</label>

                                            </th>
                                            <th scope="col">
                                                <label class="text-muted mb-0" for="validationServer02">Status</label>






                                            </th>
                                            <th scope="col" class="text-right">
                                                <span class="text-muted" for="validationServer01">Action</span>

                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['orders'] as $order)
                                        <tr class="white-space-no-wrap">
                                            <td class="pr-0">
                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input m-0" id="customCheck1">
                                                    <label class="custom-control-label" for="customCheck1"></label>
                                                </div>
                                            </td>
                                            <td>
                                                {{$order->order_id}}
                                            </td>
                                            <td>{{$order->order_date}}</td>
                                            <td>
                                                {{$order->customer->name}}
                                            </td>
                                            <td class="text-right">
                                                {{$order->total_amount}}
                                            </td>
                                            <td>
                                                <p class="mb-0 font-weight-bold d-flex justify-content-start align-items-center">
                                                    <span class="btn btn-white btn-sm btn-rounded">
                                                        <small><i class="fa fa-dot-circle-o mr-2 text-{{$order->status=='Confirm'?'success':($order->status=='Cancel'?'danger':'info')}}"></i></small>{{$order->status}}
                                                    </span>
                                                </p>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <a class="" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="{{route('saleorders.show',$order->id)}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary mx-4" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    <a class="" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </a>
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
    </div>
@endsection