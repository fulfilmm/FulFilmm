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
        <form action="{{route("products.store")}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card shadow">
                {{--<div class="card-header"></div>--}}
                <div class="col-12 my-3">
                    <div class="row">
                        <div class="form-group col-md-6 col-12">
                            <label for="">Product Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-cube"></i></span>
                                </div>
                                <input type="text" class="form-control shadow-sm" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="">Product Code</label>
                                <div class="input-group">
                                    <input type="text" id="p_code" name="product_code" class="form-control" value="{{old('product_code')}}"  required>
                                    <button type="button" class="btn btn-white btn-sm" onclick="generatecode()" id="generate">Generate Product Code</button>
                                </div>
                                @error('product_code')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-12 ">
                            <label for="">Brand</label>
                            <div class="input-group">
                                <select name="brand_id" id="brand" class="form-control ">
                                    <option value="">None</option>
                                    @foreach($brand as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-12 ">
                            <label for="">Model No.</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                </div>
                                <input type="text" class="form-control shadow-sm" name="model_no" >
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
                                                <option value="{{$cat->id}}">{{$cat->name}}</option>
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
                                                <option value="{{$cat->id}}" data-option="{{$cat->parent_id}}">{{$cat->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    {{--<a href="" data-toggle="modal" data-target="#cat_add" class="btn btn-outline-dark"><i--}}
                                    {{--class="fa fa-plus"></i></a>--}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-12 ">
                            <label for="description">Detail</label>
                            <textarea name="detail" class="form-control shadow-sm" id="detail" ></textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Image</label>
                                <input type="file" name="picture" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="checkbox" name="has_variant" class="mr-2"><label for=""> This product has variant</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary text-center col-md-2 col-2 offset-md-5 my-3">Save</button>
            </div>

        </form>

    </div>

    @include('product.catadd')
    <!-- /Page Content -->
    <!-- /Page Wrapper -->
    <script>
        function generatecode(){
            var pcode='{{random_int(10000000,99999999)}}';
            $("#p_code").val(pcode);
        }
        $(document).ready(function () {
            $(document).on('change','#product_cat',function () {
                var cat_id = $('#product_cat option:selected').val();
                @foreach($category as $cat)
                if (cat_id == "{{$cat->parent_id}}"){
                    $("#sub_cat").html("<option value={{$cat->id}}>{{$cat->name}}<option>");
                }
                @endforeach
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
        var sel1 = document.querySelector('#main_cat');
        var sel2 = document.querySelector('#sub_cat');
        var options2 = sel2.querySelectorAll('option');

        function giveSelection(selValue) {
            sel2.innerHTML = '';
            for(var i = 0; i < options2.length; i++) {
                if(options2[i].dataset.option === selValue) {
                    sel2.appendChild(options2[i]);
                }
            }
        }

        giveSelection(sel1);
        $(document).ready(function () {
            $('select').select2();
        });

    </script>
@endsection
