@extends("layout.mainlayout")
@section('title','Product Edit')
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
        <form action="{{route("products.update",$product->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                {{--<div class="card-header"></div>--}}
                <div class="col-12 my-3">
                    <div class="row">
                        <div class="form-group col-md-6 col-12">
                            <label for="">Product Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-cube"></i></span>
                                </div>
                                <input type="text" class="form-control" name="name" value="{{$product->name}}" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-12 ">
                            <label for="">Brand</label>
                            <div class="input-group">
                                <select name="brand_id" id="brand" class="form-control ">
                                    <option value="">None</option>
                                    @foreach($brand as $item)
                                        <option value="{{$item->id}}" {{$item->id==$product->brand_id?'selected':''}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class=" col-md-6 col-12 " id="cat_div">
                            <div class="form-group">
                                <label for="">Main Category</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-list"></i></span>
                                    </div>
                                    <select name="mian_cat" id="mian_cat" class="form-control" onchange="giveSelection(this.value)" >
                                        <option value="">Select Category</option>
                                        @foreach($category as $cat)
                                            @if($cat->parent==1)
                                                <option value="{{$cat->id}}" {{$cat->id==$product->cat_id?'selected':''}}>{{$cat->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    {{--<a href="" data-toggle="modal" data-target="#cat_add" class="btn btn-outline-dark"><i--}}
                                    {{--class="fa fa-plus"></i></a>--}}
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-6 col-12 " id="cat_div">
                            <div class="form-group">
                                <label for="">Sub Category</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-list"></i></span>
                                    </div>
                                    <select name="sub_cat" id="sub_cat" class="form-control" >
                                        <option value="">Select Sub Category</option>
                                        @foreach($category as $cat)
                                            @if($cat->parent==0)
                                                <option value="{{$cat->id}}" data-option="{{$cat->parent_id}}" {{$cat->id==$product->sub_cat_id?'selected':''}}>{{$cat->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    {{--<a href="" data-toggle="modal" data-target="#cat_add" class="btn btn-outline-dark"><i--}}
                                    {{--class="fa fa-plus"></i></a>--}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-12 ">
                            <label for="">Model No.</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                </div>
                                <input type="text" class="form-control" name="model_no" value="{{$product->model_no}}" >
                            </div>
                        </div>

                        <div class="form-group col-md-12 col-12 ">
                            <label for="description">Detail</label>
                            <textarea name="detail" class="form-control" id="detail" >{{$product->description}}</textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Image</label>
                                <input type="file" name="picture" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary text-center col-md-2 col-2 offset-md-5 my-3">Update</button>
            </div>
        </form>
    </div>

    @include('product.catadd')
    <!-- /Page Content -->
    <!-- /Page Wrapper -->
    <script>
        $(document).ready(function () {
            $("#product_cat").change(function () {
                var val = $(this).val();
                {{--@php $val=document.write(val)' @endphp--}}
                $("#sub_cat").html("@foreach($category as $cat) @if($cat->parent_id==1)<option value='{{$cat->id}}'>{{$cat->name}}</option> @endif @endforeach");
            });
        });
        var loadFile = function (event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };

        function openSelect(file) {
            $(file).trigger('click');
        }

        $(document).ready(function () {

            $('select').select2({
                    "language": {},
                    escapeMarkup: function (markup) {
                        return markup;
                    }
                }
            );
        });

    </script>
@endsection
