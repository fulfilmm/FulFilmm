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
            </div>
        </div>
        <!-- /Page Header -->
        <!-- Content Starts -->

        <div class="col-md-12">
            <div class="table-responsive">
                <div class="bg-gradient-blue">
                    <a href="{{route("products.create")}}" class="btn btn-white float-right mr-3 mt-3 border-dark" style="box-shadow: white"><i class="fa fa-plus"></i></a>
                    <div class="row">
                        <div class="form-group offset-md-1 my-3 col-md-4">
                            <select class="select" name="action" id="action_type">
                                <option value="Enable">Enable</option>
                                <option value="Disable">Disable</option>
                                <option value="Delete">Delete</option>
                            </select>
                        </div>
                        <div class="form-group my-3 col-md-2">
                            <button type="button" id="confirm" class="btn btn-primary">Confirm</button>
                        </div>
                    </div>
                </div>
                <table class="table table-striped custom-table mb-0 datatable">
                    <thead>
                    <tr>
                        <th><input type="checkbox" name="all" id="checkall"></th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Sale Price</th>
                        <th>Purchase Price</th>
                        <th>Enabled</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <input type="checkbox" name="product[]" value="{{$product->id}}" class="single">
                            </td>
                            <td><a href="{{route("products.show",$product->id)}}">
                                    <img src="{{url(asset("/product_picture/$product->image"))}}" class="border rounded" alt="product picture" width="40px" height="40px;">
                                    <span class="ml-3">{{$product->name}}</span></a></td>
                            <td>{{$product->category->name}}</td>
                            <td>
                                {{$product->sale_price}} {{$product->currency_unit}}
                            </td>
                            <td>{{$product->purchase_price}} {{$product->currency_unit}}</td>
                            <td>@if($product->enable==1)
                                    Enable
                                @else
                                    Disable
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{route("products.edit",$product->id)}}" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="{{url("product/duplicate/$product->id")}}" ><i class="fa fa-copy m-r-5"></i> Duplicate</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_product{{$product->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                    </div>
                                </div>
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
        $(document).ready(function() {
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
