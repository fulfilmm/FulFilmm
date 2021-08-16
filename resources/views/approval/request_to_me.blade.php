@extends('layout.mainlayout')
@section('title','Approval Request Me')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Approval Request</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Approval Request To Me</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
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
                    <td>{{$approval->secondary_approved ?$approval->secondary_approver->name :""}}</td>
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
    <!-- /Event Modal -->

    <!-- Add Category Modal-->
    <!-- /Add Category Modal-->
    <!-- /Page Wrapper -->
@endsection
