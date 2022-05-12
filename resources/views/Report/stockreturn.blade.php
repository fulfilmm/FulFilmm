@extends('layout.mainlayout')
@section('title','Stock Return Report')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="card shadow">
            <div class="col-12 my-3">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="float-right"><a href="{{url('reports')}}" class="btn btn-danger btn-sm rounded-circle"><i class="la la-close"></i></a></div>
                            <h3 class="page-title">Stock Return Report</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>

                                <li class="breadcrumb-item active"><a href="{{url('reports')}}">Report</a></li>
                                <li class="breadcrumb-item active">Stock Return Report</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 my-3" style="overflow: auto">
                <table class="table table-hover table-nowrap">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Variant</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Employee</th>
                        <th>Customer</th>
                        <th>Warehouse</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stock_return as $item)
                        <tr>
                            <td>{{$item->created_at->toFormattedDateString()}}</td>
                            <td>{{$item->variant->product_name}}</td>
                            <td>{{$item->variant->variant}}</td>
                            <td>{{$item->description}}</td>
                            <td>{{$item->qty}}</td>
                            <td>{{$item->unit->unit}}</td>
                            <td>{{$item->employee->name??'N/A'}}</td>
                            <td>{{$item->customer->name??'N/A'}}</td>
                            <td>{{$item->warehouse->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection