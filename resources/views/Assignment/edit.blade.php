@extends('layout.mainlayout')
@section('name', 'EditTodo List')
@section('content')
    <!-- Page Header -->
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Todo List</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Todo List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <form action="{{route('assignments.update',$todo_list->id)}}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="assignee_id" value="{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->id}}">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" id="title" class="form-control" name="title" value="{{$todo_list->title}}" required>
                                @error('title')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        @if($role=='CEO'||$role=='Super Admin'||$role=='Sales Manager'||$role=='Finance Manager'||$role=='General Manager'||$role=='Stock Manager'||$role=='HR Manager'
                        ||$role=='Customer Service Manager'||$role=='Car Admin')
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="emp">Responsible Employee</label>
                                    <select name="emp_id" id="emp" class="form-control">
                                        @foreach($employees as $emp)
                                            <option value="{{$emp->id}}" {{$emp->id==$todo_list->emp_id?'selected':''}}>{{$emp->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="emp_id" value="{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->id}}">
                        @endif
                        <div class="col-6">
                            <div class="form-group">
                                <label for="end_date">Estimates Finished Date</label>
                                <input type="date" class="form-control" name="end_date" id="end_date" value="{{\Carbon\Carbon::parse($todo_list->end_date)->format('Y-m-d')}}" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="priority">Priority</label>
                                <select name="priority" id="priority" class="form-control">
                                    <option value="High" {{$todo_list->priority=='High'?'selected':''}}>High</option>
                                    <option value="Medium" {{$todo_list->priority=='Medium'?'selected':''}}>Medium</option>
                                    <option value="Low" {{$todo_list->priority=='Low'?'selected':''}}>Low</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="Not Working" {{$todo_list->status=='Not Working'?'selected':''}}>Not Working</option>
                                    <option value="Start Working" {{$todo_list->status=='Start Working'?'selected':''}}>Start Working</option>
                                    <option value="Pending" {{$todo_list->status=='Pending'?'selected':''}}>Pending</option>
                                    <option value="Finished" {{$todo_list->status=='Finished'?'selected':''}}>Finished</option>
                                    <option value="Cancel" {{$todo_list->status=='Cancel'?'selected':''}}>Cancel</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="process">Working Process Percentage</label>
                                <input type="number" name="progress" class="form-control" value="{{$todo_list->progress}}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="desc">Description</label>
                                <textarea name="description" id="desc" cols="30" rows="5" class="form-control" required>{{$todo_list->description}}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row text-center">
                                <div class="col-12 text-center">
                                    <button type="button" data-bs-dismiss="offcanvas" class="btn btn-sm btn-danger mr-3">Cancel</button>
                                    <button type="submit" class="btn btn-sm btn-info">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection