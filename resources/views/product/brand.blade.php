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
                    <h3 class="page-title">Product Brand</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Brand</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn btn-white float-right mr-3 shadow rounded-pill" data-toggle="modal" data-target="#createBrand" style="box-shadow: white"><i class="fa fa-plus mr-2"></i>Add Brand</a>
                    <button type="button" class="btn btn-outline-primary  rounded-pill mr-1" data-toggle="modal" data-target="#import"><i class="la la-upload"></i>Import</button>
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
                                            <form action="{{route('brand.import')}}" method="POST" enctype="multipart/form-data">
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
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <!-- Content Starts -->

        <div class="col-md-12">
            <div class="table-responsive card shadow">
                <div class="col-12 my-3">
                    <table class="table table-striped custom-table mb-0 table-hover" id="product_table">
                        <thead>
                        <tr>
                            <th>Brand Logo</th>
                            <th>Brand Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--@dd($products)--}}
                        @foreach($brand as $item)
                            <tr>
                               <td>
                                   <img src="{{url(asset('/product_picture/'.$item->brand_logo))}}" alt="" style="max-height: 40px; max-width: 80px">
                               </td>
                                <td>
                                    {{$item->name}}
                                </td>
                                <td>

                                    <a class="btn btn-white btn-sm" href="#" data-toggle="modal" data-target="#edit{{$item->id}}" ><i class="fa fa-pencil"></i> </a>
                                    <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#delete_product{{$item->id}}"><i class="fa fa-trash-o"></i> </a>
                                    <div class="modal fade" id="delete_product{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Brand</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{route("product_brand.destroy",$item->id)}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                <span>
                                                    Are you sure delete "{{$item->name}}"?
                                              </span>
                                                        </div>
                                                    </div>
                                                    <div class="text-center">
                                                        <button class="btn btn-outline-primary">Cancel</button>
                                                        <button type="submit" class="btn btn-danger  my-2">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="edit{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Product Brand</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{route("product_brand.update",$item->id)}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="name">Brand Name</label>
                                                                <input type="text" name="name" class="form-control shadow-sm" value="{{$item->name}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="name">Brand Logo</label>
                                                                <input type="file" name="brand_logo" class="form-control shadow-sm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center">
                                                        <button class="btn btn-outline-primary">Cancel</button>
                                                        <button type="submit" class="btn btn-danger  my-2">Update</button>
                                                    </div>
                                                </form>
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
        <div class="modal fade" id="createBrand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Product Brand</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('product_brand.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Brand Name</label>
                                    <input type="text" name="name" class="form-control shadow-sm">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Brand Logo</label>
                                    <input type="file" name="brand_logo" class="form-control shadow-sm">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-outline-primary">Cancel</button>
                            <button type="submit" class="btn btn-danger  my-2">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
