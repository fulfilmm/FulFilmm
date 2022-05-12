@extends('layout.mainlayout')
@section('title','Cas Transfer Record')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Cash Transfer Record</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Cash Transfer Record</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <button type="button" data-toggle="modal" data-target="#add_new" class="btn add-btn"><i class="fa fa-plus"></i>
                        Add New Record</button>
                </div>
            </div>
            @include('CashTransferRecord.create')
        </div>
        <div class="col-12" style="overflow: auto">
           <div class="card shadow">
               <div class="col-12 my-2" style="overflow: auto">
                   <table class="table table-hover table-nowrap" id="cashrecord">
                       <thead>
                       <tr>
                           <th>Sender Name</th>
                           <th>Receiver Name</th>
                           <th>Status</th>
                           <th>Amount</th>
                           <th>Sale Manager</th>
                           <th>Finance Manager</th>
                           <th>Description</th>
                           <th>Attachment</th>
                           <th>Send Date</th>
                           <th>Action</th>
                           <th></th>
                           <th></th>
                       </tr>
                       </thead>
                       <tbody>
                       @foreach($transferrecord as $item)
                           <tr>
                               <td>{{$item->employee->name}}</td>
                               <td>{{$item->receiver->name}}</td>
                               <td>{{$item->receipt==1?'Receipted':'Transit'}}</td>
                               <td>{{$item->amount}}</td>
                               <td>{{$item->salemanager->name}}</td>
                               <td>{{$item->financemanager->name}}</td>
                               <td>{{$item->description}}</td>
                               <td>{{$item->attachment??'N/A'}}</td>
                               <td>{{$item->created_at->toFormattedDateString()}}</td>
                               @if($item->receipt==0)
                                   <td> <form action="{{route('moneytransfer.update',$item->id)}}" method="post">
                                           @csrf
                                           @method('PUT')
                                           <input type="hidden" name="receipt" value="1">
                                           <button type="submit" class="btn btn-warning btn-sm">Receipt</button>
                                       </form></td>
                                   <td>  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit{{$item->id}}"><i class="la la-edit"></i></button></td>
                                   <td style="width: 300px">




                                       <form action="{{route('moneytransfer.destroy',$item->id)}}" method="post">
                                           @csrf
                                           @method('delete')
                                           <button type="submit" class="btn btn-danger btn-sm"><i class="la la-trash"></i></button>
                                       </form>
                                       @include('CashTransferRecord.edit')


                                   </td>
                               @else
                                   <td>
                                       <button type="button" class="btn btn-light border btn-sm disabled">Receipt</button>
                                   </td>
                                   <td>  <button type="button" class="btn btn-light border btn-sm disabled"><i class="la la-edit"></i></button></td>
                                   <td style="width: 300px">
                                       <button type="submit" class="btn btn-light border btn-sm disabled"><i class="la la-trash"></i></button>
                                   </td>
                               @endif
                           </tr>
                       @endforeach
                       </tbody>
                   </table>
               </div>
           </div>
        </div>


    </div>
    <!-- /Page Content -->

    <!-- /Page Wrapper -->
    <script>
        $(document).ready(function () {
           $('#cashrecord').DataTable();
        });
    </script>
@endsection