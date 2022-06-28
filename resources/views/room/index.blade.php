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
                            <th>Room No</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rooms as $room)
                            <tr>
                                <td>{{$room->room_no}}</td>
                                <td>{{$room->address}}</td>
                                <td>
                                  <div class="row">
                                      <button type="button" class="btn btn-white btn-sm" data-toggle="modal" data-target="#edit{{$room->id}}"><i class="fa fa-edit"></i></button>
                                      <form action="{{route('rooms.destroy',$room->id)}}" method="post">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-white btn-sm"><i class="fa fa-trash text-danger"></i></button>
                                      </form>
                                  </div>
                                    <div id="edit{{$room->id}}" class="modal custom-modal fade" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header border-bottom">
                                                    <h5 class="modal-title">Edit Room</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('rooms.update',$room->id)}}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="room_no">Room No</label>
                                                            <input type="text" id="room_no" class="form-control" name="room_no" value="{{$room->room_no}}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="address">Address</label>
                                                            <input type="text" id="address" class="form-control" name="address" value="{{$room->address}}" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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
    @include('room.create')
    <!-- /Page Content -->
@endsection

