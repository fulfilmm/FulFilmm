@extends('layout.mainlayout')
@section('title','Expense Claim')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Expense Claim</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item float-right">Expense Claim</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('expenseclaims.create')}}" class="btn btn-white float-right mr-3 mt-3 border-dark rounded-pill" style="box-shadow: white"><i class="fa fa-plus mr-2"></i>New Expense Claim</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="col-12">
                <table class="table table-striped custom-table mb-0 datatable">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Employee</th>
                        <th>Amount</th>
                        <th>Approver</th>
                        <th>Status</th>
                        <th>Is Claim</th>
                        <th>Action</th>
                    </tr>

                    </thead>
                    <tbody>
                    @foreach($expense_claim as $expense)
                    <tr>
                        <td>{{\Carbon\Carbon::parse($expense->date)->toFormattedDateString()}}</td>
                    <td>{{$expense->employee->name}}</td>
                    <td>{{$expense->total}}</td>
                    <td>{{$expense->approver->name}}</td>
                    <td>{{$expense->status}}</td>
                        <td>{{$expense->is_claim?'Yes':'No'}}</td>
                        <td>
                            <a href="" class="btn btn-primary btn-s"><i class="fa fa-edit"></i></a>
                            <a href="{{route('expenseclaims.show',$expense->id)}}" class="btn btn-white btn-s"><i class="fa fa-eye"></i></a>
                            <a href="" class="btn btn-danger btn-s"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
