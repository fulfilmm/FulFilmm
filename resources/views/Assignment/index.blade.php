@extends('layout.mainlayout')
@section('name', 'Todo List')
@section('content')
    <!-- Page Header -->
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Todo List</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Todo List</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <div class="bs-offset-main bs-canvas-anim mt-2">
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add Task</button>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped table-nowrap custom-table mb-0 datatable dataTable no-footer"
                                               id="DataTables_Table_0" role="grid"
                                               aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                            <tr role="row">
                                                <th class="checkBox sorting_asc" tabindex="0"
                                                    aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                    aria-sort="ascending" aria-label=": activate to sort column descending" style="width: 35px;">
                                                    <label class="container-checkbox">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Task Name: activate to sort column ascending"
                                                    style="width: 138.594px;">Task Name
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Percent Complete Indicator: activate to sort column ascending"
                                                    style="width: 187.172px;">Percent Complete Indicator
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Responsible User: activate to sort column ascending"
                                                    style="width: 118.766px;">Responsible User
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Due Date: activate to sort column ascending"
                                                    style="width: 64.9219px;">Due Date
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Task Owner: activate to sort column ascending"
                                                    style="width: 80.1562px;">Task Owner
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Status: activate to sort column ascending"
                                                    style="width: 101.922px;">Status
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label=": activate to sort column ascending"
                                                    style="width: 19px;"></th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label=": activate to sort column ascending"
                                                    style="width: 0px;">Priority</th>
                                                <th class="text-end sorting" tabindex="0"
                                                    aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                    aria-label="Actions: activate to sort column ascending"
                                                    style="width: 51.5625px;">Actions
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($todo_list as $todo)
                                            <tr role="row" class="odd">
                                                <td class="checkBox sorting_1">
                                                    <label class="container-checkbox">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <a href="{{route('assignments.show',$todo->id)}}" class="text-decoration-none" >{{$todo->title}}</a>
                                                </td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar {{$todo->progress==100?"bg-success":($todo->progress>=75?"bg-info":($todo->progress>=50?'bg-warning':'bg-danger'))}}" role="progressbar"
                                                             style="width:{{$todo->progress}}%" aria-valuenow="75" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td><a href="{{route('employees.show',$todo->responsible_emp->id)}}">{{$todo->responsible_emp->name}}</a></td>
                                                <td>{{\Carbon\Carbon::parse($todo->end_date)->toFormattedDateString()}}</td>
                                                <td><a href="{{route('employees.show',$todo->owner->id)}}">{{$todo->owner->name}}</a></td>
                                                 <td><button type="button" class="btn btn-sm text-white {{$todo->status=='Not Started'?'gradient-purple':($todo->status=='Working'?"gradient-yellow":
                                                 ($todo->status=='Pending'?"gradient-blue":($todo->status=='Cancel'?'gradient-red':'gradient-green')))}}">{{$todo->status}}</button></td>
                                                <td>
                                                </td>
                                                <td class="checkBox"><span class="{{$todo->priority=='High'?'soft-purple':($todo->priority=='Medium'?'soft-blue':'soft-green')}}">{{$todo->priority}}</span></td>
                                                <td class="text-center">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="{{route('assignments.edit',$todo->id)}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="{{route('assignments.show',$todo->id)}}"><i class="fa fa-eye m-r-5"></i> Show</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#change_process{{$todo->id}}"><i class="fa fa-pencil m-r-5"></i>Edit Percentage</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#change_status{{$todo->id}}"><i class="fa fa-pencil m-r-5"></i>Edit Status</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_client"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                    <div id="change_process{{$todo->id}}" class="modal custom-modal fade" role="dialog">
                                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header border-bottom">
                                                                    <h5 class="modal-title">Finish Percentage</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{route('assignments.update',$todo->id)}}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')

                                                                        <input type="hidden" name="title" value="{{$todo->title}}">
                                                                        <input type="hidden" name="emp_id" value="{{$todo->emp_id}}">
                                                                        <input type="hidden" name="assignee_id" value="{{$todo->assignee_id}}">
                                                                        <input type="hidden" name="end_date" value="{{$todo->end_date}}">
                                                                        <input type="hidden" name="status" value="{{$todo->status}}">
                                                                        <input type="hidden" name="priority" value="{{$todo->priority}}">
                                                                        <div class="form-group">
                                                                            <label for="percentage">Finished Percentage</label>
                                                                            <div class="input-group">
                                                                                <input type="number" class="form-control" name="progress" id="percentage" value="{{$todo->progress}}">
                                                                                <div class="input-group-append">
                                                                                    <button type="button" class="btn btn-white">%</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <button type="submit" class="btn btn-info">Save</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="change_status{{$todo->id}}" class="modal custom-modal fade" role="dialog">
                                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header border-bottom">
                                                                    <h5 class="modal-title">Finish Percentage</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{route('assignments.update',$todo->id)}}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')

                                                                        <input type="hidden" name="title" value="{{$todo->title}}">
                                                                        <input type="hidden" name="emp_id" value="{{$todo->emp_id}}">
                                                                        <input type="hidden" name="assignee_id" value="{{$todo->assignee_id}}">
                                                                        <input type="hidden" name="end_date" value="{{$todo->end_date}}">
                                                                        <input type="hidden" name="progress" value="{{$todo->progress}}">
                                                                        <input type="hidden" name="priority" value="{{$todo->priority}}">
                                                                        <div class="form-group">
                                                                            <label for="status">Status</label>
                                                                            <select name="status" id="status" class="form-control">
                                                                                <option value="Not Started">Not Started</option>
                                                                                <option value="Working">Working</option>
                                                                                <option value="Pending">Pending</option>
                                                                                <option value="Finished">Finished</option>
                                                                                <option value="Cancel">Cancel</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <button type="submit" class="btn btn-info">Save</button>
                                                                        </div>
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
                    </div>
                </div>
            </div>
        </div>
       @include('Assignment.create')
@endsection