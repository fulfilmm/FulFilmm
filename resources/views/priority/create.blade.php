<div class="modal fade" id="priority" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title " id="exampleModalLabel">New Priority</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="priority_create" action="{{route('priorities.store')}}" method="POST" class="my-2">
                   @csrf
                    <div class="form-group">
                        <label for="priority">Priority</label>
                        <input type="text" class="form-control" id="priority" aria-describedby="emailHelp" name="priority">
                    </div>
                    <div class="form-group">
                        <label for="priority">Color</label>
                        <select class="form-control"name="color" id="">
                            <option selected disabled>Choose Color</option>
                            @if($isgreen==0)
                                <option value="success">Green</option>
                            @endif
                            @if($isred==0)
                                <option value="danger">Red</option>
                            @endif
                            @if($isblue==0)
                                <option value="info">Blue</option>
                            @endif
                            @if($isyellow==0)
                                <option value="warning">Yellow</option>
                            @endif
                        </select>
                    </div>
                    <label>Duration Time : </label>
                    <div class="col-12">
                        <div class="row">
                           <div class="form-group col-4">
                               <input type="number" class="form-control " min="0" oninput="validity.valid||(value='');" name="hour" style="margin-left: 0px;" placeholder="Hour">
                           </div>
                            <div class="form-group col-4">
                                <select name="min" class="custom-select ">
                                    <option disabled selected>Minutes</option>
                                    @for($i=0;$i<60;$i++)
                                        <option>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <select name="sec"  class="custom-select">
                                    <option disabled selected>Second</option>
                                    @for($i=0;$i<60;$i++)
                                        <option>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary float-right">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
</script>
