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
        <!-- Search Filter -->
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3 offset-md-6 col-lg-3 offset-lg-6 col-xl-2 offset-xl-8 col-12">
                <div class="form-group">
                    <label class="focus-label">From</label>
                    <input type="text" id="min" class="form-control floating " name="min">

                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group">
                    <label >To</label>
                    <input type="text" class="form-control floating " id="max" name="max">

                </div>
            </div>
        </div>
        <!-- /Search Filter -->
        <div class="row">

            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table" id="room_booking">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Room No</th>
                            <th>Address</th>
                            <th>Date</th>
                            <th>Time</th>
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
                                </td>
                                   <td>
                                       <span class="badge bg-gradient-info">{{date('h:i a', strtotime(\Carbon\Carbon::parse($booking->start_time)))}}</span> -
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
    <script>
        $(document).ready(function(){
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = $('#min').datepicker("getDate");
                    var max = $('#max').datepicker("getDate");
                    var startDate = new Date(data[4]);
                    if (min == null && max == null) { return true; }
                    if (min == null && startDate <= max) { return true;}
                    if(max == null && startDate >= min) {return true;}
                    if (startDate <= max && startDate >= min) { return true; }
                    return false;
                }
            );

            $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            var table = $('#room_booking').DataTable({searching: false});

            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                table.draw();
            });
        });
    </script>
    <!-- /Page Content -->
@endsection

