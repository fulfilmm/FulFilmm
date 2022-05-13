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
                    <h3 class="page-title">Product Item</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Product Item</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('product.export')}}" class="btn btn-white rounded-pill mt-3 mr-1 shadow"><i class="la la-download"></i>Export</a>
                    <button type="button" class="btn btn-white rounded-pill mt-3 mr-1 shadow" data-toggle="modal" data-target="#import"><i class="la la-upload"></i>Import</button>
                    <a href="{{route("products.create")}}" class="btn btn-white float-right mr-3 mt-3 shadow rounded-pill" style="box-shadow: white"><i class="fa fa-plus mr-2"></i>Add Product</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <!-- Content Starts -->
        <div id="import" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div>
                                {{--@dd($route)--}}
                                <form action="{{route('product.import')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="start">File</label>
                                        <input type="file" class="form-control" id="file" name="import"  value="" required>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary">Import</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive card shadow">
                <div class="col-12 my-3">
                    <table class="table table-nowrap table-hover">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Item Code</th>
                            <th>Product Name</th>
                            <th>Product Code</th>
                            <th>Variation</th>
                            <th>Additional Price</th>
                            <th>Disable/Enable</th>
                            <th>Price Rule</th>
                            <th>Created Date</th>
                            <th style="min-width: 150px;">Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($variantions as $item)
                            <tr>
                                <td> <img src="{{url(asset('/product_picture/'.$item->image))}}" alt="picture" class="border-0 mr-2 ml-2"
                                          style="max-height:50px;max-width:50px;border: solid"></td>
                                <td><a href="{{route('show.variant',$item->id)}}">{{$item->item_code}}</a></td>
                                <td>{{$item->product->name}}</td>
                                <td><a href="{{route('products.show',$item->product_id)}}"><strong>{{$item->product->product_code}}</strong></a></td>
                                <td>{{$item->variant}}</td>
                                <td>{{$item->additional_price}}</td>
                                <td>{{$item->enable==0?'Disable':'Enable'}}</td>
                                <td>{{$item->pricing_type?'Multiple Price Rule':'Single Price Rule'}}</td>
                                <td>{{$item->created_at->toFormattedDateString()}}</td>
                                <td>
                                    <div class="row">
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit{{$item->id}}" title="Edit Item"><i class="la la-edit"></i></button>
                                        <a href="{{route('show.variant',$item->id)}}" class="btn btn-white btn-sm" title="Item details view"><i class="la la-eye"></i></a>
                                        <form action="{{route('barcode.generate')}}" method="get">
                                            @csrf
                                            <input type="hidden" name="product_name" value="{{$item->id}}">
                                            <button type="submit" class="btn btn-primary btn-sm" title="Barcode Generate"><i class="la la-barcode"></i></button>
                                        </form>
                                    </div>
                                    <div id="edit{{$item->id}}" class="modal custom-modal fade" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header border-bottom">
                                                    <h5 class="modal-title">Update Product Variant</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('variant.update',$item->id)}}" enctype="multipart/form-data" method="POST">
                                                        @csrf
                                                        <div class="row">
                                                            <input type="hidden" name="product_id" value="{{$item->product_id}}">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Item Code</label>
                                                                    <div class="input-group">
                                                                        <input type="text" id="p_code" name="item_code" class="form-control" value="{{$item->item_code}}"  required>
                                                                    </div>
                                                                    @error('product_code')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Variant</label>
                                                                    <input type="text" class="form-control" name="variant" value="{{$item->variant??$item->product_name}}" placeholder='Enter this format : "Color:Red Size:XL"'>
                                                                    @error('variant')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Images</label>
                                                                    <input type="file" name="picture" class="form-control" >
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Additional Price</label>
                                                                    <input type="text" name="additional_price" class="form-control" value="{{$item->additional_price}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 text-center">
                                                                <button type="submit" class="btn btn-primary">Add</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /Page Content -->

    <!-- /Page Wrapper -->
    <script>
        $(document).ready(function () {
            $('#product_table').DataTable();
        });


    </script>
@endsection
