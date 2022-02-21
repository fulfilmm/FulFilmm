@extends('layout.mainlayout')
@section('title','Invoices')
@section('content')
    <style>
        #invoice_filter{
            visibility: hidden;
        }
    </style>
            <!-- Page Content -->
            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Invoices</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                                <li class="breadcrumb-item active">Invoices</li>
                            </ul>
                        </div>
                       @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                            <div class="col-auto float-right ml-auto">
                                <a href="{{route('invoices.create')}}" class="btn add-btn shadow-sm"><i class="fa fa-plus"></i> Create Invoice</a>
                            </div>
                           @endif
                    </div>
                </div>
                <!-- /Page Header -->

                <!-- Search Filter -->
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <input class="form-control form-control-md  shadow-sm" type="text" id="filter_id" name='id' placeholder="Type Invocie ID">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group ">
                            <input class="form-control form-control-md shadow-sm" type="text" name="min" id="min" placeholder="Enter Start Date">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <input class="form-control shadow-sm form-control-md" type="text" id="max" name="max" placeholder="Enter End Date">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <select class="select form-control-md" id="filter_status">
                                <option value="" disabled>Select Status</option>
                                <option value="">All</option>
                                @foreach($status as $key=>$val)
                                    <option value="{{$val}}"> {{$val}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                    <!-- /Search Filter -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0 table-hover" id="invoice">
                                <thead>
                                    <tr>
                                        <th>Invoice Number</th>
                                        <th>Client</th>
                                        <th>Sale Man</th>
                                        <th>Created Date</th>
                                        <th>Due Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 @foreach($allinv as $invoice)
                                    <tr>
                                        @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                                            <td><a href="{{route('invoices.show',$invoice->id)}}">{{$invoice->invoice_id}}</a></td>
                                            @else
                                            <td><a href="{{route("customer.invoice_show",$invoice->id)}}" >#{{$invoice->invoice_id}}</a></td>
                                            @endif

                                        <td>{{$invoice->customer->name}}</td>
                                            <td>{{$invoice->employee->name}}</td>
                                        <td>{{$invoice->created_at->toFormattedDateString()}}</td>
                                        <td>{{\Illuminate\Support\Carbon::parse($invoice->due_date)->toFormattedDateString()}}</td>
                                        <td>{{$invoice->grand_total}}</td>
                                        <td>
                                            <div class="dropdown action-label">
                                                <a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o mr-1"></i>{{$invoice->status}}</a>
                                                {{--<a class="btn btn-white btn-sm btn-rounded "  href="#" data-toggle="modal" data-target="#change_status{{$invoice->id}}"></a>--}}
                                            </div>
                                        </td>
                                        @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                                            @include('invoice.inv_statuschange')

                                            <td class="text-right">
                                                <a href="{{route("invoices.show",$invoice->id)}}" class="btn btn-white btn-sm"><i class="la la-eye"></i></a>
                                               <button type="button" data-toggle="modal" data-target="#delete{{$invoice->id}}" class="btn btn-danger btn-sm"><i class="la la-trash"></i></button>
                                            </td>
                                            @else
                                            <td>
                                                <a href="{{route("customer.invoice_show",$invoice->id)}}" class="btn btn-white btn-sm"><i class="la la-eye"></i></a>
                                            </td>
                                            @endif
                                    </tr>
                                     @include('invoice.delete')
                                 @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /Page Content -->
            <script>
                $(document).ready(function(){
                    $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var min = $('#min').datepicker("getDate");
                            var max = $('#max').datepicker("getDate");
                            var startDate = new Date(data[3]);
                            if (min == null && max == null) { return true; }
                            if (min == null && startDate <= max) { return true;}
                            if(max == null && startDate >= min) {return true;}
                            if (startDate <= max && startDate >= min) { return true; }
                            return false;
                        }
                    );

                    $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
                    $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
                    var table = $('#invoice').DataTable();

                    // Event listener to the two range filtering inputs to redraw on input
                    $('#min, #max').change(function () {
                        table.draw();
                    });
                });
                $(document).ready(function() {
                    $('#filter_id').keyup(function () {
                        var table = $('#invoice').DataTable();
                        table.column(1).search($(this).val()).draw();

                    });
                });
                $(document).ready(function() {
                    $('#filter_status').on('change', function () {
                        var table = $('#invoice').DataTable();
                        table.column(6).search($(this).val()).draw();

                    });
                });
            </script>

@endsection
