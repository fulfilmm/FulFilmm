<div id="booking" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Room Booking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                      <div class="card">
                          <div class="col-12 my-3">
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
                                      <label for="date">Date</label>
                                      <input type="date" class="form-control" name="date" value="{{old('date')}}" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="start_time">Start Time</label>

                                      <input type="text" id="start_time" class="form-control" min="{{\Carbon\Carbon::now()->format('Y-m-d')}}T06:30" name="start_time"  required>
                                  </div>
                                  <div class="form-group">
                                      <label for="end_time">End Time</label>
                                      <input type="text" id="end_time" class="form-control" min="{{\Carbon\Carbon::now()->format('Y-m-d')}}T06:30" name="endtime" required>
                                  </div>
                                  <div class="form-group">
                                      <button class="btn btn-primary">Add</button>
                                  </div>
                              </form>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header">
                                Booked List
                            </div>
                            <div class="card-body">
                                <div class="row" id="list">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#room_no').change(function () {
            $('#list').empty();
            var id=$(this).val();
           @foreach($data['bookedroom'] as $item)
                if(id=='{{$item->room_id}}'){
                    $('#list').append('<div class="col-5"><span>{{\Carbon\Carbon::parse($item->date)->toFormattedDateString()}}</span></div><div class="col-md-7"> <span>{{date('h:i a', strtotime($item->start_time))}} - {{date('h:i a',strtotime($item->endtime))}} </span></div>');
           }
            @endforeach
        });
    });
    jQuery(document).ready(function () {
        'use strict';

        // jQuery('#start_time,#end_time').datetimepicker({
        //     timeFormat: 'hh:mm tt', timeOnly: true
        // });
        $(document).ready(function () {
            $('#start_time').mdtimepicker({
                timeFormat: 'hh:mm:ss.000', // format of the time value (data-time attribute)
                format: 'hh:mm tt',    // format of the input value
                readOnly: false,       // determines if input is readonly
                hourPadding: false,
                theme: 'green',
                okLabel: 'OK',
                cancelLabel: 'Cancel',
            });
            $('#end_time').mdtimepicker({
                timeFormat: 'hh:mm:ss.000', // format of the time value (data-time attribute)
                format: 'hh:mm tt',    // format of the input value
                readOnly: false,       // determines if input is readonly
                hourPadding: false,
                theme: 'green',
                okLabel: 'OK',
                cancelLabel: 'Cancel',
            });
        });
    });
</script>