@extends('layout.mainlayout')
@section('title','Sale Report')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="card shadow">
            <div class="col-12 my-3">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="float-right"><a href="{{url('reports')}}"
                                                        class="btn btn-danger btn-sm rounded-circle"><i
                                            class="la la-close"></i></a></div>
                            <h3 class="page-title">Receivable Report</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>

                                <li class="breadcrumb-item active"><a href="{{url('reports')}}">Report</a></li>
                                <li class="breadcrumb-item active">Receivable Report</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12" style="overflow: auto">
                <form action="{{route('report.receivable')}}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="branch">Branch</label>
                                <select name="branch_id" id="branch" class="form-control">
                                    @if(\Illuminate\Support\Facades\Auth::guard('employee')->role->name!='Super Admin'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name!='CEO')


                                    @else
                                        <option value="">All</option>
                                    @endif
                                    @foreach($branch as $item)
                                        <option value="{{$item->id}}" {{$item->id==$search_branch?'selected':''}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Start Date</label>
                                <input type="date" class="form-control shadow-sm" name="start"
                                       value="{{$start->format('Y-m-d')}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">End Date</label>
                                <div class="input-group">
                                    <input type="date" class="form-control shadow-sm" name="end"
                                           value="{{$end->format('Y-m-d')}}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-white shadow-sm"><i
                                                    class="la la-search"></i></button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
                <div class="table-responsive my-3 col-12" style="overflow: auto">
                    <table class="table table-nowrap mb-0 table-hover" id="receivable">
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
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($receivable as $invoice)
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
                                            <a class="btn btn-danger btn-sm btn-rounded " href="#"
                                               data-toggle="dropdown"
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
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#receivable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
        });
    </script>
@endsection