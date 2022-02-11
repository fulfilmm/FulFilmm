@extends('layout.mainlayout')
@section('title','Cash Receive')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Receive</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"> Receive</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
               <div class="col-12 my-3">
                   <table class="table table-nowrap table-hover" id="receive">
                       <thead>
                       <tr>
                           <th>Date</th>
                           <th>Customer</th>
                           <th>Amount</th>
                           <th>Type</th>
                           <th>Receiver</th>
                           <th>Action</th>
                       </tr>
                       </thead>
                       <tbody>
                       @foreach($payment_recieved as $receive)
                           <tr>
                               <td>{{\Carbon\Carbon::parse($receive->receive_date)->toFormattedDateString()}}</td>
                               <td>{{$receive->customer->name}}</td>
                               <td>{{$receive->amount}}</td>
                               <td>{{$receive->type}}</td>
                               <td>{{$receive->employee->name}}</td>
                               <td><div class="row">
                                       <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit{{$receive->id}}"><i class="la la-edit"></i></button>
                                       <form action="{{route('payment_receives.destroy',$receive->id)}}" method="POST">
                                           @method('DELETE')
                                           @csrf
                                           <button type="submit" class="btn btn-danger btn-sm"><i class="la la-trash"></i></button>
                                       </form>
                                   </div></td>
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
            $('#receive').DataTable();
        })
    </script>
    @endsection