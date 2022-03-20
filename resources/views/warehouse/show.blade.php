@extends('layout.mainlayout')
@section('title',$warehouse->name)
@section('content')
    <div class="container-fluid">
        <div class="page-header my-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">{{$warehouse->name}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{$warehouse->name}}</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a  data-toggle="modal" data-target="#export" class="btn btn-outline-info rounded-pill btn-sm mr-1"><i class="fa fa-download mr-1"></i>Export</a>
                    <div id="export" class="modal custom-modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Export</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row justify-content-center">
                                        <div>
                                            {{--@dd($route)--}}
                                            <form action="{{route('stock.export')}}" method="GET">
                                                @csrf
                                                <input type="hidden" name="warehouse_id" value="{{$warehouse->id}}">
                                                <div class="form-group">
                                                    <label for="start">Start Date</label>
                                                    <input type="text" class="form-control" id="start" name="start_date"  value="" title="Start Date" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="end">End Date</label>
                                                    <input type="text" class="form-control" id="end" name="end_date"  value="" title="End Date" required>
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-primary">Export</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{route('show.transfer')}}" class="btn add-btn btn-sm"><i class="fa fa-plus"></i>Stock Transfer</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="table-responsive my-3 col-12">
                <table class="table " id="stock">
                    <thead>
                    <tr>
                        <th>Product Code</th>
                        <th>Product </th>
                        <th>Variants</th>
                        <th>Warehouse</th>
                        <th>Stock Balance</th>
                        <th>Available Stock</th>
                        <th>Last Updated</th>
                    </tr>

                    </thead>
                    <tbody>
                    {{--@dd($stocks)--}}
                    @foreach($stocks as $stock)
                        <tr>
                            <td><a href="{{route('show.variant',$stock->variant->id)}}">{{$stock->variant->product_code}}</a></td>
                            <td><a href="{{route('products.show',$stock->variant->product_id)}}">{{$stock->product_name}}</a></td>
                            <td>{{$stock->variant->variant??''}}</td>
                            <td>{{$stock->warehouse->name}}</td>
                            <td>{{$stock->stock_balance}}</td>
                            <td>{{$stock->available}}</td>
                            <td>{{\Carbon\Carbon::parse($stock->updated_at)->toFormattedDateString()}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{--<script src="{{url(asset('js/jquery_print.js'))}}"></script>--}}
    {{--<script src="{{url(asset('js/datatable_button.js'))}}"></script>--}}
    <script>
        jQuery(document).ready(function () {
            'use strict';

            jQuery('#start').datetimepicker();
            jQuery('#end').datetimepicker();
        });
        $(document).ready(function () {
            $('#stock').DataTable();
            $('.dataTables_filter input').remove('form-control');
            $('.dataTables_filter input').addClass('rounded');
        });
    </script>

@endsection