@extends("layout.mainlayout")
@section('title','Product Details')
@section("content")
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Product Variant</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{url("/products")}}">Product</a></li>
                        <li class="breadcrumb-item active">Variant Add</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <form action="{{route('variant.store')}}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Product Name</label>
                            <select name="product_id" id="pid" class="form-control select2">
                                @foreach($product as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Serial No.</label>
                            <input type="text" class="form-control" name="serial_no" value="{{old('serial_no')}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Exp Date</label>
                            <input type="date" class="form-control" name="exp_date" value="{{\Carbon\Carbon::parse(old('exp_date'))->format('Y-m-d')}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Variant</label>
                            <input type="text" class="form-control" name="variant" value="{{old('variant')}}" placeholder='Enter this format : "Color:Red Size:XL"'>
                            @error('variant')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="supplier">Supplier(optional)</label>
                            <select name="supplier_id" id="supplier" class="form-control" style="width: 100%">
                                <option value="">None</option>
                                @foreach($supplier as $sup)
                                    <option value="{{$sup->id}}">{{$sup->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Images</label>
                            <input type="file" name="picture[]" class="form-control" multiple >
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea name="description" class="form-control" id="description" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function generatecode(){
            var pcode='{{random_int(100000000,999999999)}}';
            $("#p_code").val(pcode);
        }
        ClassicEditor.create($('#description')[0], {
            toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
        });
    </script>
    @endsection