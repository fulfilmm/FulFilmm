@extends('layout.mainlayout')
@section('title','Approval ')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Approval</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Approval</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <form action="{{url('approval/search')}}" method="GET">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" id="title" class="form-control" name="title" placeholder="Type title">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">

                        <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Enter Start Date">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">

                        <input type="text" class="form-control" id="end_date" name="end_date" placeholder="Enter End Date">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <button type="submit" class="btn btn-white btn-md col-12">Search</button>
                    </div>
                </div>
            </div>
        </form>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Target Date</th>
                <th>Request Employee</th>
                <th>Status</th>
                <th>Secondary Approver Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($approvals as $approval)
                <tr>
                    <td><a href="{{route('approvals.show',$approval->id)}}">#{{$approval->approval_id}}</a></td>
                    <td>{{$approval->title}}</td>
                    <td>{{\Carbon\Carbon::parse($approval->target_date)->toFormattedDateString()}}</td>
                    <td>{{$approval->request_emp->name}}</td>
                    <td>{{$approval->state==null ? "N/A" : $approval->state}}</td>
                    <td>{{$approval->secondary_approved ?$approval->secondary_approver->name :"N/A"}}</td>
                    <td><a href="{{route('approvals.show',$approval->id)}}" class="btn btn-outline-info btn-sm la la-eye mr-2"></a><a href="" data-toggle="modal" data-target="#delete{{$approval->id}}" class="btn btn-outline-danger btn-sm la la-trash"></a></td>
                    @include('approval.delete')
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- /Page Content -->
    <!-- Event Modal -->
    <div class="modal custom-modal fade" id="event-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-success submit-btn save-event">Create event</button>
                    <button type="button" class="btn btn-danger submit-btn delete-event" data-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function () {
            'use strict';

            jQuery('#target_date').datetimepicker();
            jQuery('#start_date').datetimepicker();
            jQuery('#end_date').datetimepicker();
        });
    </script>
@endsection
