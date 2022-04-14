@extends('layout.mainlayout')
@section('title','Stock Transfer')
@section('content')
    <div class="container-fluid">
        <div class="page-header my-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Stock Transfer</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock Transfer</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">

                    <a href="{{route('show.transfer')}}" class="btn add-btn btn-sm"><i class="fa fa-plus"></i>Stock Transer</a>

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
                        <th>From</th>
                        <th>To</th>
                        <th>Status</th>
                    </tr>

                    </thead>
                    <tbody>
                    {{--@dd($transfers)--}}
                    @foreach($transfers as $transfer)
                            <tr>
                                <td>
                                    {{\Carbon\Carbon::parse($transfer->created_at)->toFormattedDateString()}}
                                </td>
                                <td>{{$transfer->product_name}}</td>
                                <td>{{$transfer->variant->variant}}</td>
                                <td>{{number_format($transfer->qty)}}</td>
                                <td>{{$transfer->from->name}}</td>
                                <td>{{$transfer->to->name}}</td>
                                <td>@if($transfer->receipt==0)<a href="{{url('stock/transfer/receipt/'.$transfer->id)}}" class="btn btn-warning btn-sm">Receipt</a>
                                @else
                                    Receipted
                                    @endif

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
        $(document).ready(function () {
            $('#stock').DataTable();
            $('.dataTables_filter input').remove('form-control');
            $('.dataTables_filter input').addClass('rounded');
        });
    </script>

@endsection