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
                            <div class="float-right"><a href="{{url('reports')}}" class="btn btn-danger btn-sm rounded-circle"><i class="la la-close"></i></a></div>
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
                <div class="table-responsive my-3 col-12" style="overflow: auto">
                    <table class="table " id="revenue">
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Account</th>
                            <th>Date</th>
                            <th>Invoice ID</th>
                            <th>Title</th>
                            <th>Amount</th>
                            <th>Receivable Amount</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Receiver</th>
                        </tr>

                        </thead>
                        <tbody>
                        @foreach($receivable as $transaction)
                            <tr>
                                <td>{{$transaction->account->code}}</td>
                                <td>{{$transaction->account->code.'-'.$transaction->account->name??'N/A'}}</td>
                                <td>
                                    {{\Carbon\Carbon::parse($transaction->transaction_date)->toFormattedDateString()}}
                                </td>
                                <td>@if($transaction->invoice_id!=null)<a href="{{route('invoices.show',$transaction->invoice->id)}}">{{$transaction->invoice->invoice_id}}</a>@else N/A @endif</td>
                                <td>{{$transaction->title}}</td>
                                <td>{{number_format($transaction->amount)}}</td>
                                <td>{{$transaction->due_amount}}</td>
                                <td>{{$transaction->cat->name}}</td>
                                <td>
                                    @if($transaction->approve==0)
                                        Pending
                                    @else
                                        <button type="button" class="btn btn-success btn-sm disabled">Confirmed</button>
                                    @endif
                                </td>
                                <td>{{$transaction->employee->name}}</td>
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
            $('#revenue').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
        });
    </script>
@endsection