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
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
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
                            <th><input type="checkbox" name="all" id="checkall"></th>
                            <th>Name</th>
                            <th>MainCategory</th>
                            <th>Sub Category</th>
                            <th>Branch</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--@dd($products)--}}
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    <input type="checkbox"  name="product[]" value="{{$product->id}}" class="single">
                                </td>
                                <td><a href="{{route("products.show",$product->id)}}">
                                        <span class="ml-3">{{$product->name}}</span></a></td>
                                <td>{{$product->category->name??''}}</td>
                                <td>
                                    {{$product->sub_cat->name??''}}
                                </td>
                                <td>{{$product->brand->name??'None'}}</td>
                                <td class="text-center">

                                    <a class="btn btn-white btn-sm" href="{{route("products.edit",$product->id)}}" ><i class="fa fa-pencil"></i> </a>
                                    <a class="btn btn-secondary btn-sm" href="{{url("product/duplicate/$product->id")}}" ><i class="fa fa-copy"></i> </a>
                                    <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#delete_product{{$product->id}}"><i class="fa fa-trash-o"></i> </a>

                                    <div class="modal fade" id="delete_product{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{route("products.destroy",$product->id)}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                <span>
                                                    Are you sure delete "{{$product->name}}"?
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
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    {!! $products->links() !!}
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="ml-2 col-md-4 col-8 float-left">
                            <div class="form-group">
                                <div class="input-group">
                                    <select class="form-control" name="action" id="action_type">
                                        <option value="Enable">Enable</option>
                                        <option value="Disable">Disable</option>
                                        <option value="Delete">Delete</option>
                                    </select>
                                    <div class="input-group-prepend">
                                        <button type="button" id="confirm" class="btn btn-primary rounded-right">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- /Page Content -->

    <!-- /Page Wrapper -->
    <script>
        $('#checkall').change(function () {
            $('.single').prop('checked',this.checked);
        });

        $('.single').change(function () {
            if ($('.single:checked').length == $('.single').length){
                $('#checkall').prop('checked',true);
            }
            else {
                $('#checkall').prop('checked',false);
                // $(".action").remove();
            }
        });
        $(document).ready(function () {
           $('#product_table').DataTable();
        });
        $(document).ready(function() {
            $('select').select2();
            $(document).on('click', '#confirm', function () {
                var product_id =new Array();
                $("input:checked").each(function () {
                    // console.log($(this).val()); //works fine
                    product_id.push($(this).val());
                });
                var action_type=$( "#action_type option:selected" ).val();
                // alert(action_type);
                $.ajax({
                    type:'POST',
                    data : {action_Type:action_type,product_id:product_id},
                    url:'/action/confirm',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(data){
                        console.log(data);
                        window.location.reload();
                    }
                });
            });
        });

    </script>
@endsection
