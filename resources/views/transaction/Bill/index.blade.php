@extends('layout.mainlayout')
@section('title',$type)
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">{{$type}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Accounting</li>
                        <li class="breadcrumb-item active">{{$type}}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
                <div class="col-12 my-3" style="overflow: auto">
                    <table class="table table-hover table-nowrap" id="bills">
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
                                <th>{{$bill->invoice_id??'N/A'}}</th>
                                <td>{{$bill->payment_method}}</td>
                                <td>{{$bill->status}}</td>
                                <td>{{$bill->grand_total}}</td>
                                <td>{{$bill->grand_total - $bill->due_amount}}</td>
                                <td>{{$bill->due_amount}}</td>
                                <td>
                                    <div class="row">
                                        <a href="{{route('bills.show',$bill->id)}}"
                                           class="btn btn-white btn-sm mr-1"><i class="fa fa-eye"></i></a>
                                        {{--<a href="{{route('bills.edit',$bill->id)}}" class="btn btn-success btn-sm mr-1"><i class="fa fa-edit"></i></a>--}}
                                        <form action="{{route('bills.destroy',$bill->id)}}" method="post">
                                            @csrf @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm mr-1"><i
                                                        class="fa fa-trash"></i></button>
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
    <script>
        $(document).ready(function () {
           $('#bills').DataTable({
               dom: 'Bfrtip',
               buttons: [
                   'copy', 'csv', 'excel', 'pdf', 'print'
               ],
               "order": [[ 0, "desc" ]]
           });
        });
    </script>
@endsection