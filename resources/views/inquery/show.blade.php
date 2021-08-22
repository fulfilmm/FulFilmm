{{--@extends("layout.mainlayout")--}}
{{--@section('title','Inquery Detail View')--}}
{{--@section("content")--}}
    {{--<style>--}}
        {{--input[type="file"] {--}}
            {{--display: block;--}}
        {{--}--}}

    {{--</style>--}}
    {{--<!-- Page Content -->--}}
    {{--<div class="content container-fluid">--}}
        {{--<!-- Page Header -->--}}
        {{--<div class="page-header">--}}
            {{--<div class="row">--}}
                {{--<div class="col-sm-12">--}}
                    {{--<h3 class="page-title">InQuery</h3>--}}
                    {{--<ul class="breadcrumb">--}}
                        {{--<li class="breadcrumb-item"><a href="{{url("/home")}}">Dashboard</a></li>--}}
                        {{--<li class="breadcrumb-item active"><a href="{{route('inqueries.index')}}">Inquery</a></li>--}}
                        {{--<li class="breadcrumb-item active">Details</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
                {{--<div class="offset-md-8 col-auto my-3">--}}
                    {{--@if($in_query->convert_lead!=1)--}}
                        {{--<a href="{{route('convert.lead',$in_query->id)}}" class="btn add-btn"><i class="fa fa-share"></i>Convert To Lead</a>--}}
                    {{--@endif--}}
                {{--</div>--}}

        {{--</div>--}}
        {{--<!-- /Page Header -->--}}
        {{--<div class=" col-md-10 offset-md-1">--}}

            {{--<div class="card">--}}
               {{--<div class="col-12 my-3">--}}
                       {{--<h3 align="center" class="my-3">{{$in_query->subject}}</h3>--}}
                   {{--<div class="row mt-2">--}}
                       {{--<div class="col-md-4">--}}
                           {{--<span>Customer Name</span>--}}
                           {{--<span class="text-blue">: {{$in_query->customer_name}}</span>--}}
                       {{--</div>--}}
                       {{--<div class="col-md-4">--}}
                           {{--<span>Email</span>--}}
                           {{--<span class="text-blue">: {{$in_query->email}}</span>--}}
                       {{--</div>--}}
                       {{--<div class="col-md-4">--}}
                           {{--<span>Phone</span>--}}
                           {{--<span class="text-blue">: {{$in_query->phone}}</span>--}}
                       {{--</div>--}}
                   {{--</div>--}}
                   {{--<div class="row mt-2">--}}
                       {{--<div class="col-md-4">--}}
                           {{--<span>Township</span>--}}
                           {{--<span class="text-blue">: {{$in_query->township}}</span>--}}
                       {{--</div>--}}
                       {{--<div class="col-md-4">--}}
                           {{--<span>Customer Age</span>--}}
                           {{--<span class="text-blue">: {{$in_query->age}}</span>--}}
                       {{--</div>--}}
                   {{--</div>--}}
                   {{--<div class="row mt-3">--}}
                       {{--<div class="col-md-12">--}}
                          {{--<div class="form-group">--}}
                              {{--<label for="">Description:</label>--}}
                              {{--<textarea class="form-control text-danger" name="" id="" cols="30" rows="10">--}}
                               {{--{{$in_query->description}}--}}
                           {{--</textarea>--}}
                          {{--</div>--}}
                       {{--</div>--}}
                   {{--</div>--}}
               {{--</div>--}}
            {{--</div>--}}
               {{--<div class="card">--}}
                   {{--<div class="col-12">--}}
                       {{--<div class="card-header">--}}
                          {{--InQuery Products--}}
                       {{--</div>--}}
                       {{--@php--}}
                           {{--$inquery_products=json_decode(($in_query->product));--}}
                       {{--@endphp--}}
                       {{--<div class="row my-3">--}}
                           {{--@for($i=0;$i<count($inquery_products);$i++ )--}}
                               {{--@foreach($products as $product)--}}
                                   {{--@if($product->id==$inquery_products[$i])--}}
                                       {{--<div class="col-md-3">--}}
                                           {{--<a href="{{route("products.show",$product->id)}}" title="{{$product->name}}" >--}}
                                               {{--<img src="{{url(asset("/product_picture/$product->image"))}}" class="border rounded" alt="product picture" width="200px" height="200px;">--}}
                                           {{--</a>--}}
                                           {{--<div class="text-center mt-3">--}}
                                               {{--<h4>{{$product->name}}</h4>--}}
                                           {{--</div>--}}
                                       {{--</div>--}}
                                   {{--@endif--}}
                               {{--@endforeach--}}
                           {{--@endfor--}}
                       {{--</div>--}}
                   {{--</div>--}}
               {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<!-- /Page Content -->--}}
    {{--</div>--}}
{{--@endsection--}}
