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
                        <th>Validated Qty</th>
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
                                <td>{{$transfer->validate_qty}}</td>
                                <td>{{$transfer->from->name}}</td>
                                <td>{{$transfer->to->name}}</td>
                                <td>@if($transfer->validated==0 && \Illuminate\Support\Facades\Auth::guard('employee')->user()->id==$transfer->receiver_id)
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#validate_qty{{$transfer->id}}">Validate</button>
                                        <div id="validate_qty{{$transfer->id}}" class="modal custom-modal fade" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header border-bottom">
                                                        <h5 class="modal-title">Edit Qty</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{url('stock/transfer/validate/'.$transfer->id)}}" method="post">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="from-group">
                                                                        <label for="qty">Validate Qty</label>
                                                                        <input type="number" class="form-control" name="validate_qty" value="{{$transfer->validate_qty}}">
                                                                    </div>
                                                                    <div class="from-group my-2">
                                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        @if($transfer->receipt==0)<a href="{{url('stock/transfer/receipt/'.$transfer->id)}}" class="btn btn-warning btn-sm">Receipt</a>
                                @else
                                    Receipted
                                    @endif
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