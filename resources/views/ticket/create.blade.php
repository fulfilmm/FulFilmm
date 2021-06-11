<!-- Add Ticket Modal -->
<div id="add_ticket" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('tickets.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("POST")
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ticket Subject</label>
                                <input class="form-control" type="text" name="subject">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ticket Id</label>
                                <input class="form-control" type="text" name="ticket_id" value="{{$ticket_id}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Case Type</label>
                                <select class="select" name="case">
                                    <option>-</option>
                                    @foreach($cases as $case)
                                        <option value="{{$case->id}}">{{$case->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Client</label>
                                <select class="select" name="client">
                                    <option>-</option>
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}">{{$client->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Priority</label>
                                <select class="select" name="priority">
                                    @foreach($priorities as $priority)
                                        <option value="{{$priority->id}}">{{$priority->priority}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Product</label>
                                <select name="product_id" id="" class="select">
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Assign</label>
                                <select class="select" id="type" name="assignType">
                                    <option value="item0">Choose Assign Type</option>
                                    <option value="dept">Assign To Department</option>
                                    <option value="agent">Assign To Agent</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Add Followers</label>
                                <select name="follower[]" id="follower" class="select" multiple>
                                    @foreach($all_emp as $agent)
                                        <option value="{{$agent->id}}">{{$agent->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Assign To</label>
                                <select name="assign_id" id="assign_to" class="select">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Upload Files</label>
                                <input class="form-control" name="attachment" type="file">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class=" form-group ">
                                <label align="center">Upload your images</label>
                                <input type="file" class="form-control"  id="files" name="files[]" multiple  required/>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#type").change(function () {
            var val = $(this).val();
            if (val == "dept") {
                $("#assign_to").html("@foreach($depts as $dept)<option value='{{$dept->id}}'>{{$dept->name}}</option> @endforeach");
            } else if (val == "agent") {
                $("#assign_to").html(" @foreach($all_emp as $agent)@if($agent->role->name=='Agent')<option value='{{$agent->id}}'>{{$agent->name}}</option> @endif @endforeach");
            }
        });
    });
</script>
<!-- /Add Ticket Modal -->
