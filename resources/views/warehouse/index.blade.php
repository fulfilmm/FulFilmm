@extends("layout.mainlayout")
@section("title","Warehouse")
@section("content")
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Warehouse</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Warehouse</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn"  data-toggle="modal" data-target="#stock" data-whatever="@getbootstrap"><i class="fa fa-plus"></i> Add Warehouse</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        @include('warehouse.create')
        <div class="card">
            <div class="card-header card-header-danger">
                <h4 class="text-dark"><i class="fa fa-home mr-2"></i>Warehouse</h4>
            </div>
            <div class="col-12" style="overflow-x: auto">
                <table class="table " id="case">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Stock Balance</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($warehouses as $warehouse)
                        <tr>
                            <td><i class="fa fa-home mr-3"></i>{{$warehouse->name}}
                            <td>{{$warehouse->description}}</td>
                            <td>@foreach($warehouse_qty as $key=>$val)
                                    @if($key==$warehouse->id)
                                        {{$val}}
                                    @endif
                                    @endforeach
                            </td>
                            <td>
                                <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#stock{{$warehouse->id}}" data-whatever="@getbootstrap"><i class="fa fa-edit"></i></a>
                                <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$warehouse->id}}"><i class="fa fa-trash text-white"></i></a>
                            </td>
                        </tr>
                        @include('warehouse.edit')
                        @include('warehouse.delete')
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
