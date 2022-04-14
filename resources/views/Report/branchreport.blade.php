@extends('layout.mainlayout')
@section('title','Sale Report')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">{{$branch->name}} Branch Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Branch Report
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <ul class="nav nav-pills mb-3 border-rounded" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#stock_tab" role="tab" aria-controls="pills-home" aria-selected="true">Stock</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#stockin_tab" role="tab" aria-controls="pills-profile" aria-selected="false">Stock In</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#stockout_tab" role="tab" aria-controls="pills-profile" aria-selected="false">Stock Out</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#whole" role="tab" aria-controls="pills-profile" aria-selected="false">Whole Sale Invoice</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#retail" role="tab" aria-controls="pills-profile" aria-selected="false">Retail Sale Invoice</a>
                </li>
            </ul>
            <div class="col-12">
                <form action="{{url('branch/report/'.$branch->id)}}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col-6 offset-6">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Start Date</label>
                                        <input type="date" class="form-control shadow-sm form-control-sm rounded-pill" name="start" value="{{$start->format('Y-m-d')}}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">End Date</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control shadow-sm form-control-sm rounded-pill" name="end" value="{{$end->format('Y-m-d')}}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-white shadow-sm btn-sm rounded-pill"><i class="la la-search"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="stock_tab" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="col-12 card shadow">
                        <div class="table-responsive my-3 col-12" style="overflow: auto">
                            <table class="table table-striped custom-table" id="stock">
                                <thead>
                                <tr>
                                    <th style="min-width: 130px">Product Code</th>
                                    <th style="min-width: 100px">Product</th>
                                    <th style="min-width: 100px">Variants</th>
                                    <th style="min-width: 100px">Warehouse</th>
                                    <th style="min-width: 100px">Unit</th>
                                    <th style="min-width: 100px">Balance</th>
                                    <th style="min-width: 100px">Available</th>
                                </tr>

                                </thead>
                                <tbody>
                                {{--@dd($stocks)--}}
                                @foreach($stocks as $stock)
                                    <tr>
                                        <td style="min-width: 100px">
                                            <a href="{{route('show.variant',$stock->variant->id)}}">{{$stock->variant->product_code}}</a>
                                        </td>
                                        <td>
                                            <a href="{{route('products.show',$stock->variant->product_id)}}">{{$stock->variant->product_name}}</a>
                                        </td>
                                        <td>
                                            <a href="{{route('show.variant',$stock->variant->id)}}">{{$stock->variant->variant??''}}</a>
                                        </td>
                                        <td>
                                            <a href="{{route('warehouses.show',$stock->warehouse->id)}}">{{$stock->warehouse->name}}</a>
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
                                                    $('#stock_balance{{$stock->id}}').text(stock_bal);
                                                    $('#stock_avl{{$stock->id}}').text(stock_val);
                                                    $('#unit{{$stock->id}}').change(function () {
                                                        var unit = $(this).val();
                                                        var st_bal = Math.round(parseFloat(stock_bal) / parseInt(unit));
                                                        var st_val = Math.round(parseFloat(stock_val) / parseInt(unit));
                                                        $('#stock_balance{{$stock->id}}').text(st_bal);
                                                        $('#stock_avl{{$stock->id}}').text(st_val);

                                                    });
                                                });
                                            </script>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="stockin_tab" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="col-12 card shadow" style="overflow: auto">
                        <table class="table " id="stock_in">
                            <thead>
                            <tr>
                                <th style="min-width: 150px;">Date</th>
                                <th style="min-width: 150px;">Supplier/Customer</th>
                                <th style="min-width: 150px;">Product</th>
                                <th style="min-width: 150px;">Variant</th>
                                <th style="min-width: 150px;">Qty</th>
                                <th style="min-width: 150px;">Warehouse</th>
                                <th style="min-width: 150px;">Employee</th>
                                <th style="min-width: 150px;">Unit</th>
                            </tr>

                            </thead>
                            <tbody>
                            {{--@dd($stock_transactions)--}}
                            @foreach($stock_transactions as $transaction)
                                @if($transaction->type=="Stock In")
                                    <tr>
                                        <td>
                                            {{\Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString()}}
                                        </td>
                                        <td>{{$transaction->customer->name??'N/A'}}</td>
                                        <td>{{$transaction->product_name}}</td>
                                        <td>{{$transaction->variant->variant??''}}</td>
                                        <td><span class="text-success"> + </span><span class="text-success" id="qty{{$transaction->id}}"></span>
                                            <script>
                                                $(document).ready(function () {
                                                    var qty = '{{$transaction->stockin->qty}}';
                                                    var balance = '{{$transaction->balance}}';
                                                    $('#qty{{$transaction->id}}').text(qty);
                                                    $('#balance{{$transaction->id}}').text(balance);

                                                    $('#unit{{$transaction->id}}').change(function () {
                                                        var unit = $(this).val();
                                                        var st_bal = Math.round(parseFloat(qty) / parseInt(unit));
                                                        var bal = Math.round(parseFloat(balance) / parseInt(unit));
                                                        $('#qty{{$transaction->id}}').text(st_bal);
                                                        $('#balance{{$transaction->id}}').text(bal);

                                                    });
                                                });
                                            </script>
                                        </td>
                                        <td>{{$transaction->warehouse->name}}</td>
                                        <td>{{$transaction->employee->name}}</td>
                                        <td>
                                            <select name="" id="unit{{$transaction->id}}" class="form-control select">
                                                @foreach($units as $unit)
                                                    @if($unit->product_id==$transaction->variant->product_id)
                                                        <option value="{{$unit->unit_convert_rate}}" {{$unit->unit_convert_rate==1?'selected':''}}>{{$unit->unit}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="stockout_tab" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="col-12 card shadow" style="overflow: auto">
                        <table class="table " id="stock_out">
                            <thead>
                            <tr>
                                <th style="min-width: 150px;">Date</th>
                                <th style="min-width: 150px;">Supplier/Customer</th>
                                <th style="min-width: 150px;">Product</th>
                                <th style="min-width: 150px;">Variant</th>
                                <th style="min-width: 150px;">Qty</th>
                                <th style="min-width: 150px;">Warehouse</th>
                                <th style="min-width: 150px;">Employee</th>
                                <th style="min-width: 150px;">Unit</th>
                            </tr>

                            </thead>
                            <tbody>
                            {{--@dd($stock_transactions)--}}
                            @foreach($stock_transactions as $transaction)
                                @if($transaction->type=="Stock Out")
                                <tr>
                                    <td>
                                        {{\Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString()}}
                                    </td>
                                    <td>{{$transaction->customer->name??'N/A'}}</td>
                                    <td>{{$transaction->product_name}}</td>
                                    <td>
                                        {{$transaction->variant->variant??''}}
                                    </td>

                                    <td>
                                        <span class="text-danger">-</span> <span class="text-danger" id="outqty{{$transaction->id}}"></span>
                                        <script>
                                            $(document).ready(function () {
                                                var qty = '{{$transaction->qty}}';
                                                var balance = '{{$transaction->balance}}';
                                                $('#outqty{{$transaction->id}}').text(qty);
                                                $('#outbalance{{$transaction->id}}').text(balance);

                                                $('#outunit{{$transaction->id}}').change(function () {
                                                    var unit = $(this).val();
                                                    var st_bal = Math.round(parseFloat(qty) / parseInt(unit));
                                                    var bal = Math.round(parseFloat(balance) / parseInt(unit));
                                                    $('#outqty{{$transaction->id}}').text(st_bal);
                                                    $('#outbalance{{$transaction->id}}').text(bal);

                                                });
                                            });
                                        </script>
                                    </td>
                                    </td>
                                    <td>{{$transaction->warehouse->name}}</td>
                                    <td>{{$transaction->employee->name}}</td>
                                    <td>
                                        <select name="" id="outunit{{$transaction->id}}" class="form-control select">
                                            @foreach($units as $unit)
                                                @if($unit->product_id==$transaction->variant->product_id)
                                                    <option value="{{$unit->unit_convert_rate}}" {{$unit->unit_convert_rate==1?'selected':''}}>{{$unit->unit}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="whole" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div class="card shadow">
                        <div class="col-12 my-2">
                            <strong class="my-3">Filter By:</strong>
                            <div class="row filter-row justify-content-between">
                                <div class="col">
                                    <div class="form-group">
                                        <input class="form-control form-control-md  shadow-sm" type="text" id="whole_filter_id" name='id' placeholder="Type Invocie ID">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group ">
                                        <input class="form-control form-control-md shadow-sm" type="text" name="whole_min" id="whole_min" placeholder="Enter Start Date">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input class="form-control shadow-sm form-control-md" type="text" id="whole_max" name="whole_max" placeholder="Enter End Date">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input class="form-control shadow-sm form-control-md" type="text" id="whole_customer_name" name="whole_customer_name" placeholder="Type Customer Name">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <select class="select form-control-md" id="whole_filter_status">
                                            <option value="" disabled>Select Status</option>
                                            <option value="">All</option>
                                            @foreach($status as $key=>$val)
                                                <option value="{{$val}}"> {{$val}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="float-right mr-3">
                                    Total Sale Amount: <strong id="whole_grand"></strong> MMK
                                </div>
                            </div>
                            <div class="col-md-12 my-2">
                                <div class="table-responsive">
                                    <table class="table table-nowrap mb-0 table-hover" id="whole_invoice">
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
                                            <th>Status</th>
                                            <th>Office Branch</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($invoices as $invoice)
                                            @if($invoice->inv_type=='Whole Sale')
                                                <tr>
                                                    @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                                                        <td><a href="{{route('invoices.show',$invoice->id)}}">{{$invoice->invoice_id}}</a></td>
                                                    @else
                                                        <td><a href="{{route("customer.invoice_show",$invoice->id)}}" >#{{$invoice->invoice_id}}</a></td>
                                                    @endif
                                                    <td>{{$invoice->inv_type}}</td>
                                                    <td>{{$invoice->invoice_type}}</td>
                                                    <td>{{$invoice->customer->name}}</td>
                                                    <td>{{$invoice->employee->name}}</td>
                                                    <td>{{$invoice->created_at->toFormattedDateString()}}</td>
                                                    <td>{{\Illuminate\Support\Carbon::parse($invoice->due_date)->toFormattedDateString()}}</td>
                                                    <td>{{$invoice->grand_total}}
                                                        <input type="hidden" class="whole_total" value="{{$invoice->grand_total}}">
                                                    </td>
                                                    <td>{{$invoice->due_amount}}</td>
                                                    <td>
                                                        <div class="dropdown action-label">
                                                            <a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o mr-1"></i>{{$invoice->status}}</a>
                                                            {{--<a class="btn btn-white btn-sm btn-rounded "  href="#" data-toggle="modal" data-target="#change_status{{$invoice->id}}"></a>--}}
                                                        </div>
                                                    </td>
                                                    <td>{{$invoice->branch->name}}</td>
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
                                            @endif
                                            @include('invoice.delete')
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="retail" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div class="card shadow">
                        <div class="col-12 my-2">
                            <strong class="my-2">Filter By:</strong>
                            <div class="row filter-row justify-content-between">
                                <div class="col">
                                    <div class="form-group">
                                        <input class="form-control form-control-md  shadow-sm" type="text" id="retail_filter_id" name='id' placeholder="Type Invoice ID">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group ">
                                        <input class="form-control form-control-md shadow-sm" type="text" name=retail_"min" id="retail_min" placeholder="Enter Start Date">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input class="form-control shadow-sm form-control-md" type="text" id="retail_max" name="retail_max" placeholder="Enter End Date">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input class="form-control shadow-sm form-control-md" type="text" id="retail_customer_name" name="retail_customer_name" placeholder="Type Customer Name">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <select class="select form-control-md" id="retail_filter_status">
                                            <option value="" disabled>Select Status</option>
                                            <option value="">All</option>
                                            @foreach($status as $key=>$val)
                                                <option value="{{$val}}"> {{$val}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="float-right mr-3">
                                Total Sale Amount: <strong id="retail_grand"></strong> MMK
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-nowrap mb-0 table-hover" id="retail_invoice">
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
                                        <th>Status</th>
                                        <th>Office Branch</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($invoices as $invoice)
                                        @if($invoice->inv_type=='Retail Sale')
                                            <tr>
                                                @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                                                    <td><a href="{{route('invoices.show',$invoice->id)}}">{{$invoice->invoice_id}}</a></td>
                                                @else
                                                    <td><a href="{{route("customer.invoice_show",$invoice->id)}}" >#{{$invoice->invoice_id}}</a></td>
                                                @endif
                                                <td>{{$invoice->inv_type}}</td>
                                                <td>{{$invoice->invoice_type}}</td>
                                                <td>{{$invoice->customer->name}}</td>
                                                <td>{{$invoice->employee->name}}</td>
                                                <td>{{$invoice->created_at->toFormattedDateString()}}</td>
                                                <td>{{\Illuminate\Support\Carbon::parse($invoice->due_date)->toFormattedDateString()}}</td>
                                                <td>{{$invoice->grand_total}}
                                                    <input type="hidden" class="retail_total" value="{{$invoice->grand_total}}">
                                                </td>
                                                <td>{{$invoice->due_amount}}</td>
                                                <td>
                                                    <div class="dropdown action-label">
                                                        <a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o mr-1"></i>{{$invoice->status}}</a>
                                                        {{--<a class="btn btn-white btn-sm btn-rounded "  href="#" data-toggle="modal" data-target="#change_status{{$invoice->id}}"></a>--}}
                                                    </div>
                                                </td>
                                                <td>{{$invoice->branch->name}}</td>
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
                                        @endif
                                        @include('invoice.delete')
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Total</td>
                                        <td><span id="retail_grand"></span></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('select').select2();
            $('#stock').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]});
        });
        $(document).ready(function () {
            $('#stock_in').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]});
            $('#stock_out').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]});
            $('#whole_invoice').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]});
            $('#retail_invoice').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]});
        });
    </script>
@endsection
