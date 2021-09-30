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
                    <h3 class="page-title">Approval Request</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Approval Request</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_event"><i class="fa fa-plus"></i> Add Approval</a>
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
                        <td style="min-width: 150px;">{{$approval->approver->name}}</td>
                        <td style="min-width: 160px;">{{$approval->secondary_approved ? $approval->secondary_approver->name :"N/A"}}/td>
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
    <div id="add_event" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Approval</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('approvals.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="approval_title">Title<span class="text-danger">*</span></label>
                                    <input class="form-control"  type="text" name="title" id="approval_title" value="{{ old('title') }}">
                                    @error('title')
                                    {{-- <span class="invalid-feedback" role="alert"> --}}
                                    <span class="text-danger">{{ $message }}</span>
                                    {{-- </span> --}}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="target_date">Target Date <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="target_date" id="target_date" value="{{ old('target_date') }}">
                                    @error('target_date')
                                    {{-- <span class="invalid-feedback" role="alert"> --}}
                                    <span class="text-danger">{{ $message }}</span>
                                    {{-- </span> --}}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="approver" class="control-label">Approver Name <span class="text-danger">*</span></label>
                                    <select class="select form-control" name="approve_id" id="approver" >
                                        @foreach($all_emp as $emp)
                                            @if($emp->role->name=='Manager'||$emp->role->name=='CEO')
                                                <option {{ old('approve_id') == $emp->id ? "selected" : "" }} value="{{$emp->id}}">{{$emp->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="secondary" class="control-label">Secondary Request Name(Optional)</label>
                                    <select class="select form-control" name="secondary_id" id="secondary">
                                        <option disabled selected>Select Secondary Approver</option>
                                        @foreach($all_emp as $emp)
                                            @if($emp->role->name=='Manager'||$emp->role->name=='CEO')
                                                <option value="{{$emp->id}}">{{$emp->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cc">CC</label>
                            <select name="cc[]" id="cc" class="select" multiple>
                                @foreach($all_emp as $emp)
                                    @if($emp->id != \Illuminate\Support\Facades\Auth::guard('employee')->user()->id)
                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="desc">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="desc" name="description"></textarea>
                            @error('description')
                            {{-- <span class="invalid-feedback" role="alert"> --}}
                            <span class="text-danger">{{ $message }}</span>
                            {{-- </span> --}}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="resume" class="control-label">Upload Document Files(Allow Multiple Select)</label>
                                <input type="file" class="form-control" name="doc_file[]" id="fileupload"  multiple/>
                            @error('doc_file')
                            {{-- <span class="invalid-feedback" role="alert"> --}}
                            <strong class="text-danger">{{ $message }}</strong>
                            {{-- </span> --}}
                            @enderror
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Event Modal -->
    <script>
        jQuery(document).ready(function () {
            'use strict';

            jQuery('#target_date').datetimepicker();
        });
    </script>
@endsection
