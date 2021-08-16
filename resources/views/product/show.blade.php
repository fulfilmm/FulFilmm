@extends("layout.mainlayout")
@section('title','Product Details')
@section("content")
    <style>
        input[type="file"] {
            display: block;
        }
        .imageThumb {
            max-height: 90px;
            max-width: 150px;
            border: 2px solid;
            padding: 1px;
            cursor: pointer;
        }
        .pip {
            display: inline-block;
            margin: 10px 10px 10px 0;
        }
        .remove {
            display: block;
            background: #edeff2;
            border: 1px solid black;
            color: black;
            text-align: center;
            cursor: pointer;
        }
        .remove:hover {
            background: white;
            color: black;
        }
        #cke_11,#cke_19,#cke_21,#cke_26,#cke_27,#cke_28,#cke_29,#cke_30,#cke_32,#cke_47{
            visibility: hidden;
        }
    </style>
    <!-- Page Wrapper -->
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Product</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/home")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{url("/products")}}">Product</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class=" col-md-10 offset-md-1">
            <div class="row">
                <div class="col-md-5 card jumbotron">
                    <div class="text-center">
                        <img src="{{url(asset("/product_picture/$product->image"))}}" class="rounded "  height="200px;" alt="">
                    </div>
                </div>
                <div class="col-md-7">
                    <h4 class="mt-3 ml-3 text-uppercase">{{$product->name}}</h4>
                    <span class="ml-4"> <i class="fa fa-th"></i> {{$product->category->name}}</span>
                    <div class="row my-3 ml-5">
                        <div class="col-md-4 mt-4">Model Number</div>
                        <div class="col-md-8 mt-4">: {{$product->model_no}}</div>
                        <div class="col-md-4 mt-4">Available Stock</div>
                        <div class="col-md-8 mt-4">: {{$product->available_stock}}</div>

                        <div class="col-md-4 mt-4">Sale Price</div>
                        <div class="col-md-8 mt-4">: {{$product->sale_price}} {{$product->currency_unit}}</div>
                        <div class="col-md-4 mt-4">Purchased Price</div>
                        <div class="col-md-8 mt-4">: {{$product->purchase_price}} {{$product->currency_unit}}</div>
                        <span class="col-md-4 mt-4">Status</span>
                        <span class="col-md-8 mt-4">@if($product->enable==1)
                                : Enable
                            @else
                                : Disable
                            @endif
                            </span>
                    </div>
                </div>
            </div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Discription</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">More Information</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <h3>Production Description</h3>
                    <p>{{ $product->description}}</p>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <h3>Additional Information</h3>
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>Tax Type(Rate)</th>
                            <td>{{$product->taxes->name}}( {{$product->taxes->rate}} % )</td>
                        </tr>
                        <tr>
                            <th>SKU</th>
                            <td>{{$product->sku}}</td>
                        </tr>
                        <tr>
                            <th>Serial Number</th>
                            <td>{{$product->serial_no}}</td>
                        </tr>
                        <tr>
                            <th>Part Number</th>
                            <td>{{$product->part_no}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
    <!-- /Page Wrapper -->
@endsection
