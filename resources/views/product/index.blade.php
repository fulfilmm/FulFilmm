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
                    <h3 class="page-title">Product</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Product</li>
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
                    <table class="table table-striped custom-table mb-0 table-hover" id="product_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Product Code</th>
                            <th>Name</th>
                            <th>MainCategory</th>
                            <th>Sub Category</th>
                            <th>Brand</th>
                            <th>Add Variant</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--@dd($products)--}}
                        @foreach($products as $product)
                            <tr>
                                {{--<td><button id="collapse{{$product->id}}" class="btn btn-purple btn-sm rounded-circle" type="button" data-toggle="collapse" data-target="#variant{{$product->id}}" style="font-size: 10px;" ><i class="fa fa-plus" id="{{$product->id}}"></i></button>--}}
                                {{--</td>--}}
                                <td>

                                    <img src="{{url(asset('/product_picture/'.$product->image))}}" alt="" class="border mr-2 ml-2"
                                         style="max-height:50px;max-width:50px;border: solid">
                                </td>
                                <th>{{$product->product_code}}</th>
                                <td>
                                    <a href="{{route("products.show",$product->id)}}">
                                        <span class="ml-3">{{$product->name}}</span></a>
                                </td>
                                <td>{{$product->category->name??''}}</td>
                                <td>
                                    {{$product->sub_cat->name??''}}
                                </td>
                                <td>{{$product->brand->name??'None'}}</td>
                                <td><a href="{{route('create.variant',$product->id)}}" class="btn btn-outline-info btn-sm">Add Variant</a></td>
                                <td class="text-center">
                                    <a href="{{route("products.show",$product->id)}}" class="btn btn-warning btn-sm" title="Product detail view"><i class="la la-eye"></i></a>
                                    <a class="btn btn-white btn-sm" href="{{route("products.edit",$product->id)}}" title="Product Edit"><i class="fa fa-pencil"></i> </a>
                                    <a class="btn btn-secondary btn-sm" href="{{url("product/duplicate/$product->id")}}" title="Product Duplicate"><i class="fa fa-copy"></i> </a>
                                    {{--<a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#delete_product{{$product->id}}"><i class="fa fa-trash-o"></i> </a>--}}

                                    {{--<div class="modal fade" id="delete_product{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
                                        {{--<div class="modal-dialog" role="document">--}}
                                            {{--<div class="modal-content">--}}
                                                {{--<div class="modal-header">--}}
                                                    {{--<h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>--}}
                                                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                                                        {{--<span aria-hidden="true">&times;</span>--}}
                                                    {{--</button>--}}
                                                {{--</div>--}}
                                                {{--<form action="{{route("products.destroy",$product->id)}}" method="POST">--}}
                                                    {{--@csrf--}}
                                                    {{--@method('DELETE')--}}
                                                    {{--<div class="modal-body">--}}
                                                        {{--<div class="text-center">--}}
                                                {{--<span>--}}
                                                    {{--Are you sure delete "{{$product->name}}"?--}}
                                              {{--</span>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="text-center">--}}
                                                        {{--<button class="btn btn-outline-primary">Cancel</button>--}}
                                                        {{--<button type="submit" class="btn btn-danger  my-2">Delete</button>--}}
                                                    {{--</div>--}}
                                                {{--</form>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                </td>
                            </tr>
                            <tr id="variant{{$product->id}}" class="collapse multi-collapse">
                                <td colspan="5">
                                    <div>
                                        <div class="col-12">
                                            <span class="my-2">{{$product->name}}'s Variants</span>
                                            <hr>
                                            <div class="row mb-2">
                                                <div class="col-md-3"><strong>Product Code</strong></div>
                                                    <div class="col-md-3"><strong>Variant</strong></div>
                                                    <div class="col-md-3"><strong>Disable/Enable</strong></div>
                                                    <div class="col-md-3"><strong>Action</strong></div>
                                            </div>
                                                <hr>
                                           @foreach($variants as $item)
                                                @if($item->product_id==$product->id)
                                                    <div class="row">
                                                        <div class="col-md-3">{{$item->item_code}}</div>
                                                        <div class="col-md-3">{{$item->variant}}</div>
                                                        <div class="col-md-3">{{$item->enable==0?'Disable':'Enable'}}</div>
                                                        <div class="col-md-3"><a href="{{route('show.variant',$item->id)}}" class="btn btn-white btn-sm"><i class="la la-eye"></i></a></div>
                                                    </div>
                                                    @endif
                                               @endforeach
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            <script>
                                $("#collapse{{$product->id}}").click(function () {
                                    $("#{{$product->id}}").toggleClass("fa-minus");
                                });
                            </script>
                        @endforeach

                        </tbody>
                    </table>
                    {!! $products->links() !!}
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
