@extends('layout.mainlayout')
@section('title','Expense Report')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="card shadow">
            <div class="col-12 my-3">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="float-right"><a href="{{url('reports')}}" class="btn btn-danger btn-sm rounded-circle"><i class="fa fa-close"></i></a></div>
                            <h3 class="page-title">Expense Report</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>

                                <li class="breadcrumb-item active"><a href="{{url('reports')}}">Report</a></li>
                                <li class="breadcrumb-item active">Expense Report</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <form action="{{url('expense/report')}}" method="GET">
                    @csrf
                    <div class="row">
                        {{--<div class="col">--}}
                        {{--<div class="form-group">--}}
                        {{--<label for="branch">Branch</label>--}}
                        {{--<select name="branch_id" id="branch" class="form-control">--}}
                        {{--<option value="">All</option>--}}
                        {{--@foreach($branch as $key=>$val)--}}
                        {{--<option value="{{$key}}" {{$key==$search_branch?'selected':''}}>{{$val}}</option>--}}
                        {{--@endforeach--}}
                        {{--</select>--}}
                        {{--</div>--}}
                        {{--</div>--}}
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
                <div class="table-responsive my-3 col-12">
                    <table class="table " id="expense">
                        <thead>
                        <tr>
                            <th style="min-width: 50px;">Code</th>
                            <th style="min-width: 150px;">Account</th>
                            <th style="min-width: 150px;">Date</th>
                            <th style="min-width: 50px;">Bill ID</th>
                            <th style="min-width: 150px;">Title</th>
                            <th style="min-width: 150px;">Amount</th>
                            <th style="min-width: 150px;">Supplier</th>
                            <th style="min-width: 150px;">Category</th>
                            <th style="min-width: 50px;">Status</th>
                            <th style="min-width: 150px;">Approver Name</th>
                            <th style="min-width: 150px;">Issuer</th>
                        </tr>

                        </thead>
                        <tbody>
                                            {{--@dd($expenses)--}}
                        @foreach($expenses as $transaction)
                            <tr>
                                <td>{{$transaction->account->code}}</td>
                                <td>{{$transaction->account->code.'-'.$transaction->account->name??'N/A'}}</td>
                                <td>
                                    {{\Carbon\Carbon::parse($transaction->transaction_date)->toFormattedDateString()}}
                                </td>
                                <td>
                                    @if($transaction->bill_id!=null)
                                        <a href="{{route('bills.show',$transaction->bill_id)}}">{{$transaction->bill->bill_id}}</a>@else
                                        N/A @endif</td>

                                <td>{{$transaction->title}}</td>
                                <td>{{number_format($transaction->amount)}}</td>
                                <td>{{$transaction->supplier->name??'N/A'}}</td>
                                <td>{{$transaction->cat->name}}</td>
                                <td>
                                    @if($transaction->approve==0)
                                        Waiting To Confirm
                                    @else
                                       Confirmed
                                    @endif
                                </td>
                                <td>{{$transaction->approver->name}}</td>
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
            $('#expense').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
        });
    </script>
@endsection