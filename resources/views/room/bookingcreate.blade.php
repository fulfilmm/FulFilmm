<div id="booking" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Rooms</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('savebooking')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" class="form-control" name="subject">
                    </div>
                    <input type="hidden" name="created_emp" value="{{$data['emp_id']}}">
                    <div class="form-group">
                        <label for="room_no">Room No</label>
                        <select name="room_id"  id="room_no" class="select form-control">
                            @foreach($data['room'] as $key=>$val)
                            <option value="{{$key}}">{{$val}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="start_time">Start Time</label>
                        <input type="datetime-local" id="start_time" class="form-control" min="{{\Carbon\Carbon::now()->format('Y-m-d')}}T06:30" name="start_time" required>
                    </div>
                    <div class="form-group">
                        <label for="end_time">End Time</label>
                        <input type="datetime-local" id="end_time" class="form-control" min="{{\Carbon\Carbon::now()->format('Y-m-d')}}T06:30" name="endtime" required>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>