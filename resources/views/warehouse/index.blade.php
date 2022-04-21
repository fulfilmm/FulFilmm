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
                    <a href="#" class="btn add-btn btn-sm shadow-sm"  data-toggle="modal" data-target="#stock" data-whatever="@getbootstrap"><i class="fa fa-plus"></i> Add Warehouse</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        @include('warehouse.create')
        <div class="card shadow">
            <div class="card-header card-header-danger">
                <h4 class="text-dark"><i class="fa fa-home mr-2"></i>Warehouse</h4>
            </div>
            <div class="col-12 my-3" style="overflow-x: auto">
                <table class="table " id="case">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Address</th>
                        <th scope="col">Mobile Warehouse</th>
                        <th scope="col">Main Warehouse</th>
                        <th scope="col">Valuation</th>
                        <th scope="col">Branch</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($warehouses as $warehouse)
                        <tr>
                            <td style="min-width: 150px;">{{$warehouse->warehouse_id}}</td>
                            <td style="min-width: 150px;">{{$warehouse->name}}</td>
                            <td style="min-width: 150px;">{{$warehouse->description}}</td>
                            <td style="min-width: 150px;">{{$warehouse->address}}</td>
                            <td style="min-width: 150px;">{{$warehouse->mobile_warehouse?'Yes':'No'}}</td>
                            <td style="min-width: 150px;">{{$warehouse->main_warehouse->name??'N/A'}}</td>
                            <td style="min-width: 150px;">@foreach($warehouse_qty as $key=>$val)
                                    @if($key==$warehouse->id)
                                        {{$val}}
                                    @endif
                                    @endforeach
                            </td>
                            <td style="min-width: 150px;">{{$warehouse->branch->name??'N/A'}}</td>
                            <td style="min-width: 150px;">
                               <div class="row">
                                   <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#stock{{$warehouse->id}}" data-whatever="@getbootstrap"><i class="fa fa-edit"></i></a>
                                   <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$warehouse->id}}"><i class="fa fa-trash text-white"></i></a>
                                   <a href="{{route('warehouses.show',$warehouse->id)}}" class="btn btn-white btn-sm"><i class="fa fa-eye"></i></a>
                               </div>
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
