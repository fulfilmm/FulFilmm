@extends('layout.mainlayout')
@section('title',$start."-".$end.'Stock Report')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Stock Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock Report
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <form action="{{route('report.stock')}}" method="GET">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Warehouse</label>
                            <select name="warehouse_id" id="" class="form-control">
                                <option value="">All</option>
                                @foreach($warehouse as $key=>$val)
                                    <option value="{{$key}}" {{$key==$search_warehouse?'selected':''}}>{{$val}}</option>
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
            <div class="card shadow">

               <div class="col-12 my-3">
                   <table class="table table-hover table-nowrap" id="stock">
                       <thead>
                       <tr>
                           <th>Product Code</th>
                           <th>Product Name</th>
                           <th>Product Variant</th>
                           <th>Stock In</th>
                           <th>Stock Out</th>
                           <th>Stock Balance</th>
                       </tr>
                       </thead>
                       <tbody>
                       @foreach($items as $product)
                           <tr>
                               <td>{{$product->product_code}}</td>
                               <td>{{$product->product_name}}</td>
                               <td>{{$product->variant}}</td>
                               <td>{{$product->in}}</td>
                               <td>{{$product->out}}</td>
                               <td>{{$product->bal}}</td>
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
            $('#stock').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
        });
    </script>
    @endsection