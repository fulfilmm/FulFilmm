@extends('layout.mainlayout')
@section('title','Stock Out')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Stock Out</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock</li>
                        <li class="breadcrumb-item active">Out</li>
                    </ul>
                </div>
            </div>
        </div>
        <form action="{{route('stockout')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="emp">Employee <span class="text-danger"> * </span></label>
                        <select name="emp_id" id="emp" class="form-control">
                            @foreach($emps as $emp)
                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="customer">Customer <span class="text-danger"> * </span></label>
                        <select name="customer_id" id="customer" class="form-control">
                            @foreach($customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="warehouse">Warehouse <span class="text-danger"> * </span></label>
                        <select name="warehouse_id" id="warehouse" class="form-control">
                            @foreach($warehouses as $warehouse)
                            <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="variantion_id">Product <span class="text-danger"> * </span></label>
                        <select name="variantion_id" id="variantion_id" class="form-control">
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->product->name}} ({{$product->size??''}},{{$product->color??''}},{{$product->other??''}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="qty">Quantity <span class="text-danger"> * </span></label>
                        <input type="number" name="qty" class="form-control" value="{{old('qty')}}">
                    </div>
                    @error('qty')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="courier">Courier <span class="text-danger"> * </span></label>
                        <select name="courier_id" id="courier" class="form-control">
                            @foreach($couriers as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
               <div class="col-12">
                   <div class="form-group ">
                       <div class="col-12">
                           <button type="submit" class="btn btn-primary text-center">Stock Out</button>
                       </div>

                   </div>
               </div>
            </div>
        </form>
    </div>

@endsection