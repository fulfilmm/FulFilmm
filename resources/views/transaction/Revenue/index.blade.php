@extends('layout.mainlayout')
@section('title','Revenue')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Revenue</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item float-right">Revenue</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <button type="button" class="btn btn-outline-info btn-sm rounded-pill mr-2" data-toggle="modal" data-target="#transfer">Transfer</button>
                    <a href="{{route('income.create')}}" class="btn add-btn btn-sm"><i class="fa fa-plus"></i> Add
                        Income</a>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col">
                <input type="text" class="form-control form-control-sm rounded" id="receiver" placeholder="Employee">
            </div>
            <div class="col">
                <input type="text" class="form-control form-control-sm rounded" id="inv_id" placeholder="Invoice Id">
            </div>
            <div class="col">
                <input type="text" class="form-control form-control-sm rounded" id="min" placeholder="Start Date">
            </div>
            <div class="col">
                <input type="text" class="form-control form-control-sm rounded" id="max" placeholder="End Date">
            </div>
            <div class="col">
                <input type="text" class="form-control form-control-sm rounded" id="category" placeholder="Category">
            </div>
        </div>
        <div class="card">
            <form action="{{url('transfer/branch')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="my-3 col-12" style="overflow: auto">
                    <table class="table " id="transaction">
                        <thead>
                        <tr>
                            {{--<th>Code</th>--}}
                            {{--<th>Account</th>--}}
                            <th>Is Transfer</th>
                            <th style="width: 150px;">Date</th>
                            <th>Invoice ID</th>
                            <th>Title</th>
                            <th>Amount</th>
                            <th>Category</th>
                            <th style="width: 400px;">Cashier</th>
                            <th style="width: 400px;">Finance Manager</th>
                            <th>Created By</th>
                            <th style="width: 250px;">Cashier Approve</th>
                            <th style="width: 250px;">Finance Manager Approve</th>
                            <th style="width: 200px;">Action</th>
                        </tr>

                        </thead>

                        <tbody>
                        @foreach($revenues as $transaction)
                            <tr>
                                <td>
                                    @if($transaction->is_cashintransit)
                                        Yes
                                    @else
                                        <input type="checkbox"  name="revenue[]" value="{{$transaction->id}}" class="single" title="Cash in Regional Cashier! Check and click transfer button">
                                    @endif

                                </td>
                                {{--<td>{{$transaction->account->code}}</td>--}}
                                {{--<td>{{$transaction->account->code.'-'.$transaction->account->name??'N/A'}}</td>--}}
                                <td>
                                    {{\Carbon\Carbon::parse($transaction->transaction_date)->toFormattedDateString()}}
                                </td>
                                <td>@if($transaction->invoice_id!=null)<a href="{{route('invoices.show',$transaction->invoice->id)}}">{{$transaction->invoice->invoice_id}}</a>@else N/A @endif</td>
                                <td>{{$transaction->title}}</td>
                                <td>{{number_format($transaction->amount)}}</td>
                                <td>{{$transaction->cat->name}}</td>
                                <td>{{$transaction->branch_cashier->name}}</td>
                                <td>{{$transaction->manager->name}}</td>
                                <td>{{$transaction->employee->name}}</td>

                                <td>
                                    @if($transaction->approve==0)
                                        <a href="{{url('transaction/approve/'.$transaction->id.'/Revenue')}}" class="btn btn-white btn-white btn-sm">Receive</a>
                                    @else
                                        <button type="button" class="btn btn-success btn-sm disabled">Received</button>
                                    @endif
                                </td>
                                <td style="width: 200px;">
                                    @if($transaction->received==0)
                                        @if($transaction->finance_manager==\Illuminate\Support\Facades\Auth::guard('employee')->user()->id)
                                            <a href="{{url('transaction/approve/'.$transaction->id.'/Revenue')}}" class="btn btn-white btn-white btn-sm">Receive</a>
                                        @else
                                            <button type="button" class="btn btn-info btn-sm disabled">Waiting</button>
                                        @endif
                                    @else
                                        <button type="button" class="btn btn-success btn-sm disabled">Received</button>
                                    @endif
                                </td>
                                <td style="width: 150px;">
                                    <a href="{{$transaction->invoice_id==null?route('transactions.show',$transaction->id):route('invoices.show',$transaction->invoice_id)}}" class="btn btn-white btn-sm"><i class="la la-eye"></i></a>
                                    @if($transaction->approve==0)
                                        <a href="{{route('revenue.edit',$transaction->id)}}" class="btn btn-primary btn-sm"><i class="la la-edit"></i></a>
                                        {{--<a href="{{route('revenue.delete',$transaction->id)}}" class="btn btn-danger btn-sm"><i class="la la-trash"></i></a>--}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="transfer" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-md">
                        <div class="modal-content">
                            <div class="modal-header border-bottom">
                                <h5 class="modal-title">Transfer To Branch Cashier</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="file" name="attachment" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Comment</label>
                                    <input type="text" name="comment" class="form-control" placeholder="Enter comment">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        jQuery(document).ready(function () {
            'use strict';
            jQuery('#start').datetimepicker();
            jQuery('#end').datetimepicker();
        });
        $(document).ready(function(){
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = $('#min').datepicker("getDate");
                    var max = $('#max').datepicker("getDate");
                    var startDate = new Date(data[1]);
                    if (min == null && max == null) { return true; }
                    if (min == null && startDate <= max) { return true;}
                    if(max == null && startDate >= min) {return true;}
                    if (startDate <= max && startDate >= min) { return true; }
                    return false;
                }
            );
            $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            var table = $('#transaction').DataTable();
            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                table.draw();
            });
        });
        $(document).ready(function() {
            $('#inv_id').keyup(function () {
                var table = $('#transaction').DataTable();
                table.column(2).search($(this).val()).draw();
            });
        });
        $(document).ready(function() {
            $('#receiver').keyup(function () {
                var table = $('#transaction').DataTable();
                table.column(8).search($(this).val()).draw();
            });
        });
        $(document).ready(function() {
            $('#category').keyup(function () {
                var table = $('#transaction').DataTable();
                table.column(5).search($(this).val()).draw();
            });
        });
    </script>
    {{--<script src="{{url(asset('js/jquery_print.js'))}}"></script>--}}
    {{--<script src="{{url(asset('js/datatable_button.js'))}}"></script>--}}
@endsection