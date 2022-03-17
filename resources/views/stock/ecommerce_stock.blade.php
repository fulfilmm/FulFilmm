@extends('layout.mainlayout')
@section('title','Stock')
@section('content')
    <div class="container-fluid">
        <div class="page-header my-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">E-commerce Stock</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">E-commerce Stock</li>
                    </ul>
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
                        <th style="min-width: 100px">Brand</th>
                        <th style="min-width: 100px">Qty</th>
                        <th style="min-width: 100px">Unit</th>
                    </tr>

                    </thead>
                    <tbody>
                    {{--@dd($stocks)--}}
                    @foreach($ecommerce_stocks as $stock)
                        <tr>
                            <td style="min-width: 100px">
                                <a href="{{route('show.variant',$stock->variant->id)}}">{{$stock->variant->product_code}}</a>
                            </td>
                            <td>
                                <a href="{{route('products.show',$stock->variant->product_id)}}">{{$stock->variant->product_name}}</a>
                            </td>
                            <td>
                                <a href="{{route('show.variant',$stock->variant->id)}}">{{$stock->variant->variant??''}}</a>
                            </td>
                            <td>
                                {{$stock->brand}}
                            </td>
                            <td><span id="stock_balance{{$stock->id}}"></span>
                                <script>
                                    $(document).ready(function () {
                                        var stock_bal = '{{$stock->qty}}';
                                        $('#stock_balance{{$stock->id}}').text(stock_bal);
                                        $('#unit{{$stock->id}}').change(function () {
                                            var unit = $(this).val();
                                            var st_bal = Math.round(parseFloat(stock_bal) / parseInt(unit));
                                            $('#stock_balance{{$stock->id}}').text(st_bal);

                                        });
                                    });
                                </script>
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