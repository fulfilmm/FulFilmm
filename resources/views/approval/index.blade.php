@extends('layout.mainlayout')
@section('title','Requestation')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Requestation</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Requestation</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('approvals.create')}}" class="btn add-btn" ><i class="fa fa-plus"></i> Add Requestation</a>
                </div>
            </div>
            <form action="{{url('requestation/search')}}" method="GET">
                @csrf
                <div class="row mt-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" id="title" class="form-control shadow-sm" name="title" placeholder="Type title">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">

                            <input type="text" class="form-control shadow-sm" id="start_date" name="start_date" placeholder="Enter Start Date">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">

                            <input type="text" class="form-control shadow-sm" id="end_date" name="end_date" placeholder="Enter End Date">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-white btn-md col-12 shadow-sm">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /Page Header -->
        <div class="card shadow">
            <div class="col-12" style="overflow: auto">
                <table class="table table-hover table-nowrap">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Target Date</th>
                        <th>Request By</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Approver Name</th>
                        <th>Secondary Approver</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($approvals as $approval)
                        <tr>
                            <td style="min-width: 100px;"><a href="{{route('approvals.show',$approval->id)}}">#{{$approval->approval_id}}</a></td>
                            <td style="min-width: 100px;">{{$approval->title}}</td>
                            <td style="min-width: 120px;">{{\Carbon\Carbon::parse($approval->target_date)->toFormattedDateString()}}</td>
                            <td style="min-width: 150px;">{{$approval->request_emp->name}}</td>
                            <td style="min-width: 100px;">{{$approval->state==null ? "N/A" : $approval->state}}</td>
                            <td>{{$approval->type}}</td>
                            <td style="min-width: 150px;">{{$approval->approver->name}}</td>
                            <td style="min-width: 160px;">{{$approval->secondary_approved ? $approval->secondary_approver->name :"N/A"}}</td>
                            <td style="min-width: 100px;"><a href="{{route('approvals.show',$approval->id)}}" class="btn btn-outline-info btn-sm la la-eye mr-2"></a><a href="" data-toggle="modal" data-target="#delete{{$approval->id}}" class="btn btn-outline-danger btn-sm la la-trash"></a></td>
                            @include('approval.delete')
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <!-- Add Event Modal -->
    <!-- /Add Event Modal -->
    <script>
        jQuery(document).ready(function () {
            'use strict';

            jQuery('#target_date').datetimepicker();
            jQuery('#start_date').datetimepicker();
            jQuery('#end_date').datetimepicker();
        });
    </script>
@endsection
