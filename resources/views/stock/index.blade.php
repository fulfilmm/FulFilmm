@extends('layout.mainlayout')
@section('title','Stock Transaction')
@section('search')
    <div class="col-12 mt-1">
        <form action="{{route('stock.search')}}" method="GET">

            <div class="row mt-2">
                <div class="top-nav-search col-md-5 col-sm-5 col-5">
                    <input class="form-control" id="start" type="text" name="start_date"
                           placeholder="Enter Start Date and Time">
                </div>
                <div class="top-nav-search col-md-5 col-sm-5 col-5">
                    <input class="form-control" id="end" type="text" name="end_date"
                           placeholder="Enter End Date and Time">
                </div>
                <button class="btn rounded-circle col-md-1 col-sm-1 col-1" type="submit"><i class="fa fa-search"></i>
                </button>
            </div>
        </form>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="page-header my-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Stock Transaction</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{url('stocks/index')}}">Stock Transaction</a></li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">

                    <a href="{{route('showstockout')}}" class="btn add-btn ml-2 btn-sm"><i class="fa fa-plus"></i>
                        Stock Out</a>
                    <a href="{{route('showstockin')}}" class="btn add-btn btn-sm"><i class="fa fa-plus"></i>Stock In</a>
                    {{--@endif--}}
                </div>
            </div>
        </div>
        <div class="card">
            <div class="table-responsive my-3 col-12">

                <table class="table " id="stock">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Supplier/Customer</th>
                        <th>Product</th>
                        <th>Variant</th>
                        <th>Qty</th>
                        <th>Type</th>
                        <th>Warehouse</th>
                        <th>Balance</th>
                        <th>Employee</th>
                        <th>Unit</th>
                    </tr>

                    </thead>
                    <tbody>
                    {{--@dd($stock_transactions)--}}
                    @foreach($stock_transactions as $transaction)
                        @if($transaction->type=="Stock In")
                            <tr>
                                <td>
                                    {{\Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString()}}
                                </td>
                                <td>{{$transaction->customer->name??'N/A'}}</td>
                                <td>{{$transaction->product_name}}</td>
                                <td>{{$transaction->variant->variant??''}}</td>
                                <td><span class="text-success"> + </span><span class="text-success" id="qty{{$transaction->id}}"></span>
                                    <script>
                                        $(document).ready(function () {
                                            var qty = '{{$transaction->stockin->qty}}';
                                            var balance = '{{$transaction->balance}}';
                                            $('#qty{{$transaction->id}}').text(qty);
                                            $('#balance{{$transaction->id}}').text(balance);

                                            $('#unit{{$transaction->id}}').change(function () {
                                                var unit = $(this).val();
                                                var st_bal = Math.round(parseFloat(qty) / parseInt(unit));
                                                var bal = Math.round(parseFloat(balance) / parseInt(unit));
                                                $('#qty{{$transaction->id}}').text(st_bal);
                                                $('#balance{{$transaction->id}}').text(bal);

                                            });
                                        });
                                    </script>
                                </td>
                                <td><span class="text-success">{{$transaction->type}}</span>
                                </td>
                                <td>{{$transaction->warehouse->name}}</td>
                                <td><span id="balance{{$transaction->id}}"></span></td>
                                <td>{{$transaction->employee->name}}</td>
                                <td>
                                    <select name="" id="unit{{$transaction->id}}" class="form-control select">
                                        @foreach($units as $unit)
                                            @if($unit->product_id==$transaction->variant->product_id)
                                                <option value="{{$unit->unit_convert_rate}}" {{$unit->unit_convert_rate==1?'selected':''}}>{{$unit->unit}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @elseif($transaction->type=="Stock Out")
                            <tr>
                                <td>
                                    {{\Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString()}}
                                </td>
                                <td>{{$transaction->customer->name??'N/A'}}</td>
                                <td>{{$transaction->product_name}}</td>
                                <td>
                                    {{$transaction->variant->variant??''}}
                                </td>

                                <td>
                                   <span class="text-danger">-</span> <span class="text-danger" id="outqty{{$transaction->id}}"></span>
                                    <script>
                                        $(document).ready(function () {
                                            var qty = '{{$transaction->stockout->qty}}';
                                            var balance = '{{$transaction->balance}}';
                                            $('#outqty{{$transaction->id}}').text(qty);
                                            $('#outbalance{{$transaction->id}}').text(balance);

                                            $('#outunit{{$transaction->id}}').change(function () {
                                                var unit = $(this).val();
                                                var st_bal = Math.round(parseFloat(qty) / parseInt(unit));
                                                var bal = Math.round(parseFloat(balance) / parseInt(unit));
                                                $('#outqty{{$transaction->id}}').text(st_bal);
                                                $('#outbalance{{$transaction->id}}').text(bal);

                                            });
                                        });
                                    </script>
                                </td>

                                <td><span class="text-danger" >{{$transaction->type}}</span>
                                </td>
                                <td>{{$transaction->warehouse->name}}</td>
                                <td><span id="outbalance{{$transaction->id}}"></span></td>
                                <td>{{$transaction->employee->name}}</td>
                                <td>
                                    <select name="" id="outunit{{$transaction->id}}" class="form-control select">
                                        @foreach($units as $unit)
                                            @if($unit->product_id==$transaction->variant->product_id)
                                                <option value="{{$unit->unit_convert_rate}}" {{$unit->unit_convert_rate==1?'selected':''}}>{{$unit->unit}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td>
                                    {{\Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString()}}
                                </td>
                                <td>{{$transaction->customer->name??'N/A'}}</td>
                                <td>{{$transaction->variant->product_name}}</td>
                                <td>
                                    {{$transaction->variant->variant??''}}
                                </td>

                                <td>
                                    <i class="la la-undo text-primary"></i> <span class="text-primary" id="outqty{{$transaction->id}}"></span>
                                    <script>
                                        $(document).ready(function () {
                                            var qty = '{{$transaction->stockreturn->qty}}';
                                            var balance = '{{$transaction->balance}}';
                                            $('#outqty{{$transaction->id}}').text(qty);
                                            $('#outbalance{{$transaction->id}}').text(balance);

                                            $('#outunit{{$transaction->id}}').change(function () {
                                                var unit = $(this).val();
                                                var st_bal = Math.round(parseFloat(qty) / parseInt(unit));
                                                var bal = Math.round(parseFloat(balance) / parseInt(unit));
                                                $('#outqty{{$transaction->id}}').text(st_bal);
                                                $('#outbalance{{$transaction->id}}').text(bal);

                                            });
                                        });
                                    </script>
                                </td>

                                <td><span class="text-primary" >{{$transaction->type}}</span>
                                </td>
                                <td>{{$transaction->warehouse->name}}</td>
                                <td><span id="outbalance{{$transaction->id}}"></span></td>
                                <td>{{$transaction->employee->name}}</td>
                                <td>
                                    <select name="" id="outunit{{$transaction->id}}" class="form-control select">
                                        @foreach($units as $unit)
                                            @if($unit->product_id==$transaction->variant->product_id)
                                                <option value="{{$unit->unit_convert_rate}}" {{$unit->unit_convert_rate==1?'selected':''}}>{{$unit->unit}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endif
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