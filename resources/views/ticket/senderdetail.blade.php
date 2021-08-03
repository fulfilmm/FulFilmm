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
                <th>Ticket ID</th>
                <th>Subject</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Created Date</th>
                </thead>
                <tbody>
                @foreach($ticket as $sent_ticket)
                    <tr>
                        <td><a href="{{route('tickets.show',$sent_ticket->id)}}">{{$sent_ticket->ticket_id}}</a></td>
                        <td>{{$sent_ticket->title}}</td>
                        <td style="min-width: 150px;">
                            <a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-{{$sent_ticket->ticket_priority->color}}"></i> {{$sent_ticket->ticket_priority->priority}}</a>

                        </td>
                        <td style="min-width: 150px;">
                            @foreach($status_color as $staus=>$color)
                                @if($staus==$sent_ticket->ticket_status->name)
                                    <a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o mr-1" style="color:{{$color}}"></i>{{$sent_ticket->ticket_status->name}}</a>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            {{$sent_ticket->created_at->toFormattedDateString()}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
