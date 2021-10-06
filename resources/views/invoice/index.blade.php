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
                        <div class="col-auto float-right ml-auto">
                            <a href="{{route('invoices.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Create Invoice</a>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <!-- Search Filter -->
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <div>
                                <input class="form-control floating " type="text" id="filter_id" name='id' value="#">
                            </div>
                            <label class="focus-label">ID</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <div >
                                <input class="form-control floating " type="text" name="min" id="min">
                            </div>
                            <label class="focus-label">From</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <div>
                                <input class="form-control floating " type="text" id="max" name="max">
                            </div>
                            <label class="focus-label">To</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <select class="select floating" id="filter_status">
                                <option value="">All</option>
                                @foreach($status as $key=>$val)
                                    <option value="{{$val}}"> {{$val}} </option>
                                @endforeach
                            </select>
                            <label class="focus-label">Status</label>
                        </div>
                    </div>

                </div>
                    <!-- /Search Filter -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table  mb-0" id="invoice">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice Number</th>
                                        <th>Client</th>
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
                                        <td>{{$invoice->id}}</td>
                                        <td><a href="{{route('invoices.show',$invoice->id)}}">#{{$invoice->invoice_id}}</a></td>
                                        <td>{{$invoice->customer->name}}</td>
                                        <td>{{$invoice->created_at->toFormattedDateString()}}</td>
                                        <td>{{\Illuminate\Support\Carbon::parse($invoice->due_date)->toFormattedDateString()}}</td>
                                        <td>{{$invoice->grand_total}}</td>
                                        <td>
                                            <div class="dropdown action-label">
                                                <a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o mr-1"></i>{{$invoice->status}}</a>
                                                {{--<a class="btn btn-white btn-sm btn-rounded "  href="#" data-toggle="modal" data-target="#change_status{{$invoice->id}}"></a>--}}
                                            </div>
                                        </td>
                                        @include('invoice.inv_statuschange')
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
{{--                                                    <a class="dropdown-item" href="{{route("invoices.edit",$invoice->id)}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
                                                    <a class="dropdown-item" href="{{route("invoices.show",$invoice->id)}}"><i class="fa fa-eye m-r-5"></i> View</a>
{{--                                                    <a class="dropdown-item" href="#"><i class="fa fa-file-pdf-o m-r-5"></i> Download</a>--}}
                                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#delete{{$invoice->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
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
                    $('#filter_id').on('change', function () {
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
