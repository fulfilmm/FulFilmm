@extends('layout.mainlayout')
@section('title','Add Revenue')
@section('content')
    <div class="container-fluid">
        <div class="page-header my-3">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">
                            <h3>{{isset($revenue)?'Revenue':(isset($expense)?'Expense':'Transaction')}}</h3>
                        </li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    @if(isset($revenue))
                        <a href="{{route('income.create')}}" class="btn add-btn btn-sm"><i class="fa fa-plus"></i> Add
                            Income</a>
                    @elseif(isset($expense))
                        <a href="{{route('expense.create')}}" class="btn add-btn ml-2 btn-sm"><i class="fa fa-plus"></i>
                            Add Expense</a>
                    @else
                        <a href="{{route('expense.create')}}" class="btn add-btn ml-2 btn-sm"><i class="fa fa-plus"></i>
                            Add Expense</a>
                        <a href="{{route('income.create')}}" class="btn add-btn btn-sm"><i class="fa fa-plus"></i> Add
                            Income</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="card">
            <div class="table-responsive my-3 col-12">
                <table class="table " id="transaction">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Account</th>
                        <th>Description</th>
                    </tr>

                    </thead>
                    <tbody>
                    @foreach($transactions as $transaction)
                        @if($transaction->type=='Revenue')
                            <tr>
                                <td><input type="checkbox" name="check"></td>
                                <td>
                                    <a href="{{$transaction->revenue->invoice_id==null?route('transactions.show',$transaction->id):route('invoices.show',$transaction->revenue->invoice_id)}}">{{\Carbon\Carbon::parse($transaction->revenue->transaction_date)->toFormattedDateString()}}</a>
                                </td>
                                <td>{{number_format($transaction->revenue->amount)}}</td>
                                <td>{{$transaction->type}}</td>
                                <td>{{$transaction->revenue->category}}</td>
                                <td>{{$transaction->account->name}}</td>
                                <td>{{$transaction->revenue->description}}</td>
                            </tr>
                        @else
                            <tr>
                                <td><input type="checkbox" name="check"></td>
                                <td>
                                    <a href="{{route('transactions.show',$transaction->id)}}">{{\Carbon\Carbon::parse($transaction->expense->transaction_date)->toFormattedDateString()}}</a>
                                </td>
                                <td>{{number_format($transaction->expense->amount)}}</td>
                                <td>{{$transaction->type}}</td>
                                <td>{{$transaction->expense->category}}</td>
                                <td>{{$transaction->account->name}}</td>
                                <td>{{$transaction->expense->description}}</td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{--<script src="{{url(asset('js/jquery_print.js'))}}"></script>--}}
    {{--<script src="{{url(asset('js/datatable_button.js'))}}"></script>--}}
    <script>
        $(document).ready(function () {
            $('#transaction').DataTable();
            $('.dataTables_filter input').remove('form-control');
            $('.dataTables_filter input').addClass('rounded');
        })
    </script>
@endsection