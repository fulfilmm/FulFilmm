@extends('layout.mainlayout')
@section('title','Expense')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Expense</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item float-right">Expense</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('expense.create')}}" class="btn add-btn btn-sm"><i class="fa fa-plus"></i> Add
                        Expense</a>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col">
                <input type="text" class="form-control form-control-sm rounded" id="issuer" placeholder="Employee">
            </div>
            <div class="col">
                <input type="text" class="form-control form-control-sm rounded" id="bill" placeholder="Bill Id">
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
            <div class="table-responsive my-3 col-12">
                <table class="table " id="transaction">
                    <thead>
                    <tr>
                        <th>Code</th>
                        <th>GL Account</th>
                        <th>Date</th>
                        <th>Bill ID</th>
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Category</th>
                        <th>Account</th>
                        <th>Approve</th>
                        <th>Approver</th>
                        <th>Employee</th>
                        <th>Action</th>
                    </tr>

                    </thead>
                    <tbody>
                    {{--                    @dd($expenses)--}}
                    @foreach($expenses as $transaction)
                        <tr>
                            <td >@foreach($coa as $coaitem) {{$coaitem->id==$transaction->expense->category?$coaitem->code:''}}  @endforeach</td>
                            <td style="min-width: 150px;">@foreach($coa as $coaitem) {{$coaitem->id==$transaction->expense->category?$coaitem->name:''}}  @endforeach</td>
                            <td style="min-width: 150px;">
                                {{\Carbon\Carbon::parse($transaction->expense->transaction_date)->toFormattedDateString()}}
                            </td>
                            <td style="min-width: 150px;">
                                    @if($transaction->expense->bill_id!=null)
                                        @foreach($bill as $b)
                                            @if($b->id==$transaction->expense->bill_id)
                                                <a href="{{$transaction->expense->bill_id==null?route('transactions.show',$transaction->id):route('bills.show',$transaction->expense->bill_id)}}">{{$b->bill_id}}</a>
                                            @endif
                                        @endforeach
                                    @else
                                        N/A
                                    @endif

                            </td>
                            <td style="min-width: 150px;">{{$transaction->expense->title}}</td>
                            <td style="min-width: 150px;">{{number_format($transaction->expense->amount)}}</td>
                           <td>@foreach($category as $item) @if($item->id==$transaction->expense->category) {{$item->name}} @endif @endforeach</td>
                            <td style="min-width: 150px;">{{$transaction->account->name}}</td>
                            <td style="min-width: 150px;">
                                @if($transaction->expense->approve==0)
                                    <a href="{{url('transaction/approve/'.$transaction->expense->id.'/Expense')}}"
                                       class="btn btn-white btn-white btn-sm ">Approve</a>
                                @else
                                    <button type="button" class="btn btn-success btn-sm disabled">Approved</button>
                                @endif
                            </td>
                            <td style="min-width: 150px;">@foreach($employees as $item) {{$item->id==$transaction->expense->approver_id?$item->name:''}}  @endforeach</td>
                            <td style="min-width: 150px;">
                                <a href="{{route('employees.show',$transaction->expense->emp_id)}}">@foreach($employees as $item) {{$item->id==$transaction->expense->emp_id?$item->name:''}}  @endforeach </a>
                            </td>
                            <td>
                                <a href="{{$transaction->expense->invoice_id==null?route('transactions.show',$transaction->id):route('invoices.show',$transaction->expense->invoice_id)}}"
                                   class="btn btn-white btn-sm"><i class="la la-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
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
                    var startDate = new Date(data[2]);
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
            $('#bill').keyup(function () {
                var table = $('#transaction').DataTable();
                table.column(3).search($(this).val()).draw();

            });
        });
        $(document).ready(function() {
            $('#issuer').keyup(function () {
                var table = $('#transaction').DataTable();
                table.column(10).search($(this).val()).draw();

            });
        });
        $(document).ready(function() {
            $('#category').keyup(function () {
                var table = $('#transaction').DataTable();
                table.column(6).search($(this).val()).draw();

            });
        });
    </script>
    {{--<script src="{{url(asset('js/jquery_print.js'))}}"></script>--}}
    {{--<script src="{{url(asset('js/datatable_button.js'))}}"></script>--}}
@endsection