@extends("layout.mainlayout")
@section('title','Office Branch')
@section("content")
    <style>
        #whole_invoice_filter,#retail_invoice_filter{
            visibility: hidden;
        }
    </style>
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Office</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Office Branch</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <button type="button" data-toggle="modal" data-target="#add_emp" class="btn btn-primary rounded-pill" >Add Employee</button>
                    <div id="add_emp" class="modal custom-modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content">
                                <div class="modal-header border-bottom">
                                    <h5 class="modal-title">Add Employee</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('empadd.office')}}" method="post">
                                        @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="branch_id" value="{{$branch->id}}">
                                           <div class="form-group">
                                               <label for="emp">Employee</label>
                                               <select name="emp_id[]" id="emp" class="form-control select2" multiple style="width: 100%;">
                                                   @foreach($employees as $emp)
                                                       <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                       @endforeach
                                               </select>
                                           </div>
                                        </div>

                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" id="add" class="btn btn-primary">Add</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#branch_info" role="tab" aria-controls="pills-home" aria-selected="true">Office Info</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#memberofbranch" role="tab" aria-controls="pills-profile" aria-selected="false">Employees</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#whole" role="tab" aria-controls="pills-profile" aria-selected="false">Whole Sale Invoice</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#retail" role="tab" aria-controls="pills-profile" aria-selected="false">Retail Sale Invoice</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="branch_info" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="col-12 card shadow">
                    <div class="card-header">Office Branch Information</div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="row my-3">
                                <div class="col-md-6 col-6 my-2">Branch Name</div>
                                <div class="col-md-6 col-6 my-2">: {{$branch->name}}</div>
                                <div class="col-md-6 col-6 my-2">Address</div>
                                <div class="col-md-6 col-6 my-2">: {{$branch->address}}</div>
                                <div class="col-md-6 col-6 my-2">Total Sale Amount</div>
                                <div class="col-md-6 col-6 my-2">: <span id="all_total"></span> MMK </div>
                                <div class="col-md-6 col-6 my-2">Total Employees</div>
                                <div class="col-md-6 col-6 my-2">: {{count($branch_employees)}}</div>
                                <div class="col-md-6 col-6 my-2">Total Warehouses</div>
                                <div class="col-md-6 col-6 my-2">: {{count($warehouse)}}</div>

                            </div>
                        </div>
                        <div class="col-md-6 col-12">

                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="memberofbranch" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="col-12 card shadow">
                    <div class="card-header">
                        Office Branch Employees
                    </div>
                    <table class="table table-hover table-nowrap">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Role</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($branch_employees as $emp)

                                <tr>
                                    <td>{{$emp->name}}</td>
                                    <td>{{$emp->department->name}}</td>
                                    <td>{{$emp->role->name}}</td>
                                    <td></td>
                                </tr>
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
    <script>
        $(document).ready(function(){
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = $('#whole_min').datepicker("getDate");
                    var max = $('#whole_max').datepicker("getDate");
                    var startDate = new Date(data[5]);
                    if (min == null && max == null) { return true; }
                    if (min == null && startDate <= max) { return true;}
                    if(max == null && startDate >= min) {return true;}
                    if (startDate <= max && startDate >= min) { return true; }
                    return false;
                }
            );

            $("#whole_min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            $("#whole_max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            var table = $('#whole_invoice').DataTable();

            // Event listener to the two range filtering inputs to redraw on input
            $('#whole_min, #whole_max').change(function () {
                table.draw();
            });
        });
        $(document).ready(function() {
            $('#whole_filter_id').keyup(function () {
                var table = $('#whole_invoice').DataTable();
                table.column(0).search($(this).val()).draw();

            });
        });
        $(document).ready(function() {
            $('#whole_filter_status').on('change', function () {
                var table = $('#whole_invoice').DataTable();
                table.column(9).search($(this).val()).draw();

            });
        });
        $(document).ready(function() {
            $('#whole_customer_name').keyup(function () {
                var table = $('#whole_invoice').DataTable();
                table.column(3).search($(this).val()).draw();

            });
        });

        $(document).ready(function(){
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = $('#retail_min').datepicker("getDate");
                    var max = $('#retail_max').datepicker("getDate");
                    var startDate = new Date(data[5]);
                    if (min == null && max == null) { return true; }
                    if (min == null && startDate <= max) { return true;}
                    if(max == null && startDate >= min) {return true;}
                    if (startDate <= max && startDate >= min) { return true; }
                    return false;
                }
            );

            $("#retail_min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            $("#retail_max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            var table = $('#retail_invoice').DataTable();

            // Event listener to the two range filtering inputs to redraw on input
            $('#retail_min, #retail_max').change(function () {
                table.draw();
            });
        });
        $(document).ready(function() {
            $('#retail_filter_id').keyup(function () {
                var table = $('#retail_invoice').DataTable();
                table.column(0).search($(this).val()).draw();

            });
        });
        $(document).ready(function() {
            $('#retail_filter_status').on('change', function () {
                var table = $('#retail_invoice').DataTable();
                table.column(9).search($(this).val()).draw();

            });
        });
        $(document).ready(function() {
            $('#retail_customer_name').keyup(function () {
                var table = $('#retail_invoice').DataTable();
                table.column(3).search($(this).val()).draw();

            });
        });
        $(document).ready(function () {
           $('.select2').select2();
            var whole_sum = 0;
            $('.whole_total').each(function () {
                whole_sum += parseFloat($(this).val());
            });
            var retail_sum = 0;
            $('.retail_total').each(function () {
                retail_sum += parseFloat($(this).val());
            });
            var sum_total=whole_sum+retail_sum
            $('#all_total').text(sum_total.toLocaleString('en-US'));
            $('#retail_grand').text(retail_sum.toLocaleString('en-US'));
            $('#whole_grand').text(whole_sum.toLocaleString('en-US'));
        });

    </script>
@endsection