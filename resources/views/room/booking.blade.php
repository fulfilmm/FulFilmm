@extends('layout.mainlayout')
@section('title','Room')
@section('content')

    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Booking Rooms</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Booking Rooms</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#booking"><i class="fa fa-plus"></i> Booking</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table" id="ticket">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Room No</th>
                            <th>Address</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['bookedroom'] as $booking)
                            <tr>
                                <th>#{{$booking->id}}</th>
                                <th>{{$booking->subject}}</th>
                                <td>{{$booking->bookroom->room_no}}</td>
                                <td>{{$booking->bookroom->address}}</td>
                                <td><span class="badge bg-gradient-blue text-white">{{\Carbon\Carbon::parse($booking->start_time)->toFormattedDateString()}}</span>
                                    <span class="badge bg-gradient-info">{{date('h:i a', strtotime(\Carbon\Carbon::parse($booking->start_time)))}}</span>
                                </td>
                                   <td>
                                     <span class="badge bg-danger">{{\Carbon\Carbon::parse($booking->endtime)->toFormattedDateString()}}</span>
                                       <span class="badge bg-gradient-primary">{{date('h:i a', strtotime(\Carbon\Carbon::parse($booking->endtime)))}}</span></td>
                                    <td>
                                        {{$booking->booking_emp->name}}
                                    </td>
                                <td>
                                    <a href="{{url('booking/cancel/'.$booking->id)}}" class="btn btn-white btn-sm">Cancel Booking</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    @include('room.bookingcreate')
    <!-- /Page Content -->
@endsection

