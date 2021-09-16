@extends("layout.mainlayout")
@section('title','Product Create')
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
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <form action="{{route("products.store")}}" method="POST" enctype="multipart/form-data" autocomplete="off">
            {{csrf_field()}}

            <div class="text-center">
                <div class="form-group col-md-4 offset-md-4">
                    <img id="output" class="rounded mt-3" src="{{url(asset("/img/profiles/avatar-01.jpg"))}}" width="200px" height="200px;">
                </div>
                <div class="form-group col-md-3 col-6 offset-md-5">
                    <label for="">Picture</label>
                    <input type="file" accept="image/*" name="picture"  class=" offset-md-1" onchange="loadFile(event)" >
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6 col-12">
                    <label for="">Product Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="col-md-6 col-12" id="tax_div">
                    <div class="form-group">
                        <label for="">Tax</label>
                        <div class="row">
                            <div class="col-md-10 col-10">
                                <select name="tax" id="product_tax" class="form-control" required>
                                    @foreach($taxes as $tax)
                                        @if($tax->id == $lasttax->id)
                                            <option value="{{$tax->id}}" selected >{{$tax->name}}({{$tax->rate}}%)</option>
                                        @else
                                            <option value="{{$tax->id}}">{{$tax->name}}({{$tax->rate}}%)</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-2">
                                <div class="form-group">
                                        <a href="" data-toggle="modal" data-target="#add" class="btn btn-outline-dark"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="form-group col-md-6 col-12 ">
                    <label for="">Model No.</label>
                    <input type="text" class="form-control" name="model_no" required>
                </div>
                <div class="form-group col-md-6 col-12 ">
                    <label for="">Serial No.</label>
                    <input type="text" class="form-control" name="serial_no" required>
                </div>
                <div class="form-group col-md-12 col-12 ">
                    <label for="">Description</label>
                    <textarea name="description" cols="50" style="width: 100%;height: 100px;"  required></textarea>
                </div>
                <div class="form-group col-md-4 col-12 ">
                    <label for="">SKU</label>
                    <input type="text" class="form-control" name="sku" required>
                </div>
                <div class="form-group col-md-4 col-12">
                    <label for="">Part No.</label>
                    <input type="text" class="form-control" name="part_no" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="">Available Stock</label>
                    <input type="number" class="form-control" name="aval_stock" value="0" required>
                </div>
                <div class="form-group col-md-4 col-12 ">
                    <label for="">Sale Price</label>
                    <input type="number" class="form-control " min="0" name="sale_price" oninput="validity.valid||(value='');" required>
                </div>
                <div class="form-group col-md-4 col-12">
                    <label for="">Purchase Price</label>
                    <input type="number" class="form-control " min="0" name="purchase_price" oninput="validity.valid||(value='');" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="">Unit</label>
                    <select name="unit" id="" class="select">
                        <option value="MMK">MMK</option>
                        <option value="USD">USD</option>
                    </select>
                </div>
                <div class=" col-md-4 col-12 " id="cat_div">
                    <div class="form-group">
                        <label for="">Category</label>
                        <div class="row">
                            <div class="col-md-10 col-xl-10 col-sm-8 col-9">
                                <select name="cat_id" id="product_cat" class="form-control" required>
                                    @foreach($allcat as $cat)
                                        @if($cat->id==$lastcat->id)
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
                <div class="form-group ">
                    <input type="checkbox" name="enable" class="ml-3 mt-5">
                    <label for="">Enable</label>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary col-md-2 col-2 ">Save</button>
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
                        <div class="form-group">
                            <label>Tax Name</label>
                            <input type="text" id="p_tax" class="form-control" name="tax" >
                        </div>
                    <label>Tax Rate</label>
                        <div class="input-group">

                            <input type="number" id="rate" class="form-control" name="rate">
                            <button type="button" class="btn btn-white">%</button>
                        </div>
                    </div>
                <div class="form-group text-center">
                    <button  id="tax_create" data-dismiss="modal" class="btn btn-primary">Add</button>
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
                    <button   id="cat_create" data-dismiss="modal" class="btn btn-primary float-right">Add</button>
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
        $(document).ready(function() {
            $('#product_tax').select2({
                    "language": {
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    }
                }

            );
            $('#product_cat').select2({
                    "language": {
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    }
                }

            );

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
