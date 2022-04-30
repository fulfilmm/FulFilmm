@extends('layout.mainlayout')
@section('title','Quantity Alert')
@section('content')
    <div class="container-fluid">
        <div class="page-header my-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Stock Quantity Alert</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Quantity Alert</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="table-responsive my-3 col-12" style="overflow: auto">
                <table class="table table-striped custom-table" id="stock">
                    <thead>
                    <tr>
                        <th style="min-width: 100px">Warehouse</th>
                        <th style="min-width: 130px">Product Code</th>
                        <th style="min-width: 130px">Item Code</th>
                        <th style="min-width: 100px">Product</th>
                        <th style="min-width: 100px">Variants</th>
                        <th style="min-width: 100px">Unit</th>
                        <th style="min-width: 100px">Balance</th>
                        <th style="min-width: 100px">Available</th>
                        <th style="min-width: 100px">On the Way Qty</th>
                        <th style="min-width: 100px">Alert Qty</th>
                        <th style="min-width: 100px">Last Updated</th>
                    </tr>

                    </thead>
                    <tbody>
                    {{--@dd($stocks)--}}
                    @foreach($stocks as $stock)
                        <tr>
                            <td>
                                <a href="{{route('warehouses.show',$stock->warehouse->id)}}">{{$stock->warehouse->name}}</a>
                            </td>
                            <td style="min-width: 100px">
                                @foreach($product as $key=>$val)
                                    @if($key==$stock->variant->product_id)
                                        <a href="{{route('products.show',$key)}}">{{$val}}</a>
                                    @endif
                                @endforeach
                            </td>
                            <td style="min-width: 100px">
                                <a href="{{route('show.variant',$stock->variant->id)}}">{{$stock->variant->item_code}}</a>
                            </td>
                            <td>
                                <a href="{{route('products.show',$stock->variant->product_id)}}">{{$stock->variant->product_name}}</a>
                            </td>
                            <td>
                                <a href="{{route('show.variant',$stock->variant->id)}}">{{$stock->variant->variant??$stock->variant->product_name}}</a>
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
                                        var ontheway='{{$stock->ontheway_qty}}';
                                        $('#stock_balance{{$stock->id}}').text(stock_bal);
                                        $('#stock_avl{{$stock->id}}').text(stock_val);
                                        $('#ontheway{{$stock->id}}').text(ontheway);
                                        $('#unit{{$stock->id}}').change(function () {
                                            var unit = $(this).val();
                                            var st_bal = Math.round(parseFloat(stock_bal) / parseInt(unit));
                                            var st_val = Math.round(parseFloat(stock_val) / parseInt(unit));
                                            var ontheway = Math.round(parseFloat(ontheway) / parseInt(unit));
                                            $('#stock_balance{{$stock->id}}').text(st_bal);
                                            $('#stock_avl{{$stock->id}}').text(st_val);
                                            $('#ontheway{{$stock->id}}').text(ontheway);

                                        });
                                    });
                                </script>
                            </td>
                            <td><span id="ontheway{{$stock->id}}"></span></td>
                            <td>{{$stock->alert_qty}}</td>
                            <td>{{\Carbon\Carbon::parse($stock->updated_at)->toFormattedDateString()}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection