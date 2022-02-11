@extends('layout.mainlayout')
@section('title','Requestation Cc')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Requestation Cc</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Requestation Cc</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('approvals.create')}}" class="btn add-btn shadow-sm" ><i class="fa fa-plus"></i> Add Requestation</a>
                </div>
            </div>
            <form action="{{url('requestatioin/search')}}" method="GET">
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
      <div class="card shadow">
          <div class="col-12">
              <table class="table table-hover table-nowrap">
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
                          <td style="min-width: 160px;">{{$data->secondary_approved ?$data->secondary_approver->name :""}}</td>
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
            jQuery('#start_date').datetimepicker();
            jQuery('#end_date').datetimepicker();
        });
    </script>
@endsection
