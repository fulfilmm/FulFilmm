@extends('layout.mainlayout')
@if(isset($type))
    @section('title',$type)
    @else
        @section('title','Stock Batch')
@section('search')
    <div class="col-12 mt-1">
        <form action="{{route('stock.search')}}" method="GET">

            <div class="row mt-2">
                <div class="top-nav-search">
                    <input class="form-control" id="start" type="text" name="start_date" placeholder="Enter Start Date and Time">
                </div>
                <div class="top-nav-search">
                    <input class="form-control" id="end" type="text" name="end_date" placeholder="Enter End Date and Time">
                </div>
                <button class="btn rounded-circle" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
@endsection
@endif

@section('content')
    <div class="container-fluid">
        <div class="page-header my-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">@if(isset($type)) {{$type}} @else Stock Batch @endif</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{url('stocks/index')}}">Stock Batch</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="table-responsive my-3 col-12">

                <table class="table " id="stock">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Batch No</th>
                        <th>Product</th>
                        <th>Variant</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Exp Date</th>
                        <th>Alert Month</th>
                        <th>Office Branch</th>
                        <th>Warehouse</th>
                        <th>Per Unit Value</th>
                    </tr>

                    </thead>
                    <tbody>
                    {{--@dd($stock_transactions)--}}
                    @foreach($stock_transactions as $transaction)
                            <tr>
                                <td>
                                    {{\Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString()}}
                                </td>
                                <td>{{$transaction->batch_no}}</td>
                                <td>{{$transaction->variant->product_name}}</td>
                                <td>{{$transaction->variant->variant??''}}</td>
                                <td>+ <span id="qty{{$transaction->id}}"></span>
                                    <script>
                                        $(document).ready(function () {
                                            var qty = '{{$transaction->qty}}';
                                            var balance='{{$transaction->balance}}';
                                            $('#qty{{$transaction->id}}').text(qty);
                                            $('#balance{{$transaction->id}}').text(balance);

                                            $('#unit{{$transaction->id}}').change(function () {
                                                var unit = $(this).val();
                                                var st_bal = Math.round(parseFloat(qty) / parseInt(unit));
                                                var bal= Math.round(parseFloat(balance) / parseInt(unit));
                                                $('#qty{{$transaction->id}}').text(st_bal);
                                                $('#balance{{$transaction->id}}').text(bal);

                                            });
                                        });
                                    </script>
                                </td>
                                <td>
                                    <select name="" id="unit{{$transaction->id}}" class="form-control select">
                                        @foreach($units as $unit)
                                            @if($unit->product_id==$transaction->variant->product_id)
                                                <option value="{{$unit->unit_convert_rate}}" {{$unit->unit_convert_rate==1?'selected':''}}>{{$unit->unit}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td>{{\Carbon\Carbon::parse($transaction->exp_date)->toFormattedDateString()}}</td>
                                <td>{{\Carbon\Carbon::parse($transaction->alert_month)->format('M Y')}}</td>
                                <td>{{$transaction->branch->name}}</td>
                                <td>{{$transaction->warehouse->name}}</td>
                                <td>{{$transaction->purchase_price}}</td>
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
            $('#stock').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
            $('.dataTables_filter input').remove('form-control');
            $('.dataTables_filter input').addClass('rounded');
        });
    </script>

@endsection