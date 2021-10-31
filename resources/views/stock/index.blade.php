@extends('layout.mainlayout')
@section('title','Stock Transaction')
@section('content')
    <div class="container-fluid">
        <div class="page-header my-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Stock Transaction</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock Transaction</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    {{--@if(isset($revenue))--}}
                        {{--<a href="{{route('showstockin')}}" class="btn add-btn btn-sm"><i class="fa fa-plus"></i>Stock In</a>--}}
                    {{--@elseif(isset($expense))--}}
                        {{--<a href="{{route('showstockout')}}" class="btn add-btn ml-2 btn-sm"><i class="fa fa-plus"></i>--}}
                            {{--Add Expense</a>--}}
                    {{--@else--}}
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
                        <th>Product</th>
                        <th>Variant</th>
                        <th>Qty</th>
                        <th>Type</th>
                        <th>Warehouse</th>
                        <td>Balance</td>
                    </tr>

                    </thead>
                    <tbody>
                    {{--@dd($stock_transactions)--}}
                    @foreach($stock_transactions as $transaction)
                        @if($transaction->type==1)
                            <tr>
                                <td>
                                   {{\Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString()}}
                                </td>
                                <td>{{$transaction->product_name}}</td>
                                <td>{{$transaction->variant->color??''}}{{$transaction->stockin->size?','.$transaction->stockin->size:'' }}</td>
                                <td>+ {{number_format($transaction->stockin->qty)}}</td>
                                <td><span class="badge" style="background-color: #72ff9e">Stock In</span></td>
                                <td>{{$transaction->warehouse->name}}</td>
                                <td>{{$transaction->balance}}</td>                            </tr>
                        @else
                            <tr>
                                <td>
                                    {{\Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString()}}
                                </td>
                                <td>{{$transaction->product_name}}</td>
                                <td>{{$transaction->stockout->color??''}}{{$transaction->stockout->size?','.$transaction->stockout->size:'' }}</td>
                                <td>- {{number_format($transaction->stockout->qty)}}</td>
                                <td><span class="badge" style="background-color: #72ff9e">Stock Out</span></td>
                                <td>{{$transaction->warehouse->name}}</td>
                                <td>{{$transaction->balance}}</td>
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
        $(document).ready(function () {
            $('#stock').DataTable();
            $('.dataTables_filter input').remove('form-control');
            $('.dataTables_filter input').addClass('rounded');
        });
        </script>

@endsection