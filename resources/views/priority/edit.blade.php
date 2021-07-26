<div class="modal fade" id="priority{{$priority->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Priority</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  id="{{$priority->id}}" method="POST" action="{{route('priorities.update',$priority->id)}}" class="my-2">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="priority_name">Priority Name</label>
                        <input type="text" class="form-control" id="priority_name" aria-describedby="emailHelp" name="priority" value="{{$priority->priority}}" placeholder="Priority Name">
                    </div>
                    <span>Old Duration Time : </span> : {{$priority->hours}} Hours {{$priority->minutes}} Minutes {{$priority->seconds}} Seconds
                    <div class="form-group ">
                        <label for="duration_time" class="my-2">Select New Duration Time : </label><br>
                        <select class="custom-select col-3 " name="hour" style="margin-left: 0px;">
                            @for($i=0;$i<24;$i++)
                                <option>{{$i}}</option>
                            @endfor
                        </select>
                        <span>h</span>
                        <select name="min" class="custom-select col-3">
                            @for($i=0;$i<60;$i++)
                                <option>{{$i}}</option>
                            @endfor
                        </select>
                        <span>m</span>
                        <select name="sec" class="custom-select col-3">
                            @for($i=0;$i<60;$i++)
                                <option>{{$i}}</option>
                            @endfor
                        </select>
                        <span>s</span>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
