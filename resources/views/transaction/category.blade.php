@extends("layout.mainlayout")
@section("title","Transaction Category")
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
                    <a href="#" class="btn add-btn"  data-toggle="modal" data-target="#add_cat" data-whatever="@getbootstrap"><i class="fa fa-plus"></i> Add Category</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        @include('transaction.add_category')
        <div class="card">
            <div class="card-header card-header-danger">
                <h4 class="text-dark"><i class="fa fa-list-alt mr-2"></i>Category</h4>
            </div>
            <div class="col-12" style="overflow-x: auto">
                <table class="table " id="category">
                    <thead>
                    <tr>
                        <th scope="col">Category Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($category as $cat)
                        <tr>
                            <td><i class="fa fa-bars mr-3"></i>{{$cat->name}}</td>
                            <td>{{$cat->type?'Revenue':'Expense'}}</td>
                            <td>
                                <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cat_update{{$cat->id}}" data-whatever="@getbootstrap"><i class="fa fa-edit"></i></a>
                                <a href="{{route('transaction_category.delete',$cat->id)}}" class="btn btn-danger btn-sm" ><i class="fa fa-trash text-white"></i></a>

                            </td>
                            @include('transaction.category_update')
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
