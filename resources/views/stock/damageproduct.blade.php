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
                    <h3 class="page-title">Damage Product</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Damage</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <!-- Content Starts -->

        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0 datatable">
                    <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Variant</th>
                        <th>Quantity</th>
                        <th>Issuer Employee</th>
                        <th>Warehouse</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($damage as $item)
                        <tr>
                            <td>{{$item->variant->product_name}}</td>
                            <td>{{$item->variant->variant}}</td>
                            <td>{{$item->qty}}</td>
                            <td>{{$item->emp->name}}</td>
                            <td>{{$item->warehouse->name}}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection