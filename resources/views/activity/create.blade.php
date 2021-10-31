@extends('layout.mainlayout')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div >
                    <h3 class="page-title">Sale Activities</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('activity.index')}}">Sale Activities</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('approvals.create')}}" class="btn add-btn" ><i class="fa fa-plus"></i> Add Activity</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <form action="{{route('activity.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="activity_type" value="Sale Activity">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_id">Title <span class="text-danger"> * </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="title" placeholder="Enter Title">
                                </div>
                                @error('title')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_id">Customer Name <span class="text-danger"> * </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                    </div>

                                    <select name="customer_id" id="customer_id" class="form-control">
                                        @foreach($customers as $key=>$val)
                                            <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">Type <span class="text-danger"> * </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-list"></i></span>
                                    </div>
                                <select name="type" id="type" class="form-control">
                                    <option value="Call">Call</option>
                                    <option value="Meeting">Meeting</option>
                                    <option value="Visit">Visit</option>
                                    <option value="Other">Other</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="follower">Follower</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user-plus"></i></span>
                                    </div>
                                <select name="follower[]" id="follower" class="form-control" multiple>
                                    @foreach($emps as $emp)
                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                                        @endforeach
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">Date Time <span class="text-danger"> * </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                <input type="text" class="form-control" id="date_time" name="date">
                                </div>
                                @error('date')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Report To <span class="text-danger"> * </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                <select name="report_to" id="report" class="form-control">
                                    @foreach($emps as $emp)
                                        @if($emp->id!=\Illuminate\Support\Facades\Auth::guard('employee')->user()->id && ($emp->role->name=='Manager'||$emp->role->name=='CEO'))
                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Attachment</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-paperclip"></i></span>
                                    </div>
                                <input type="file" name="attachment[]" class="form-control" multiple>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="desc">Description <span class="text-danger"> * </span></label>
                                <textarea name="desc" id="desc" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary ">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('select').select2();
        });
        jQuery(document).ready(function () {
            'use strict';

            jQuery('#date_time').datetimepicker();
        });
        ClassicEditor.create($('#desc')[0], {
            toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
        });
    </script>
    <!-- /Page Content -->

    <!-- /Page Wrapper -->
@endsection