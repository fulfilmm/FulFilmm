@extends('layout.mainlayout')
@section('title','Ticket')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Tickets</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tickets</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <input type="text" class="form-control floating shadow-sm" id="ticket_id" placeholder="All"
                           value="#">
                    <label class="focus-label">Ticket ID</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <label class="focus-label">Assign Staff</label>
                    <select name="emp_name" class="form-control floating" id="emp_name">
                        <option value="">All</option>
                        @foreach($all_emp as $key=>$val)
                            <option value="{{$val}}">{{$val}}</option>
                        @endforeach
                        <option disabled>Department</option>
                        @foreach($depts as $key=>$val)
                            <option value="{{$val}}">{{$val}}</option>
                        @endforeach
                        <option value="Unassign">Unassign</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select class="select floating" id="status">
                        <option value="">All</option>
                        @foreach($statuses as $key=>$val)
                            <option value="{{$val}}"> {{$val}} </option>
                        @endforeach
                    </select>
                    <label class="focus-label">Status</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select class="select floating" id="priority">
                        <option value="">All</option>
                        @foreach($priorities as $key=>$val)
                            <option value="{{$val}}">{{$val}}</option>
                        @endforeach
                    </select>
                    <label class="focus-label">Priority</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <div>
                        <input type="text" id="min" class="form-control floating shadow-sm" name="min">
                    </div>
                    <label class="focus-label">From</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <div>
                        <input type="text" class="form-control floating shadow-sm" id="max" name="max">
                    </div>
                    <label class="focus-label">To</label>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="table-responsive col-12 my-3">
                        <table class="table" id="ticket">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="min-width: 100px;">Ticket Id</th>
                                <th style="min-width: 150px">Ticket Subject</th>
                                <th style="min-width: 150px">Assigned Staff</th>
                                <th style="min-width: 130px">Created Date</th>
                                <th style="min-width: 150px;">Created Employee</th>
                                <th>Priority</th>
                                <th class="text-center">Status</th>
                                <th style="min-width: 150px;">Last Status Change </th>
                                <th class="text-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($all_tickets as $ticket)
                                <tr>
                                    <td>{{$ticket->id}}</td>
                                    <td><a href="{{route('tickets.show',$ticket->id)}}">#{{$ticket->ticket_id}}</a></td>
                                    <td>{{$ticket->title}}</td>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="#">
                                                @if($ticket->isassign==1)
                                                    @foreach($assign_ticket as $assign_staff)
                                                        @if($assign_staff->ticket_id==$ticket->id && $assign_staff->type_of_assign =="agent")
                                                            <a class="avatar avatar-xs" href=""><img alt="" src="{{url(asset('img/profiles/avatar-10.jpg'))}}"></a>
                                                            {{$assign_staff->agent->name}}
                                                        @elseif($assign_staff->ticket_id==$ticket->id && $assign_staff->type_of_assign =='dept')
                                                            <a class="" href=""><i class="la la-users avatar avatar-xs"></i></a>
                                                            {{$assign_staff->dept->name}}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    Unassign

                                                @endif

                                            </a>
                                        </h2>

                                    </td>
                                    <td>{{$ticket->created_at->toFormattedDateString()}}</td>
                                    <td>{{$ticket->created_by->name}}</td>

                                    <td style="min-width: 150px;">
                                        <a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-{{$ticket->ticket_priority->color}}"></i> {{$ticket->ticket_priority->priority}}</a>
                                    </td>
                                    <td style="min-width: 150px;">
                                        @foreach($status_color as $staus=>$color)
                                            @if($staus==$ticket->ticket_status->name)
                                                <a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o mr-1" style="color:{{$color}}"></i>{{$ticket->ticket_status->name}}</a>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{$ticket->updated_at->diffForHumans()}}</td>
                                    <td class="text-right">
                                        <a href="{{route('tickets.show',$ticket->id)}}" class="btn btn-white btn-sm"><i class="la la-eye"></i></a>
                                        <button type="button" data-toggle="modal" data-target="#delete_ticket{{$ticket->id}}" class="btn btn-danger btn-sm"><i class="la la-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection