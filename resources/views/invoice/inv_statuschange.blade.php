<div class="modal fade" id="change_status{{$invoice->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invoice Status Change (ID:#{{$invoice->invoice_id}})</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url("invoice/status/$invoice->id")}}" method="POST">
                    @csrf
                    <div class="col">
                        <div class="form-group">
                            <select name="status" id="" class="select">
                                @foreach($status as $key=>$value)
                                    @if($invoice->status==$value)
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                    @else
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" id="status_change" class="btn btn-outline-info" >Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
