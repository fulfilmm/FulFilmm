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
        <table class="table">
            <thead>
            <tr>
                <th>Product</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->name}}</td>
                        <td><a class="btn btn-white btn-sm" href="{{url("stock/in/product/$product->id")}}">Stock In</a></td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
@endsection