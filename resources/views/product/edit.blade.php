@extends("layout.mainlayout")
@section("title","Product Edit")
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
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Product</li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <form action="{{route("products.update",$product->id)}}" method="POST" enctype="multipart/form-data" autocomplete="off">
            {{csrf_field()}}
            @method('PUT')
            <div class="row">
                <div class="form-group col-md-4 col-6 offset-md-2">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" value="{{$product->name}}" required>
                </div>
                <div class=" col-md-4 col-12 " id="tax_div">
                    <div class="form-group">
                        <label for="">Tax</label>
                        <div class="row ">
                            <div class="col-md-10 col-10">
                                <select name="tax" id="product_tax" class="form-control">
                                    @foreach($taxes as $tax)
                                        @if($tax->id == $product->tax)
                                            <option value="{{$tax->id}}" selected >{{$tax->name}}({{$tax->rate}}%)</option>
                                        @else
                                            <option value="{{$tax->id}}">{{$tax->name}}({{$tax->rate}}%)</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-2">
                                <a href="" data-toggle="modal" data-target="#add" class="btn btn-outline-dark"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-4 col-12 offset-md-2">
                    <label for="">Model No.</label>
                    <input type="text" class="form-control" name="model_no" value="{{$product->model_no}}">
                </div>
                <div class="form-group col-md-4 col-12 ">
                    <label for="">Serial No.</label>
                    <input type="text" class="form-control" name="serial_no" value="{{$product->serial_no}}">
                </div>
                <div class="form-group col-md-8 col-12 offset-md-2">
                    <label for="">Description</label>
                    <textarea name="description" cols="50" style="width: 100%;height: 100px;" >{{$product->description}}</textarea>
                </div>
                <div class="form-group col-md-3 col-12 offset-md-2">
                    <label for="">Sale Price</label>
                    <input type="number" class="form-control " value="{{$product->sale_price}}" min="0" name="sale_price" oninput="validity.valid||(value='');" required>
                </div>
                <div class="form-group col-md-3 col-12">
                    <label for="">Purchase Price</label>
                    <input type="number" class="form-control " value="{{$product->purchase_price}}" min="0" name="purchase_price" oninput="validity.valid||(value='');" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="">Unit</label>
                    <select name="unit" id="" class="select">
                        @if($product->currency_unit=="MMK")
                            <option value="MMK" selected>MMK</option>
                            <option value="USD">USD</option>
                        @else
                            <option value="MMK" >MMK</option>
                            <option value="USD" selected>USD</option>
                        @endif
                    </select>
                </div>
                <div class=" col-md-3 col-12 offset-md-2" id="cat_div">
                    <div class="form-group">
                        <label for="">Category</label>
                        <div class="row">
                            <div class="col-md-10 col-8">
                                <select name="cat_id" id="product_cat" class="form-control" required>
                                    @foreach($allcat as $cat)
                                        @if($cat->id==$product->cat_id)
                                            <option value="{{$cat->id}}" selected>{{$cat->name}}</option>
                                        @else
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-2">
                                <a href="" data-toggle="modal" data-target="#cat_add" class="btn btn-outline-dark"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-3 col-6">
                    <label for="">Picture</label>
                    <input type="file" accept="image/*" name="picture"  class=" offset-md-1" onchange="loadFile(event)">
                </div>
                <div class="form-group col-md-2">
                    <img id="output" class="rounded mt-3" src="{{url(asset("/product_picture/$product->image"))}}" width="100px" height="100px;">
                </div>
                <div class="form-group offset-md-2">
                    @if($product->enable==1)
                        <input type="checkbox" checked name="enable" class="ml-3">
                    @else
                        <input type="checkbox" name="enable" class="ml-3">
                    @endif

                    <label for="">Enable</label>
                </div>

            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary col-md-2 col-2 ">Update</button>
            </div>
        </form>
    </div>
    <div id="add" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Tax</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6 col-6">
                            <label>Tax Name</label>
                            <input type="text" id="p_tax" class="form-control" name="tax" >
                        </div>
                        <div class="form-group col-md-6 col-6">
                            <label>Tax Rate</label>
                            <input type="number" id="rate" class="form-control" name="rate" placeholder="%" >
                        </div>
                    </div>
                    <button  id="tax_create" data-dismiss="modal" class="btn btn-primary float-right">Add</button>
                </div>
            </div>
        </div>
    </div>
    <div id="cat_add" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group ">
                        <label>Category Name</label>
                        <input type="text" id="cat_name" class="form-control" name="cat_name" >
                    </div>
                    <button  id="cat_create" data-dismiss="modal" class="btn btn-primary float-right">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
    <!-- /Page Wrapper -->
    <script>
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };

        $(document).ready(function(){ //Make script DOM ready
            $('#product_tax').change(function() { //jQuery Change Function
                var opval = $(this).val(); //Get value from select element
                if(opval=="tax"){ //Compare it and if true
                    $('#add').modal("show"); //Open Modal
                }
            });
        });
        $(document).ready(function() {
            $(document).on('click', '#tax_create', function () {
                var name=$("#p_tax").val();
                var rate=$("#rate").val();
                $.ajax({
                    type:'POST',
                    data : {name:name,p_rate:rate},
                    url:'/tax/create',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(data){
                        console.log(data);
                        $("#tax_div").load(location.href + " #tax_div>* ");
                    }
                });
            });
        });

        $(document).ready(function(){ //Make script DOM ready
            $('#product_cat').change(function() { //jQuery Change Function
                var opval = $(this).val(); //Get value from select element
                if(opval=="cat"){ //Compare it and if true
                    $('#cat_add').modal("show"); //Open Modal
                }
            });
        });
        $(document).ready(function() {
            $(document).on('click', '#cat_create', function () {
                var name=$("#cat_name").val();
                $.ajax({
                    type:'POST',
                    data : {name:name},
                    url:'/cat/create',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(data){
                        console.log(data);
                        $("#cat_div").load(location.href + " #cat_div>* ");
                    }
                });
            });
        });

    </script>
@endsection