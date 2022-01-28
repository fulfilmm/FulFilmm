@extends('layout.mainlayout')
@section('title','Stock Edited History')

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
                    <h3 class="page-title">Stock Edited History</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock Edited History</li>
                    </ul>
                </div>
                {{--<div class="col-auto float-right ml-auto">--}}
                    {{--<a data-toggle="modal" data-target="#export"--}}
                       {{--class="btn btn-outline-info rounded-pill btn-sm mr-1"><i--}}
                                {{--class="fa fa-download mr-1"></i>Export</a>--}}
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
                                                    {{--<input type="text" class="form-control" id="start" name="start_date"--}}
                                                           {{--value="" title="Start Date" required>--}}
                                                {{--</div>--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="end">End Date</label>--}}
                                                    {{--<input type="text" class="form-control" id="end" name="end_date"--}}
                                                           {{--value="" title="End Date" required>--}}
                                                {{--</div>--}}
                                                {{--<div class="d-flex justify-content-center">--}}
                                                    {{--<button type="submit" data-dismiss="modal" class="btn btn-primary">Export</button>--}}
                                                {{--</div>--}}
                                            {{--</form>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<a href="{{route('show.transfer')}}" class="btn add-btn btn-sm"><i class="fa fa-plus"></i>Stock--}}
                        {{--Transfer</a>--}}
                {{--</div>--}}
            </div>
        </div>
        <div class="card">
            <div class="table-responsive my-3 col-12" style="overflow: auto">
                <table class="table " id="stock">
                    <thead>
                    <tr>
                        <th style="min-width: 130px">Product Code</th>
                        {{--<th style="min-width: 100px">Product</th>--}}
                        {{--<th style="min-width: 100px">Variants</th>--}}
                        <th style="min-width: 100px">Updated Employee</th>
                        <th style="min-width: 100px">Last Updated</th>
                        <th style="min-width: 100px">Warehouse</th>

                        <th>Before Balance</th>
                        <th style="min-width: 100px">Balance</th>
                        <th>Before Available</th>
                        <th style="min-width: 100px">Available</th>
                        <th style="min-width: 100px">Unit</th>

                    </tr>

                    </thead>
                    <tbody>
                    {{--@dd($stocks)--}}
                    @foreach($history as $stock)
                        <tr>
                            <td style="min-width: 100px">
                                <a href="{{route('show.variant',$stock->variant->id)}}">{{$stock->variant->product_code}}</a>
                            </td>
                            {{--<td>--}}
                            {{--<a href="{{route('products.show',$stock->variant->product_id)}}">{{$stock->product_name}}</a>--}}
                            {{--</td>--}}
                            {{--<td>--}}
                            {{--<a href="{{route('show.variant',$stock->variant->id)}}">{{$stock->variant->variant??''}}</a>--}}
                            {{--</td>--}}
                            <td>{{$stock->emp->name}}</td>
                            <td>{{\Carbon\Carbon::parse($stock->updated_at)->toFormattedDateString()}}</td>
                            <td>
                                <a href="{{route('warehouses.show',$stock->warehouse_id)}}">@foreach($wareshouse as $key=>$val) @if($key==$stock->warehouse_id){{$val}}@endif @endforeach</a>
                            </td>

                            <td><span id="from_balance{{$stock->id}}"></span></td>
                            <td><span id="stock_balance{{$stock->id}}"></span></td>
                            <td><span id="from{{$stock->id}}"></span></td>
                            <td><span id="stock_avl{{$stock->id}}"></span>
                                <script>
                                    $(document).ready(function () {
                                        var stock_bal = '{{$stock->updated_balance}}';
                                        var stock_val = '{{$stock->updated_aval}}';
                                        var frombalance='{{$stock->before_balance}}';
                                        var form_val='{{$stock->before_aval}}';
                                        $('#stock_balance{{$stock->id}}').text(stock_bal);
                                        $('#stock_avl{{$stock->id}}').text(stock_val);
                                        $('#from_balance{{$stock->id}}').text(frombalance);
                                        $('#from{{$stock->id}}').text(form_val);
                                        $('#unit{{$stock->id}}').change(function () {
                                            var unit = $(this).val();
                                            var st_bal = Math.round(parseFloat(stock_bal) / parseInt(unit));
                                            var st_val = Math.round(parseFloat(stock_val) / parseInt(unit));
                                            var from_bal = Math.round(parseFloat(frombalance) / parseInt(unit));
                                            var from_val = Math.round(parseFloat(form_val) / parseInt(unit));
                                            $('#stock_balance{{$stock->id}}').text(st_bal);
                                            $('#stock_avl{{$stock->id}}').text(st_val);
                                            $('#from_balance{{$stock->id}}').text(from_bal);
                                            $('#from{{$stock->id}}').text(from_val);

                                        });
                                    });
                                </script>
                            </td>
                            <td style="min-width: 100px;">
                                <select name="" id="unit{{$stock->id}}" class="form-control select">
                                    @foreach($units as $unit)
                                        @if($unit->variant_id==$stock->variant->id)
                                            <option value="{{$unit->unit_convert_rate}}" {{$unit->unit_convert_rate==1?'selected':''}}>{{$unit->unit}}</option>
                                        @endif
                                    @endforeach
                                </select>
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