@extends('layout.mainlayout')
@section('title','Payable Report')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="card shadow">
            <div class="col-12 my-3">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="float-right"><a href="{{url('reports')}}" class="btn btn-danger btn-sm rounded-circle"><i class="la la-close"></i></a></div>
                            <h3 class="page-title">Payable Report</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>

                                <li class="breadcrumb-item active"><a href="{{url('reports')}}">Report</a></li>
                                <li class="breadcrumb-item active">Payable Report</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12" style="overflow: auto">
                <form action="{{route('report.payable')}}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="branch">Branch</label>
                                <select name="branch_id" id="branch" class="form-control">
                                    <option value="">All</option>
                                    @foreach($branch as $item)
                                        <option value="{{$item->id}}" {{$item->id==$search_branch?'selected':''}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Start Date</label>
                                <input type="date" class="form-control shadow-sm" name="start" value="{{$start->format('Y-m-d')}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">End Date</label>
                                <div class="input-group">
                                    <input type="date" class="form-control shadow-sm" name="end" value="{{$end->format('Y-m-d')}}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-white shadow-sm"><i class="la la-search"></i></button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
                <table class="table table-hover table-nowrap" id="payable">
                    <thead>
                    <tr>
                        <th>Bill ID</th>
                        <th>Bill Date</th>
                        <th>Due Date</th>
                        <th>Supplier</th>
                        <th>Invoice ID</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Paid Amount</th>
                        <th>Due Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bills as $bill)
                        <tr>
                            <td>{{$bill->bill_id}}</td>
                            <td>{{\Carbon\Carbon::parse($bill->bill_date)->toFormattedDateString()}}</td>
                            <td>{{\Carbon\Carbon::parse($bill->due_date)->toFormattedDateString()}}</td>
                            <td>{{$bill->supplier->name??'N/A'}}</td>
                            <th>{{$bill->invoice_id??'N/A'}}</th>
                            <td>{{$bill->payment_method}}</td>
                            <td>{{$bill->status}}</td>
                            <td>{{$bill->grand_total}}</td>
                            <td>{{$bill->grand_total - $bill->due_amount}}</td>
                            <td>{{$bill->due_amount}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#payable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
        });
    </script>
@endsection