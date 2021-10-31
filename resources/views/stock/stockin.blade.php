@extends('layout.mainlayout')
@section('title','Stock In')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Stock In</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock</li>
                        <li class="breadcrumb-item active">Out</li>
                    </ul>
                </div>
            </div>
        </div>
        <form action="{{route('stockin')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="customer">Customer</label>
                        <select name="supplier_id" id="customer" class="form-control">
                            @foreach($customers as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="warehouse">Warehouse</label>
                        <select name="warehouse_id" id="warehouse" class="form-control">
                            @foreach($warehouses as $warehouse)
                                <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="warehouse">Product</label>
                        <select name="variation_id" id="warehouse" class="form-control">
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->product->name}} ({{$product->size??''}}{{$product->color?','.$product->color:''}}{{$product->other?','.$product->other:''}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="qty">Quantity</label>
                        <input type="number" name="qty" class="form-control">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary text-center">Stock In</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection