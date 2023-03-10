@extends('layout.mainlayout')
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
                <div class="row justify-content-between my-2">
                    <div class="col-md-2 col-5">
                        <input type="text" class="form-control shadow-sm" id="order_id" placeholder="Order ID">
                    </div>
                    <div class="col-md-2 col-5">
                        <select name="" id="status" class="select shadow-sm">
                            <option value="">Status</option>
                            <option value="Confirm">Confirm</option>
                            <option value="Cancel">Cancel</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                    @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                    <div class="col-md-2 col-5">
                        <input type="text" class="form-control shadow-sm" id="customer_name" placeholder="Customer Name">
                    </div>
                    @endif
                    <div class="col-md-2 col-5">
                        <input type="text" class="form-control shadow-sm" id="min" placeholder="From Date">
                    </div>
                    <div class="col-md-2 col-5">
                        <input type="text" class="form-control shadow-sm" id="max" placeholder="To Date">
                    </div>
                   @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                        <div class="col-md-2">

                            <a href="{{\Illuminate\Support\Facades\Auth::guard('customer')->check()?route('orders.create'):route('saleorders.create')}}" class="btn btn-primary btn-md position-relative d-flex align-items-center justify-content-between shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Order
                            </a>
                        </div>
                       @endif
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-block card-stretch shadow">
                            <div class="card-body p-0">
                                <div class="d-flex justify-content-between align-items-center p-3">
                                    <h5 class="font-weight-bold">Orders List</h5>
                                </div>
                                <div class="table-responsive col-12">
                                    <table class="table table-hover table-nowrap" id="order_table">
                                        <thead>
                                        <tr>
                                            <th scope="col">
                                                ID

                                            </th>
                                            <th scope="col">
                                                Date

                                            </th>
                                            <th scope="col">
                                                Customer
                                            </th>
                                            <th scope="col" >
                                                Total

                                            </th>
                                            <th scope="col">
                                                Status
                                            </th>
                                            <th scope="col">
                                                Action
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['orders'] as $order)
                                            <tr>
                                                <td>
                                                    {{$order->order_id}}
                                                </td>
                                                <td>{{\Carbon\Carbon::parse($order->order_date)->toFormattedDateString()}}</td>
                                                <td>
                                                    {{$order->customer->name}}
                                                </td>
                                                <td>
                                                    {{$order->grand_total}}
                                                </td>
                                                <td>
                                                    <p class="mb-0 font-weight-bold d-flex justify-content-start align-items-center">
                                                    <span class="btn btn-white btn-sm btn-rounded">
                                                        <small><i class="fa fa-dot-circle-o mr-2 text-{{$order->status=='Confirm'?'success':($order->status=='Cancel'?'danger':'info')}}"></i></small>{{$order->status}}
                                                    </span>
                                                    </p>
                                                </td>
                                               @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                                                    <td>

                                                        <a class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="{{route('saleorders.show',$order->id)}}">
                                                            <i class="la la-eye">
                                                            </i>
                                                        </a>
                                                        <a href="{{route('saleorders.edit',$order->id)}}" class="btn btn-success btn-sm"><i class="la la-edit"></i></a>
                                                        {{--<a class="" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="#">--}}
                                                        {{--<svg xmlns="http://www.w3.org/2000/svg" class="text-secondary" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
                                                        {{--<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />--}}
                                                        {{--</svg>--}}
                                                        {{--</a>--}}
                                                    </td>
                                                   @else
                                                    <td>

                                                        <a class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="{{route('orders.show',$order->id)}}">
                                                            <i class="la la-eye">
                                                            </i>
                                                        </a>
                                                    </td>
                                                @endif
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
        <script>
            $(document).ready(function(){
                $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var min = $('#min').datepicker("getDate");
                        var max = $('#max').datepicker("getDate");
                        var startDate = new Date(data[1]);
                        if (min == null && max == null) { return true; }
                        if (min == null && startDate <= max) { return true;}
                        if(max == null && startDate >= min) {return true;}
                        if (startDate <= max && startDate >= min) { return true; }
                        return false;
                    }
                );

                $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
                $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
                var table = $('#order_table').DataTable();

                // Event listener to the two range filtering inputs to redraw on input
                $('#min, #max').change(function () {
                    table.draw();
                });
            });
            $(document).ready(function() {
                $('#order_id').keyup(function () {
                    var table = $('#order_table').DataTable();
                    table.column(0).search($(this).val()).draw();

                });
            });
            $(document).ready(function() {
                $('#status').on('change',function () {
                    var table = $('#order_table').DataTable();
                    table.column(4).search($(this).val()).draw();

                });
            });
            $(document).ready(function() {
                $('#customer_name').keyup(function () {
                    var table = $('#order_table').DataTable();
                    table.column(2).search($(this).val()).draw();

                });
            });
        </script>
@endsection