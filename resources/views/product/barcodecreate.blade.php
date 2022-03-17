@extends("layout.mainlayout")
@section("title","Products")
@section("content")
    <!-- Page Wrapper -->
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Product Barcode</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Product Barcode</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12 offset-md-4 offset-md-3 offset-0">
            <div class="card shadow">
                <div class="card-header">
                    Product Barcode Generate
                </div>
                <form action="{{route('barcode.generate')}}" method="get">
                    @csrf
                    <div class="col-12 my-2">
                        <div class="form-group">
                            <label for="product">Product Name</label>
                            <select name="product_name" id="product" class="form-control">
                                <option value="">Select Product</option>
                                @foreach($products as $item)
                                    <option value="{{$item->id}}">{{$item->product_name}}({{$item->variant}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 my-2">
                        <div class="form-group">
                            <label for="type">Barcode Type</label>
                            <select name="btype" id="type" class="form-control">
                                <option value="">Select Barcode Type</option>
                                @foreach($type as $key=>$val)
                                    <option value="{{$val}}">{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 my-2">
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Page Header -->
        <!-- Content Starts -->
    </div>
    <script>
        $(document).ready(function () {
            $('select').select2();
        });
    </script>
    @endsection
