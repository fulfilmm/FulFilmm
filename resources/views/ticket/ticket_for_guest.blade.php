@extends("layout.mainlayout")
@section('title',"Ticket Create")
@section('content')
    <style>
        input[type="file"] {
            display: block;
        }
        .imageThumb {
            max-height: 90px;
            max-width: 150px;
            border: 2px solid;
            padding: 1px;
            cursor: pointer;
        }
        .pip {
            display: inline-block;
            margin: 10px 10px 10px 0;
        }
        .remove {
            display: block;
            background: #edeff2;
            border: 1px solid black;
            color: black;
            text-align: center;
            cursor: pointer;
        }
        .remove:hover {
            background: white;
            color: black;
        }
        #cke_11,#cke_19,#cke_21,#cke_26,#cke_27,#cke_28,#cke_29,#cke_30,#cke_32,#cke_47{
            visibility: hidden;
        }
    </style>
    {{-- Modals --}}
    <!-- Page Content -->
    <div class="content container-fluid">
        <div class="col-md-10 offset-md-1 col-12">
            <h3 class="my-3">Ticket Create </h3>
    <form action="{{url('ticket/create/guest')}}" method="POST" enctype="multipart/form-data">
        @csrf
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
                    <input class="form-control" type="text"  value="{{$ticket_id}}">
                    <input type="hidden" name="ticket_id" value="{{$ticket_id}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Client Name</label>
                    <input type="text" name="client_name" class="form-control">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Client Phone</label>
                    <input type="number" name="client_phone" class="form-control"  min="0" required  oninput="validity.valid||(value='');">
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
                    <label>Priority</label>
                    <select class="select" name="priority">
                        @foreach($priorities as $priority)
                            <option value="{{$priority->id}}">{{$priority->priority}}</option>
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
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Assign To</label>
                    <select name="assign_id" id="assign_to" class="select">
                        <option></option>
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
    <script>
        $(document).ready(function() {
            if (window.File && window.FileList && window.FileReader) {
                $("#files").on("change", function(e) {
                    var files = e.target.files,
                        filesLength = files.length;
                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            $("<div class=\"pip\">" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                                "<br/><div class=\"remove\"><i class='fa fa-remove'>Remove</div>" +
                                "</div>").insertAfter("#files");
                            $(".remove").click(function(){
                                $(this).parent(".pip").remove("file");
                            });


                        });
                        fileReader.readAsDataURL(f);
                    }
                });
            } else {
                alert("Your browser doesn't support to File API")
            }
        });
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
@endsection
