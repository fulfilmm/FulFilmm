@extends('layout.mainlayout')
@section('title','Request For Quotation')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Bills</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Bills</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-12" style="overflow: auto">
                    <table class="table border">
                        <thead>
                        <tr>
                            <th>Bill ID</th>
                            <th>Bill Date</th>
                            <th>Due Date</th>
                            <th>Supplier</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bills as $bill)
                            <tr>
                                <td>{{$bill->bill_id}}</td>
                                <td>{{\Carbon\Carbon::parse($bill->bill_date)->toFormattedDateString()}}</td>
                                <td>{{\Carbon\Carbon::parse($bill->due_date)->toFormattedDateString()}}</td>
                                <td>{{$bill->supplier->name}}</td>
                                <td>{{$bill->grand_total}}</td>
                                <td>
                                    <div class="row">
                                        <a href="{{route('bills.show',$bill->id)}}" class="btn btn-white btn-sm mr-1"><i class="fa fa-eye"></i></a>
                                        <a href="{{route('bills.edit',$bill->id)}}" class="btn btn-success btn-sm mr-1"><i class="fa fa-edit"></i></a>
                                        <form action="{{route('bills.destroy',$bill->id)}}" method="post">
                                            @csrf @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm mr-1"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection