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
                    <h3 class="page-title">Retail Sale Invoices</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                        <li class="breadcrumb-item active">Invoices</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a data-toggle="modal" data-target="#export"
                       class="btn btn-outline-info mr-1"><i
                                class="fa fa-download mr-1"></i>Export</a>
                    <div id="export" class="modal custom-modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Export</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row justify-content-center">
                                        <div>
                                            {{--@dd($route)--}}
                                            <form action="{{route('invoices.export','All')}}" method="GET">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="start">Start Date</label>
                                                    <input type="date" class="form-control"  name="start_date"
                                                           value="" title="Start Date" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="end">End Date</label>
                                                    <input type="date" class="form-control" name="end_date"
                                                           value="" title="End Date" required>
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit"  class="btn btn-primary">Export</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="form-group">
                <label for="">Filter By:</label><br>
                <input type="checkbox" id="id_check" value="1" checked><label for="" class="mr-2 ml-1">Id</label>
                <input type="checkbox" id="date_check" value="1" checked><label for="" class="mr-2 ml-1">Date</label>
                <input type="checkbox" id="customer_check" value="1" checked><label for="" class="mr-2 ml-1">Customer</label>
                <input type="checkbox" id="status_check" value="1" checked><label for="" class="mr-2 ml-1">Status</label>
                <input type="checkbox" id="branch_check" value="1"><label for="" class="mr-2 ml-1">Branch</label>
                <input type="checkbox" id="region_check" value="1"><label for="" class="mr-2 ml-1">Region</label>
                <input type="checkbox" id="zone_check" value="1"><label for="" class="mr-2 ml-1">Zone</label>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Search Filter -->
        <div class="row filter-row">
            <div class="col" id="id_search">
                <div class="form-group">
                    <input class="form-control form-control-md  shadow-sm" type="text" id="filter_id" name='id' placeholder="Type Invocie ID">
                </div>
            </div>
            <div class="col date_search">
                <div class="form-group">
                    <input class="form-control form-control-md shadow-sm" type="text" name="min" id="min" placeholder="Enter Start Date">
                </div>
            </div>
            <div class="col date_search">
                <div class="form-group">
                    <input class="form-control shadow-sm form-control-md" type="text" id="max" name="max" placeholder="Enter End Date">
                </div>
            </div>
            <div class="col" id="branch_search">
                <div class="form-group">
                    <select class="select form-control-md" id="branch">
                        <option value="" disabled>Select Status</option>
                        <option value="">All</option>
                        @foreach($branch as $key=>$val)
                            <option value="{{$val}}"> {{$val}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col" id="customer_search">
                <div class="form-group">
                    <input class="form-control shadow-sm form-control-md" type="text" id="customer_name" name="customer_name" placeholder="Type Customer Name">
                </div>
            </div>
            <div class="col" id="status_search">
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
            <div class="col" id="region_search">
                <div class="form-group">
                    <select class="select form-control-md" id="filter_region" >
                        <option value="" disabled>Select Region</option>
                        <option value="">All</option>
                        @foreach($region as $key=>$val)
                            <option value="{{$val}}"> {{$val}} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col" id="zone_search">
                <div class="form-group">
                    <select class="select form-control-md" id="filter_zone">
                        <option value="" disabled>Select Zone</option>
                        <option value="">All</option>
                        @foreach($zone as $item)
                            <option value="{{$item->name}}" data-option="{{$item->region_id}}"> {{$item->name}} </option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
        <hr>
        <!-- /Search Filter -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0 table-hover" id="invoice">
                        <thead>
                        <tr>
                            <th>Invoice Number</th>
                            <th>Sale Type</th>
                            <th>Invoice Type</th>
                            <th>Client</th>
                            <th>Sale Man</th>
                            <th>Created Date</th>
                            <th>Due Date</th>
                            <th>Amount</th>
                            <th>Due Amount</th>
                            <th>Customer Credit</th>
                            <th>Status</th>
                            <th>Region</th>
                            <th>Zone</th>
                            <th>Office Branch</th>
                            <th class="text-right">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allinv as $invoice)
                            <tr>
                                @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                                    <td>@if($invoice->cancel==1)
                                            <strike><a href="{{route('invoices.show',$invoice->id)}}">{{$invoice->invoice_id}}</a></strike>
                                        @else
                                            <a href="{{route('invoices.show',$invoice->id)}}">{{$invoice->invoice_id}}</a>
                                        @endif
                                    </td>
                                @else
                                    <td>
                                        @if($invoice->cancel==1)
                                            <strike>
                                                <a href="{{route("customer.invoice_show",$invoice->id)}}">#{{$invoice->invoice_id}}</a></strike>
                                        @else
                                            <a href="{{route("customer.invoice_show",$invoice->id)}}">#{{$invoice->invoice_id}}</a>
                                        @endif
                                    </td>
                                @endif
                                <td>@if($invoice->cancel==1)
                                        <strike>
                                            {{$invoice->inv_type}}</strike>
                                    @else
                                        {{$invoice->inv_type}}
                                    @endif
                                </td>
                                <td>@if($invoice->cancel==1)
                                        <strike>
                                            {{$invoice->invoice_type}}</strike>
                                    @else
                                        {{$invoice->invoice_type}}
                                    @endif
                                </td>
                                <td>
                                    @if($invoice->cancel==1)
                                        <strike>
                                            {{$invoice->customer->name}}
                                        </strike>
                                    @else
                                        {{$invoice->customer->name}}
                                    @endif
                                </td>
                                <td>
                                    @if($invoice->cancel==1)
                                        <strike>
                                            {{$invoice->employee->name}}
                                        </strike>
                                    @else
                                        {{$invoice->employee->name}}
                                    @endif
                                </td>
                                <td>
                                    @if($invoice->cancel==1)
                                        <strike>
                                            {{$invoice->created_at->toFormattedDateString()}}
                                        </strike>
                                    @else
                                        {{$invoice->created_at->toFormattedDateString()}}
                                    @endif
                                </td>
                                <td>
                                    @if($invoice->cancel==1)
                                        <strike>
                                            {{\Illuminate\Support\Carbon::parse($invoice->due_date)->toFormattedDateString()}}
                                        </strike>
                                    @else
                                        {{\Illuminate\Support\Carbon::parse($invoice->due_date)->toFormattedDateString()}}
                                    @endif
                                </td>
                                <td>
                                    @if($invoice->cancel==1)
                                        <strike>
                                            {{$invoice->grand_total}}
                                        </strike>
                                    @else
                                        {{$invoice->grand_total}}
                                    @endif
                                </td>
                                <td>
                                    @if($invoice->cancel==1)
                                        <strike>
                                            {{$invoice->due_amount}}
                                        </strike>
                                    @else
                                        {{$invoice->due_amount}}
                                    @endif
                                </td>
                                <td>
                                    @if($invoice->cancel==1)
                                        <strike>
                                    <span class="text-{{$invoice->customer->current_credit>$invoice->customer->credit_limit?'danger':''}}"
                                          title="Red Color is over credit limit">{{$invoice->customer->current_credit}}</span>
                                        </strike>
                                    @else
                                        <span class="text-{{$invoice->customer->current_credit>$invoice->customer->credit_limit?'danger':''}}"
                                              title="Red Color is over credit limit">{{$invoice->customer->current_credit}}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($invoice->cancel==1)
                                        <div class="dropdown action-label">
                                            <a class="btn btn-danger btn-sm btn-rounded " href="#" data-toggle="dropdown"
                                               aria-expanded="false"><i
                                                        class="fa fa-dot-circle-o mr-1"></i>Cancel</a>
                                        </div>
                                    @else
                                        <div class="dropdown action-label">
                                            <a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown"
                                               aria-expanded="false"><i
                                                        class="fa fa-dot-circle-o mr-1"></i>{{$invoice->status}}</a>
                                            {{--<a class="btn btn-white btn-sm btn-rounded "  href="#" data-toggle="modal" data-target="#change_status{{$invoice->id}}"></a>--}}
                                        </div>
                                    @endif
                                </td>
                                <td>@if($invoice->cancel==1)
                                        <strike>{{$invoice->region->name??'N/A'}}</strike>
                                    @else
                                        {{$invoice->region->name??'N/A'}}
                                    @endif
                                </td>
                                <td>
                                    @if($invoice->cancel==1)
                                        <strike>{{$invoice->zone->name??'N/A'}}</strike>
                                    @else
                                        {{$invoice->zone->name??'N/A'}}
                                    @endif
                                </td>
                                <td>@if($invoice->cancel==1)
                                        <strike>
                                            <a href="{{url('officebranch/'.$invoice->branch->id)}}">{{$invoice->branch->name}}</a>
                                        </strike>
                                    @else
                                        <a href="{{url('officebranch/'.$invoice->branch->id)}}">{{$invoice->branch->name}}</a>
                                    @endif
                                </td>
                                @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                                    @include('invoice.inv_statuschange')

                                    <td class="text-right">
                                        <a href="{{route("invoices.show",$invoice->id)}}"
                                           class="btn btn-white btn-sm"><i class="la la-eye"></i></a>
                                        @if($invoice->cancel!=1)
                                            <a href="{{route('invoice.cancel',$invoice->id)}}" class="btn btn-danger btn-sm">Cancel</a>
                                        @endif
                                    </td>
                                @else
                                    <td>
                                        <a href="{{route("customer.invoice_show",$invoice->id)}}"
                                           class="btn btn-white btn-sm"><i class="la la-eye"></i></a>
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
        $(document).ready(function () {
            $('#id_search').show();
            $('.date_search').show();
            $('#status_search').show();
            $('#zone_search').hide();
            $('#region_search').hide();
            $('#customer_search').show();
            $('#branch_search').hide();
            $('#id_check').on('click',function () {
                var on_off=$(this).val();
                if($('#id_check').is(':checked')){
                    $('#id_search').show();
                }else {
                    $('#id_search').hide();
                }
            });
            $('#date_check').on('click',function () {
                if($('#date_check').is(':checked')){
                    $('.date_search').show();
                }else {
                    $('.date_search').hide();
                }
            });
            $('#customer_check').on('click',function () {

                if($('#customer_check').is(':checked')){
                    $('#customer_search').show();
                }else {
                    $('#customer_search').hide();
                }
            });
            $('#status_check').on('click',function () {
                if($('#status_check').is(':checked')){
                    $('#status_search').show();
                }else {
                    $('#status_search').hide();
                }
            });
            $('#branch_check').on('click',function () {
                if($('#branch_check').is(':checked')){
                    $('#branch_search').show();
                }else {
                    $('#branch_search').hide();
                }
            });
            $('#region_check').on('click',function () {
                if($('#region_check').is(':checked')){
                    $('#region_search').show();
                }else {
                    $('#region_search').hide();
                }
            });
            $('#zone_check').on('click',function () {
                if($('#zone_check').is(':checked')){
                    $('#zone_search').show();
                }else {
                    $('#zone_search').hide();
                }
            });
        });
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
                    var startDate = new Date(data[5]);
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
                table.column(0).search($(this).val()).draw();

            });
        });
        $(document).ready(function() {
            $('#filter_status').on('change', function () {
                var table = $('#invoice').DataTable();
                table.column(10).search($(this).val()).draw();

            });
        });
        $(document).ready(function() {
            $('#filter_zone').on('change', function () {
                var table = $('#invoice').DataTable();
                table.column(12).search($(this).val()).draw();

            });
        });
        $(document).ready(function() {
            $('#filter_region').on('change', function () {
                var table = $('#invoice').DataTable();
                table.column(11).search($(this).val()).draw();

            });
        });
        $(document).ready(function() {
            $('#branch').on('change', function () {
                var table = $('#invoice').DataTable();
                table.column(13).search($(this).val()).draw();

            });
        });
        $(document).ready(function() {
            $('#customer_name').keyup(function () {
                var table = $('#invoice').DataTable();
                table.column(3).search($(this).val()).draw();

            });
        });
        var region_id = document.querySelector('#filter_region');
        var zone_id = document.querySelector('#filter_zone');
        var zone_optoion = zone_id.querySelectorAll('option');
        console.log(options3);
        // alert(product)
        function region(selValue) {
            filter_zone.innerHTML='';

            for(var i = 0; i < zone_optoion.length; i++) {
                if(zone_optoion[i].dataset.option === selValue) {
                    filter_zone.appendChild(zone_optoion[i]);

                }
            }
        }
        region(region_id.value);
    </script>

@endsection
