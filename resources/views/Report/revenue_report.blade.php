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
                            <div class="float-right"><a href="{{url('reports')}}" class="btn btn-danger btn-sm rounded-circle"><i class="fa fa-close"></i></a></div>
                            <h3 class="page-title">Revenue Report</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>

                                <li class="breadcrumb-item active"><a href="{{url('reports')}}">Report</a></li>
                                <li class="breadcrumb-item active">Revenue  Report</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12" style="overflow: auto">
                <form action="{{url('income/report')}}" method="GET">
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
                    <table class="table " id="revenue">
                        <thead>
                        <tr>
                            <th style="width: 150px;">Date</th>
                            <th>InvoiceId</th>
                            <th>Title</th>

                            <th>Category</th>
                            <th style="width: 400px;">Cashier</th>
                            <th style="width: 400px;">Finance Manager</th>
                            <th>Created_by</th>
                            <th>Amount</th>
                        </tr>

                        </thead>
                        <tbody>
                        @foreach($revenues as $transaction)
                            <tr>
                                <td>
                                    {{\Carbon\Carbon::parse($transaction->transaction_date)->toFormattedDateString()}}
                                </td>
                                <td>@if($transaction->invoice_id!=null)<a href="{{route('invoices.show',$transaction->invoice->id)}}">{{$transaction->invoice->invoice_id}}</a>@else N/A @endif</td>
                                <td>{{$transaction->title}}</td>

                                <td>{{$transaction->cat->name}}</td>
                                <td>{{$transaction->branch_cashier->name}}</td>
                                <td>{{$transaction->manager->name}}</td>
                                <td>{{$transaction->employee->name}}</td>
                                <td>{{number_format($transaction->amount)}}</td>
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