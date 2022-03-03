@extends('layout.mainlayout')
@section('title','Stock')

@section('content')
    <div class="container-fluid">
        {{--<div class="page-header my-3">--}}
        {{--<div class="col-12">--}}
        {{--<div class="row bg-white">--}}
        {{--<div class="col-sm-6 my-3">--}}
        {{--<ul class="breadcrumb">--}}
        {{--<li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>--}}
        {{--<li class="breadcrumb-item active">Stock</li>--}}
        {{--</ul>--}}
        {{--</div>--}}
        {{--<div class="col-auto float-right ml-auto my-3">--}}
        {{--<a  data-toggle="modal" data-target="#export" class="btn btn-outline-info rounded btn-sm mr-1"><i class="fa fa-download mr-1"></i>Export</a>--}}
        {{--<div id="export" class="modal custom-modal fade" role="dialog">--}}
        {{--<div class="modal-dialog modal-dialog-centered modal-sm" role="document">--}}
        {{--<div class="modal-content">--}}
        {{--<div class="modal-header">--}}
        {{--<h5 class="modal-title">Export</h5>--}}
        {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
        {{--<span aria-hidden="true">&times;</span>--}}
        {{--</button>--}}
        {{--</div>--}}
        {{--<div class="modal-body">--}}
        {{--<div class="row justify-content-center">--}}
        {{--<div>--}}
        {{--@dd($route)--}}
        {{--<form action="{{route('stock.export')}}" method="GET">--}}
        {{--@csrf--}}
        {{--<div class="form-group">--}}
        {{--<label for="start">Start Date</label>--}}
        {{--<input type="text" class="form-control" id="start" name="start_date"  value="" title="Start Date" required>--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
        {{--<label for="end">End Date</label>--}}
        {{--<input type="text" class="form-control" id="end" name="end_date"  value="" title="End Date" required>--}}
        {{--</div>--}}
        {{--<div class="d-flex justify-content-center">--}}
        {{--<button type="submit" class="btn btn-primary">Export</button>--}}
        {{--</div>--}}
        {{--</form>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<a href="{{route('show.transfer')}}" class="btn btn-white btn-sm"><i class="la la-exchange mr-2 mt-1"></i>Stock Transfer</a>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        <div class="page-header my-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Stock</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill mr-1" data-toggle="modal" data-target="#import"><i class="la la-upload"></i>Import</button>
                    <a data-toggle="modal" data-target="#export"
                       class="btn btn-outline-info rounded-pill btn-sm mr-1"><i
                                class="fa fa-download mr-1"></i>Export</a>
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
                                                <div class="form-group">
                                                    <label for="start">Start Date</label>
                                                    <input type="text" class="form-control" id="start" name="start_date"
                                                           value="" title="Start Date" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="end">End Date</label>
                                                    <input type="text" class="form-control" id="end" name="end_date"
                                                           value="" title="End Date" required>
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit"  class="btn btn-primary">Export</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{route('show.transfer')}}" class="btn add-btn btn-sm"><i class="fa fa-plus"></i>Stock
                        Transfer</a>
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
                                            <form action="{{route('stocks.import')}}" method="POST" enctype="multipart/form-data">
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
        <div class="card">
            <div class="table-responsive my-3 col-12" style="overflow: auto">
                <table class="table table-striped custom-table" id="stock">
                    <thead>
                    <tr>
                        <th style="min-width: 130px">Product Code</th>
                        <th style="min-width: 100px">Product</th>
                        <th style="min-width: 100px">Variants</th>
                        <th style="min-width: 100px">Warehouse</th>
                        <th style="min-width: 100px">Unit</th>
                        <td style="min-width: 100px">Balance</td>
                        <td style="min-width: 100px">Available</td>
                        <td style="min-width: 100px">Alert Qty</td>
                        <td style="min-width: 100px">Last Updated</td>
                        <td style="min-width: 100px">Action</td>
                    </tr>

                    </thead>
                    <tbody>
                    {{--@dd($stocks)--}}
                    @foreach($stocks as $stock)
                        <tr>
                            <td style="min-width: 100px">
                                <a href="{{route('show.variant',$stock->variant->id)}}">{{$stock->variant->product_code}}</a>
                            </td>
                            <td>
                                <a href="{{route('products.show',$stock->variant->product_id)}}">{{$stock->product_name}}</a>
                            </td>
                            <td>
                                <a href="{{route('show.variant',$stock->variant->id)}}">{{$stock->variant->variant??''}}</a>
                            </td>
                            <td>
                                <a href="{{route('warehouses.show',$stock->warehouse->id)}}">{{$stock->warehouse->name}}</a>
                            </td>
                            <td style="min-width: 100px;">
                                <select name="" id="unit{{$stock->id}}" class="form-control select">
                                    @foreach($units as $unit)
                                        @if($unit->product_id==$stock->variant->product_id)
                                            <option value="{{$unit->unit_convert_rate}}" {{$unit->unit_convert_rate==1?'selected':''}}>{{$unit->unit}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td><span id="stock_balance{{$stock->id}}"></span></td>
                            <td><span id="stock_avl{{$stock->id}}"></span>
                                <script>
                                    $(document).ready(function () {
                                        var stock_bal = '{{$stock->stock_balance}}';
                                        var stock_val = '{{$stock->available}}';
                                        $('#stock_balance{{$stock->id}}').text(stock_bal);
                                        $('#stock_avl{{$stock->id}}').text(stock_val);
                                        $('#unit{{$stock->id}}').change(function () {
                                            var unit = $(this).val();
                                            var st_bal = Math.round(parseFloat(stock_bal) / parseInt(unit));
                                            var st_val = Math.round(parseFloat(stock_val) / parseInt(unit));
                                            $('#stock_balance{{$stock->id}}').text(st_bal);
                                            $('#stock_avl{{$stock->id}}').text(st_val);

                                        });
                                    });
                                </script>
                            </td>
                            <td>{{$stock->alert_qty}}</td>
                            <td>{{\Carbon\Carbon::parse($stock->updated_at)->toFormattedDateString()}}</td>
                            <td>
                                <button type="button" class="btn btn-white btn-sm" data-toggle="modal"
                                        data-target="#stock{{$stock->id}}"><i class="la la-edit"></i></button>
                                <a href="{{url('stock/update/history/'.$stock->id)}}"  title="Stock Updated History" class="btn btn-white btn-sm"><i class="la la-history"></i></a>
                                <div class="modal fade" id="stock{{$stock->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered ">
                                        <div class="modal-content ">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Update Stock Balance</h5>
                                                <button type="button" class="close " data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('stock.update',$stock->id)}}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12 col-12">
                                                            <div class="form-group">
                                                                <label for="dept_name">Product Code:</label><br>
                                                                <input type="text" id="dept_name"
                                                                       class="form-control mb-3" name="name"
                                                                       value="{{$stock->variant->product_code}}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group">
                                                                <label for="address">Current Stock Balance</label>
                                                                <input type="text" class="form-control" id="address"
                                                                       name="before_stock"
                                                                       value="{{$stock->stock_balance}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group">
                                                                <label for="address">Update Stock Balance</label>
                                                                <input type="text" class="form-control" id="address"
                                                                       name="update_stock">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group">
                                                                <label for="aval">Current Available Stock</label>
                                                                <input type="text" class="form-control"
                                                                       name="before_aval" id="aval"
                                                                       value="{{$stock->available}}">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group">
                                                                <label for="aval">Updated Available Stock</label>
                                                                <input type="text" class="form-control"
                                                                       name="after_aval">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="alert">Alert Qty</label>
                                                                <input type="number" name="alert_qty" class="form-control" value="{{$stock->alert_qty}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <button type="submit"
                                                                    class="btn btn-success float-right mr-2">Update
                                                            </button>
                                                            <button type="button"
                                                                    class="btn btn-danger float-right mr-2"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
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