<div class="modal fade" id="change_status{{$ticket->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ticket Status Change</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url("/status/$ticket->id")}}" method="POST">
                        @csrf
                          <div class="col">
                            <div class="form-group">
                                <select name="status_id" id="" class="select">
                                    @foreach($statuses as $status)
                                        @if($status->id==$ticket->status)
                                    <option value="{{$status->id}}" selected>{{$status->name}}</option>
                                        @else
                                    <option value="{{$status->id}}">{{$status->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                          </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-outline-info" >Save</button>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</div>
