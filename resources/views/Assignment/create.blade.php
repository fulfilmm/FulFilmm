<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Add Task</h5>
        <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="offcanvas" aria-label="Close"><i class="la la-close"></i></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{route('assignments.store')}}" method="POST">
            @csrf
            <input type="hidden" name="assignee_id" value="{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->id}}">
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" class="form-control" name="title" required>
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
                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
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
                            <input type="date" class="form-control" name="end_date" id="end_date" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select name="priority" id="priority" class="form-control">
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="Not Started">Not Started</option>
                                <option value="Start Working">Start Working</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="follower">Follower</label>
                            <select name="follower[]" id="follower" class="form-control" multiple>
                                <option value="">None</option>
                                @foreach($employees as $emp)
                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="desc">Description</label>
                            <textarea name="description" id="desc" cols="30" rows="5" class="form-control" required></textarea>
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
<script>
    $(document).ready(function () {
        $('#follower').select2();
    })
</script>