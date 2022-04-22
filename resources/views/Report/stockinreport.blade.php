@extends('layout.mainlayout')
@section('title','Sale Report')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="card shadow">
            <div class="col-12 my-3">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="float-right"><a href="{{url('reports')}}" class="btn btn-danger btn-sm rounded-circle"><i class="la la-close"></i></a></div>
                            <h3 class="page-title">Stock In Report</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>

                                <li class="breadcrumb-item active"><a href="{{url('reports')}}">Report</a></li>
                                <li class="breadcrumb-item active">Stock In Report</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12" style="overflow: auto">
                    <form action="{{route('report.stockin')}}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Warehouse</label>
                                    <select name="warehouse_id" id="" class="form-control">
                                        <option value="">All</option>
                                        @foreach($warehouse as $item)
                                            <option value="{{$item->id}}" {{$item->id==$search_warehouse?'selected':''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Start Date</label>
                                    <input type="date" class="form-control shadow-sm" name="start" value="{{$start->format('Y-m-d')}}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">End Date</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control shadow-sm" name="end" value="{{$end->format('Y-m-d')}}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-white shadow-sm"><i class="la la-search"></i></button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                    <table class="table table-hover table-nowrap" id="stockin">
                        <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Product Variant</th>
                                <th>Quantity</th>
                                <th>Supplier</th>
                                <th>Stock In Date</th>
                                <th>Stock Controller Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stockin as $item)
                                <tr>
                                    <td>{{$item->variant->product_code}}</td>
                                    <td>{{$item->variant->product_name}}</td>
                                    <td>{{$item->variant->variant}}</td>
                                    <td>{{$item->qty}}</td>
                                    <td>{{$item->supplier->name}}</td>
                                    <td>{{$item->created_at->toFormattedDateString()}}</td>
                                    <td>{{$item->employee->name}}</td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#stockin').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
        });
    </script>
@endsection