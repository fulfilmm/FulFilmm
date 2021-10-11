@extends("layout.mainlayout")
@section("title","Cases Type")
@section("content")
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Taxes</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tax</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn"  data-toggle="modal" data-target="#add" data-whatever="@getbootstrap"><i class="fa fa-plus"></i> Add Tax</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        @include('product.taxadd')
        <div class="card">
            <div class="card-header card-header-danger">
                <h4 class="text-dark"><i class="fa fa-list-alt mr-2"></i>Tax</h4>
            </div>
            <div class="col-12" style="overflow-x: auto">
                <table class="table " id="tax">
                    <thead>
                    <tr>
                        <th scope="col">Tax Name</th>
                        <th scope="col">Rate</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($taxes as $tax)
                        <tr>
                            <td><i class="fa fa-bars mr-3"></i>{{$tax->name}}</td>
                            <td>{{$tax->rate}} %</td>
                            <td>
                                <a href="{{route('taxes.delete',$tax->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                            </td>
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
