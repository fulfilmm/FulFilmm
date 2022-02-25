@extends('layout.mainlayout')
@section('title',isset($revenue)?'Revenue':(isset($expense)?'Expense':'Transaction'))
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
                        <th>Date</th>
                        @if(isset($revenue))
                        <th>Invoice ID</th>
                            @elseif(isset($expense))
                            <th>Bill ID</th>
                            @else
                            <th>Invoice ID/Bill ID</th>
                        @endif
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Account</th>
                        <th>Approve</th>
                        <th>Approver Name</th>
                        <th>{{isset($revenue)?'Receiver':(isset($expense)?'Issuer':'Receiver/Issuer')}}</th>
                        <th>Action</th>
                    </tr>

                    </thead>
                    <tbody>
                    @foreach($transactions as $transaction)
                        @if($transaction->type=='Revenue')
                            <tr>
                                <td>
                                    <a href="{{route('transactions.show',$transaction->id)}}">{{\Carbon\Carbon::parse($transaction->revenue->transaction_date)->toFormattedDateString()}}</a>
                                </td>
                                <td>@if($transaction->revenue->invoice_id!=null)@foreach($invoice as $key=>$val)@if($key==$transaction->revenue->invoice_id)<a href="{{$transaction->revenue->invoice_id==null?route('transactions.show',$transaction->id):route('invoices.show',$transaction->revenue->invoice_id)}}">{{$val}}</a> @endif @endforeach @else N/A @endif</td>
                                <td>{{$transaction->revenue->title}}</td>
                                <td>{{number_format($transaction->revenue->amount)}}</td>
                                <td>{{$transaction->type}}</td>
                                <td>{{$transaction->revenue->category}}</td>
                                <td>{{$transaction->account->name??'N/A'}}</td>
                                <td>
                                    @if($transaction->revenue->approve==0)
                                        <a href="{{url('transaction/approve/'.$transaction->revenue->id.'/Revenue')}}" class="btn btn-white btn-white btn-sm">Approve</a>
                                    @else
                                        <button type="button" class="btn btn-success btn-sm disabled">Approved</button>
                                    @endif
                                   </td>
                                <td>@foreach($employees as $key=>$val) {{$key==$transaction->revenue->approver_id?$val:''}}  @endforeach</td>
                                <td>@foreach($employees as $key=>$val) {{$key==$transaction->revenue->emp_id?$val:''}}  @endforeach</td>
                            <td>
                                <a href="{{$transaction->revenue->invoice_id==null?route('transactions.show',$transaction->id):route('invoices.show',$transaction->revenue->invoice_id)}}" class="btn btn-white btn-sm"><i class="la la-eye"></i></a>

                            </td>
                            </tr>
                        @else
                            <tr>
                                <td>
                                    <a href="{{route('transactions.show',$transaction->id)}}">{{\Carbon\Carbon::parse($transaction->expense->transaction_date)->toFormattedDateString()}}</a>
                                </td>
                                <td>
                                    @if($transaction->expense->bill_id!=null)
                                        @foreach($bill as $key=>$val)
                                            @if($key==$transaction->expense->bill_id)
                                                <a href="{{$transaction->expense->bill_id==null?route('transactions.show',$transaction->id):route('bills.show',$transaction->expense->bill_id)}}">{{$val}}</a>
                                            @endif
                                        @endforeach
                                        @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{$transaction->expense->title}}</td>
                                <td>{{number_format($transaction->expense->amount)}}</td>
                                <td><span class="badge" style="background-color: #ff4969">{{$transaction->type}}</span></td>
                                <td>{{$transaction->expense->category}}</td>
                                <td>{{$transaction->account->name}}</td>
                                <td>
                                    @if($transaction->expense->approve==0)
                                    <a href="{{url('transaction/approve/'.$transaction->expense->id.'/Expense')}}" class="btn btn-white btn-white btn-sm ">Approve</a>
                                @else
                                        <button type="button" class="btn btn-success btn-sm disabled">Approved</button>
                                    @endif
                                </td>
                                <td>@foreach($employees as $key=>$val) {{$key==$transaction->expense->approver_id?$val:''}}  @endforeach</td>
                                <td>
                                    <a href="{{route('employees.show',$transaction->expense->emp_id)}}">@foreach($employees as $key=>$val) {{$key==$transaction->expense->emp_id?$val:''}}  @endforeach </a>
                                </td>
                                <td>
                                    <a href="{{$transaction->expense->invoice_id==null?route('transactions.show',$transaction->id):route('invoices.show',$transaction->expense->invoice_id)}}" class="btn btn-white btn-sm"><i class="la la-eye"></i></a>
                                </td>
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