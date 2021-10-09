@extends('layout.mainlayout')
@section('title','Approval')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Approval </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Approval </li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('approvals.create')}}" class="btn add-btn" ><i class="fa fa-plus"></i> Add Approval</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">My Approval Request</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Approval Cc Me</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" style="overflow: auto">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Target Date</th>
                        <th>Request By</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Approver Name</th>
                        <th>2nd Approver</th>
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
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Target Date</th>
                        <th>Request Employee</th>
                        <th>Status</th>
                        <th>Approver Name</th>
                        <th>Secondary Approver Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cc as $data)
                        <tr>
                            <td style="min-width: 100px;"><a href="{{route('approvals.show',$data->id)}}">#{{$data->approval_id}}</a></td>
                            <td style="min-width: 100px;">{{$data->title}}</td>
                            <td style="min-width: 100px;">{{\Carbon\Carbon::parse($data->target_date)->toFormattedDateString()}}</td>
                            <td style="min-width: 100px;">{{$data->request_emp->name}}</td>
                            <td style="min-width: 100px;">{{$data->state==null ? "N/A" : $approval->state}}</td>
                            <td style="min-width: 150px;">{{$data->approver->name}}</td>
                            <td style="min-width: 160px;">{{$data->secondary_approved ?$data->secondary_approver->name :""}}/td>
                            <td style="min-width: 100px;"><a  href="{{route('approvals.show',$data->id)}}" class="btn btn-outline-info btn-sm"><i class="la la-eye"></i></a>
                             @php $approval=$data;@endphp
                                <a href="" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#delete{{$approval->id}}"><i class="la la-trash"></i></a></td>
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
        });
    </script>
@endsection
