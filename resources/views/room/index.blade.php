@extends('layout.mainlayout')
@section('title','Room')
@section('content')

    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Rooms</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Room</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn shadow-sm" data-toggle="modal" data-target="#add_room"><i class="fa fa-plus"></i> Add Room</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="card shadow">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table" id="ticket">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Room No</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rooms as $room)
                            <tr>
                                <th>#{{$room->id}}</th>
                                <td>{{$room->room_no}}</td>
                                <td>{{$room->address}}</td>
                                <td>
                                    <a href="{{route('rooms.edit',$room->id)}}" class="btn btn-white btn-sm"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('booking')}}" class="btn btn-white btn-sm"><i class="fa fa-eye text-primary"></i></a>
                                    <a href="" class="btn btn-white btn-sm"><i class="fa fa-trash text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('room.create')
    <!-- /Page Content -->
@endsection

