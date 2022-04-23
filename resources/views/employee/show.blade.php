@extends('layout.mainlayout')
@section('title','Profile')
@section('content')
    <link rel="stylesheet" href="{{url(asset('customercss/customershow.css'))}}">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <form action="{{route('employees.show',$employee->id)}}" method="get">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="start">Start Date</label>
                                    <input type="date" class="form-control" name="start" value="{{\Carbon\Carbon::parse($start)->format('Y-m-d')}}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="end">End Date</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="end" value="{{\Carbon\Carbon::parse($end)->format('Y-m-d')}}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-secondary border"><i class="la la-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    <a href="#"><img src="{{$employee->profile_img!=null? url(asset('img/profiles/'.$employee->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar chat-avatar-sm"></a>
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="profile-info-left">
                                            <h3 class="user-name m-t-0 mb-0">{{$employee->name}}</h3>
                                            <small class="text-muted">{{$employee->department->name}}</small>
                                            <div class="staff-id">Employee ID : {{$employee->empid}}</div>
                                            <div class="staff-id">Gender : {{$employee->gender}}</div>
                                            <div class="staff-id">Position : {{$employee->role->name}}</div>
                                            <div class="staff-id">Branch : {{$employee->branch->name??'N/A'}}</div>
                                            <div class="staff-id">Region : {{$employee->region->name??'N/A'}}</div>
                                            <div class="small doj text-muted">Date of Join : {{\Carbon\Carbon::parse($employee->join_date)->toFormattedDateString()}}</div>
                                            <div class="row">
                                                <div class="staff-msg mr-2"><a class="btn btn-custom" href="#">Send Message</a></div>
                                                <div class="staff-msg"><a class="btn btn-primary" href="{{route('employees.edit',$employee->id)}}">Edit</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Phone:</div>
                                                <div class="text"><a href="">{{$employee->phone}}</a></div>
                                            </li>
                                            <li>
                                                <div class="title">Email:</div>
                                                <div class="text"><a href="">{{$employee->email}}</a></div>
                                            </li>
                                            <li>
                                                <div class="title">Birthday:</div>
                                                <div class="text">{{isset($employee->dob)?\Carbon\Carbon::parse($employee->dob)->toFormattedDateString():'yyyy-mm-dd'}}</div>
                                            </li>
                                            <li>
                                                <div class="title">Address:</div>
                                                <div class="text">{{$employee->address??'N/A'}}</div>
                                            </li>
                                            <li>
                                                <div class="title">Gender:</div>
                                                <div class="text">{{$employee->gender??'N/A'}}</div>
                                            </li>
                                            <li>
                                                <div class="title">Reports to:</div>
                                                <div class="text">
                                                    <div class="avatar-box">
                                                        <div class="avatar avatar-xs">
                                                            {{--@dd($employee->reportperson)--}}
                                                            <img src="{{$employee->reportperson!=null? url(asset('img/profiles/'.$employee->reportperson->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="">
                                                        </div>
                                                    </div>
                                                    <a href="profile">
                                                       {{$employee->reportperson->name??'N/A'}}
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Total Expense:</div>
                                                <div class="text">
                                                    {{$expenses[0]->total??0}} MMK
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Total Sale:</div>
                                                <div class="text">
                                                    {{$grand_total[0]->total??0}} MMK
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Cas in transit:</div>
                                                <div class="text">
                                                    {{$employee->amount_in_hand??0}} MMK
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Receivable:</div>
                                                <div class="text">
                                                    {{$receivable[0]->total??0}} MMK
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="pro-edit"><a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card tab-box">
            <div class="row user-tabs">
                <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                    <ul class="nav nav-tabs nav-tabs-bottom">
                        <li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link active">Sale History</a></li>
                        <li class="nav-item"><a href="#emp_projects" data-toggle="tab" class="nav-link">Projects</a></li>
                        <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Bank & Statutory <small class="text-danger">(Admin Only)</small></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tab-content">

            <!-- Profile Info Tab -->
            <div id="emp_profile" class="pro-overview tab-pane fade show active">
                <div class="card shadow">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0 table-hover" id="invoice">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Invoice Number</th>
                                    <th>Client</th>
                                    <th>Created Date</th>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    <th>Receivable Amount</th>
                                    <th>Status</th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td>{{$invoice->created_at->toFormattedDateString()}}</td>
                                        <td><a href="{{route('invoices.show',$invoice->id)}}">#{{$invoice->invoice_id}}</a></td>
                                        <td>{{$invoice->customer->name}}</td>
                                        <td>{{$invoice->created_at->toFormattedDateString()}}</td>
                                        <td>{{\Illuminate\Support\Carbon::parse($invoice->due_date)->toFormattedDateString()}}</td>
                                        <td>{{$invoice->grand_total}}</td>
                                        <td>{{$invoice->due_amount}}</td>
                                        <td>
                                          @if($invoice->cancel==1)
                                              Cancel
                                              @else
                                                {{$invoice->status}}
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    {{--                                                    <a class="dropdown-item" href="{{route("invoices.edit",$invoice->id)}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
                                                    <a class="dropdown-item" href="{{route("invoices.show",$invoice->id)}}"><i class="fa fa-eye m-r-5"></i> View</a>
                                                    {{--                                                    <a class="dropdown-item" href="#"><i class="fa fa-file-pdf-o m-r-5"></i> Download</a>--}}
                                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#delete{{$invoice->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
            <!-- /Profile Info Tab -->

            <!-- Projects Tab -->
            <div class="tab-pane fade" id="emp_projects">
                <div class="row">
                    <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown profile-action">
                                    <a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a data-target="#edit_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a data-target="#delete_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                    </div>
                                </div>
                                <h4 class="project-title"><a href="project-view">Office Management</a></h4>
                                <small class="block text-ellipsis m-b-15">
                                    <span class="text-xs">1</span> <span class="text-muted">open tasks, </span>
                                    <span class="text-xs">9</span> <span class="text-muted">tasks completed</span>
                                </small>
                                <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. When an unknown printer took a galley of type and
                                    scrambled it...
                                </p>
                                <div class="pro-deadline m-b-15">
                                    <div class="sub-title">
                                        Deadline:
                                    </div>
                                    <div class="text-muted">
                                        17 Apr 2019
                                    </div>
                                </div>
                                <div class="project-members m-b-15">
                                    <div>Project Leader :</div>
                                    <ul class="team-members">
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="Jeffery Lalor"><img alt="" src="img/profiles/avatar-16.jpg"></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="project-members m-b-15">
                                    <div>Team :</div>
                                    <ul class="team-members">
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="John Doe"><img alt="" src="img/profiles/avatar-02.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="Richard Miles"><img alt="" src="img/profiles/avatar-09.jpg"></a></a>
                                        </li>
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="John Smith"><img alt="" src="img/profiles/avatar-10.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="Mike Litorus"><img alt="" src="img/profiles/avatar-05.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" class="all-users">+15</a>
                                        </li>
                                    </ul>
                                </div>
                                <p class="m-b-5">Progress <span class="text-success float-right">40%</span></p>
                                <div class="progress progress-xs mb-0">
                                    <div style="width: 40%" title="" data-toggle="tooltip" role="progressbar" class="progress-bar bg-success" data-original-title="40%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown profile-action">
                                    <a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a data-target="#edit_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a data-target="#delete_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                    </div>
                                </div>
                                <h4 class="project-title"><a href="project-view">Project Management</a></h4>
                                <small class="block text-ellipsis m-b-15">
                                    <span class="text-xs">2</span> <span class="text-muted">open tasks, </span>
                                    <span class="text-xs">5</span> <span class="text-muted">tasks completed</span>
                                </small>
                                <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. When an unknown printer took a galley of type and
                                    scrambled it...
                                </p>
                                <div class="pro-deadline m-b-15">
                                    <div class="sub-title">
                                        Deadline:
                                    </div>
                                    <div class="text-muted">
                                        17 Apr 2019
                                    </div>
                                </div>
                                <div class="project-members m-b-15">
                                    <div>Project Leader :</div>
                                    <ul class="team-members">
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="Jeffery Lalor"><img alt="" src="img/profiles/avatar-16.jpg"></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="project-members m-b-15">
                                    <div>Team :</div>
                                    <ul class="team-members">
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="John Doe"><img alt="" src="img/profiles/avatar-02.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="Richard Miles"><img alt="" src="img/profiles/avatar-09.jpg"></a></a>
                                        </li>
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="John Smith"><img alt="" src="img/profiles/avatar-10.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="Mike Litorus"><img alt="" src="img/profiles/avatar-05.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" class="all-users">+15</a>
                                        </li>
                                    </ul>
                                </div>
                                <p class="m-b-5">Progress <span class="text-success float-right">40%</span></p>
                                <div class="progress progress-xs mb-0">
                                    <div style="width: 40%" title="" data-toggle="tooltip" role="progressbar" class="progress-bar bg-success" data-original-title="40%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown profile-action">
                                    <a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a data-target="#edit_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a data-target="#delete_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                    </div>
                                </div>
                                <h4 class="project-title"><a href="project-view">Video Calling App</a></h4>
                                <small class="block text-ellipsis m-b-15">
                                    <span class="text-xs">3</span> <span class="text-muted">open tasks, </span>
                                    <span class="text-xs">3</span> <span class="text-muted">tasks completed</span>
                                </small>
                                <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. When an unknown printer took a galley of type and
                                    scrambled it...
                                </p>
                                <div class="pro-deadline m-b-15">
                                    <div class="sub-title">
                                        Deadline:
                                    </div>
                                    <div class="text-muted">
                                        17 Apr 2019
                                    </div>
                                </div>
                                <div class="project-members m-b-15">
                                    <div>Project Leader :</div>
                                    <ul class="team-members">
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="Jeffery Lalor"><img alt="" src="img/profiles/avatar-16.jpg"></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="project-members m-b-15">
                                    <div>Team :</div>
                                    <ul class="team-members">
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="John Doe"><img alt="" src="img/profiles/avatar-02.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="Richard Miles"><img alt="" src="img/profiles/avatar-09.jpg"></a></a>
                                        </li>
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="John Smith"><img alt="" src="img/profiles/avatar-10.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="Mike Litorus"><img alt="" src="img/profiles/avatar-05.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" class="all-users">+15</a>
                                        </li>
                                    </ul>
                                </div>
                                <p class="m-b-5">Progress <span class="text-success float-right">40%</span></p>
                                <div class="progress progress-xs mb-0">
                                    <div style="width: 40%" title="" data-toggle="tooltip" role="progressbar" class="progress-bar bg-success" data-original-title="40%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown profile-action">
                                    <a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a data-target="#edit_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a data-target="#delete_project" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                    </div>
                                </div>
                                <h4 class="project-title"><a href="project-view">Hospital Administration</a></h4>
                                <small class="block text-ellipsis m-b-15">
                                    <span class="text-xs">12</span> <span class="text-muted">open tasks, </span>
                                    <span class="text-xs">4</span> <span class="text-muted">tasks completed</span>
                                </small>
                                <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. When an unknown printer took a galley of type and
                                    scrambled it...
                                </p>
                                <div class="pro-deadline m-b-15">
                                    <div class="sub-title">
                                        Deadline:
                                    </div>
                                    <div class="text-muted">
                                        17 Apr 2019
                                    </div>
                                </div>
                                <div class="project-members m-b-15">
                                    <div>Project Leader :</div>
                                    <ul class="team-members">
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="Jeffery Lalor"><img alt="" src="img/profiles/avatar-16.jpg"></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="project-members m-b-15">
                                    <div>Team :</div>
                                    <ul class="team-members">
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="John Doe"><img alt="" src="img/profiles/avatar-02.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="Richard Miles"><img alt="" src="img/profiles/avatar-09.jpg"></a></a>
                                        </li>
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="John Smith"><img alt="" src="img/profiles/avatar-10.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="Mike Litorus"><img alt="" src="img/profiles/avatar-05.jpg"></a>
                                        </li>
                                        <li>
                                            <a href="#" class="all-users">+15</a>
                                        </li>
                                    </ul>
                                </div>
                                <p class="m-b-5">Progress <span class="text-success float-right">40%</span></p>
                                <div class="progress progress-xs mb-0">
                                    <div style="width: 40%" title="" data-toggle="tooltip" role="progressbar" class="progress-bar bg-success" data-original-title="40%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Projects Tab -->

            <!-- Bank Statutory Tab -->
            <div class="tab-pane fade" id="bank_statutory">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title"> Basic Salary Information</h3>
                        <form>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Salary basis <span class="text-danger">*</span></label>
                                        <select class="select">
                                            <option>Select salary basis type</option>
                                            <option>Hourly</option>
                                            <option>Daily</option>
                                            <option>Weekly</option>
                                            <option>Monthly</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Salary amount <small class="text-muted">per month</small></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Type your salary amount" value="0.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Payment type</label>
                                        <select class="select">
                                            <option>Select payment type</option>
                                            <option>Bank transfer</option>
                                            <option>Check</option>
                                            <option>Cash</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h3 class="card-title"> PF Information</h3>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">PF contribution</label>
                                        <select class="select">
                                            <option>Select PF contribution</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">PF No. <span class="text-danger">*</span></label>
                                        <select class="select">
                                            <option>Select PF contribution</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Employee PF rate</label>
                                        <select class="select">
                                            <option>Select PF contribution</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Additional rate <span class="text-danger">*</span></label>
                                        <select class="select">
                                            <option>Select additional rate</option>
                                            <option>0%</option>
                                            <option>1%</option>
                                            <option>2%</option>
                                            <option>3%</option>
                                            <option>4%</option>
                                            <option>5%</option>
                                            <option>6%</option>
                                            <option>7%</option>
                                            <option>8%</option>
                                            <option>9%</option>
                                            <option>10%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Total rate</label>
                                        <input type="text" class="form-control" placeholder="N/A" value="11%">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Employee PF rate</label>
                                        <select class="select">
                                            <option>Select PF contribution</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Additional rate <span class="text-danger">*</span></label>
                                        <select class="select">
                                            <option>Select additional rate</option>
                                            <option>0%</option>
                                            <option>1%</option>
                                            <option>2%</option>
                                            <option>3%</option>
                                            <option>4%</option>
                                            <option>5%</option>
                                            <option>6%</option>
                                            <option>7%</option>
                                            <option>8%</option>
                                            <option>9%</option>
                                            <option>10%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Total rate</label>
                                        <input type="text" class="form-control" placeholder="N/A" value="11%">
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h3 class="card-title"> ESI Information</h3>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">ESI contribution</label>
                                        <select class="select">
                                            <option>Select ESI contribution</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">ESI No. <span class="text-danger">*</span></label>
                                        <select class="select">
                                            <option>Select ESI contribution</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Employee ESI rate</label>
                                        <select class="select">
                                            <option>Select ESI contribution</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Additional rate <span class="text-danger">*</span></label>
                                        <select class="select">
                                            <option>Select additional rate</option>
                                            <option>0%</option>
                                            <option>1%</option>
                                            <option>2%</option>
                                            <option>3%</option>
                                            <option>4%</option>
                                            <option>5%</option>
                                            <option>6%</option>
                                            <option>7%</option>
                                            <option>8%</option>
                                            <option>9%</option>
                                            <option>10%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Total rate</label>
                                        <input type="text" class="form-control" placeholder="N/A" value="11%">
                                    </div>
                                </div>
                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Bank Statutory Tab -->

        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#invoice').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
        });
    </script>
@endsection