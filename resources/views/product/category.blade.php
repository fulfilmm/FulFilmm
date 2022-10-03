@extends("layout.mainlayout")
@section("title","Product Category")
@section("content")
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Category</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Category</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn"  data-toggle="modal" data-target="#cat_add" data-whatever="@getbootstrap"><i class="fa fa-plus"></i> Add Category</a>
                        <button type="button" class="btn btn-outline-primary rounded-pill mr-1" data-toggle="modal" data-target="#import"><i class="la la-upload"></i>Import</button>
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
                                                <form action="{{route('category.import')}}" method="POST" enctype="multipart/form-data">
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

        @include('product.catadd')
        <div class="card">
            <div class="card-header card-header-danger">
                <h4 class="text-dark"><i class="fa fa-list-alt mr-2"></i>Category</h4>
            </div>
            <div class="col-12" style="overflow-x: auto">
                <table class="table " id="category">
                    <thead>
                    <tr>
                        <th scope="col">Category Name</th>
                        <th scope="col">Category Type</th>
                        <th scope="col">Parent Category</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--@dd($category)--}}
                    @foreach($category as $cat)
                        <tr>
                            <td><img src="{{url(asset('/product_picture/'.$cat->image))}}" alt="" width="30px" height="30px" class="mr-3">{{$cat->name}}</td>
                            <td>{{$cat->parent==1?'Main Category':'Sub Category'}}</td>
                            <td>{{$cat->main->name ??'N/A'}}</td>
                            <td>
                                <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cat_update{{$cat->id}}" data-whatever="@getbootstrap"><i class="fa fa-edit"></i></a>
                                <a href="{{route('category.delete',$cat->id)}}" class="btn btn-danger btn-sm" ><i class="fa fa-trash text-white"></i></a>

                            </td>
                            @include('product.category_update')
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function (){
            $("#case").DataTable();
        });
    </script>
@endsection
