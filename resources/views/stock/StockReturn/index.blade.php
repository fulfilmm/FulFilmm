@extends('layout.mainlayout')
@section('title','Stock Return')
@section('content')
    <!-- Page Content -->

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Stock Return</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock Return</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('stockreturn.create')}}" class="btn add-btn shadow-sm" ><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
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
                                <th>From Warehouse</th>
                                <th>Warehouse</th>
                                <th>Attachment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stockreturn as $item)
                                <tr>
                                    <td>{{$item->created_at->toFormattedDateString()}}</td>
                                    <td>{{$item->variant->product_name}}</td>
                                    <td>{{$item->variant->variant}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>{{$item->qty}}</td>
                                    <td>{{$item->unit->unit}}</td>
                                    <td>{{$item->employee->name??'N/A'}}</td>
                                    <td>{{$item->customer->name??'N/A'}}</td>
                                    <td>{{$item->from_warehouse->name??'N/A'}}</td>
                                    <td>{{$item->warehouse->name}}</td>
                                    <td></td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection