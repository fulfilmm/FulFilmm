@extends('layout.mainlayout')
@section('title','Stock Transaction')
@section('content')
    <div class="container-fluid">
        <div class="page-header my-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Stock Out</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock</li>
                        <li class="breadcrumb-item active">Out</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('showstockout')}}" class="btn add-btn ml-2 btn-sm"><i class="fa fa-plus"></i>
                        Stock Out</a>
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
                        <th>Unit</th>
                        <th>Type</th>
                        <th>Approver Name</th>
                        <th>Warehouse</th>
                        <th>Action</th>
                    </tr>

                    </thead>
                    <tbody>
                    {{--@dd($stock_transactions)--}}
                    @foreach($stock as $item)
                            <tr>
                                <td>
                                    {{\Carbon\Carbon::parse($item->created_at)->toFormattedDateString()}}
                                </td>
                                <td>{{$item->variant->product_name}}</td>
                                <td>{{$item->variant->variant}}</td>
                                <td><span id="qty{{$item->id}}"></span>
                                    <script>
                                        $(document).ready(function () {
                                            var qty = '{{$item->qty}}';
                                            $('#qty{{$item->id}}').text(qty);
                                            $('#unit{{$item->id}}').change(function () {
                                                var unit = $(this).val();
                                                var st_bal = Math.round(parseFloat(qty) / parseInt(unit));
                                                $('#qty{{$item->id}}').text(st_bal);

                                            });
                                        });
                                    </script>
                                </td>
                                <td> <select name="" id="unit{{$item->id}}" class="form-control select">
                                        @foreach($units as $unit)
                                            @if($unit->product_id==$item->variant->product_id)
                                                <option value="{{$unit->unit_convert_rate}}" {{$unit->unit_convert_rate==1?'selected':''}}>{{$unit->unit}}</option>
                                            @endif
                                        @endforeach
                                    </select></td>
                                <td>{{$item->type}}</td>
                                <td>{{$item->approver->name}}</td>
                                <td>{{$item->warehouse->name}}</td>
                                <td>
                                    @if($item->approve)
                                        <span class="badge badge-success">Approved</span>
                                    @else
                                        <a href="{{route('stockout.approve',$item->id)}}" class="btn btn-white btn-sm">
                                            Approve
                                        </a>
                                    @endif
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
        $(document).ready(function () {
            $('#stock').DataTable();
            $('.dataTables_filter input').remove('form-control');
            $('.dataTables_filter input').addClass('rounded');
        });
    </script>

@endsection