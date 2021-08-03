@extends('layout.mainlayout')
@section('title','All Ticket Sender')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Tickets Sender</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('tickets.index')}}">Tickets</a></li>
                        <li class="breadcrumb-item active">Tickets Sender</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12">
            <table class="table">
                <thead>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Number Of Sent Ticket</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach($sender_info as $sender)
                        <tr>
                            <td>{{$sender->name}}</td>
                            <td>{{$sender->phone}}</td>
                            <td>
                                @php $numberOfticket=0;@endphp
                                @foreach($ticket as $sent_ticket)
                                    @php $sent_ticket->customer_id==$sender->id?$numberOfticket+=1:''@endphp
                                @endforeach
                                {{$numberOfticket}}&nbsp&nbsp{{$numberOfticket>1?'Tickets':'Ticket'}}
                            </td>
                            <td>
                                <a href="{{route('senders.show',$sender->id)}}" class="btn btn-white btn-sm"><i class="la la-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
