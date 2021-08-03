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
                    <label for="subject">Subject <span class="text-danger">*</span></label>
                    <input class="form-control" value="{{old('subject')}}" id="subject" type="text" name="subject">
                    @error('subject')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="ticketId">Ticket Id <span class="text-danger">*</span></label>
                    <input class="form-control" id="ticketId" type="text" name="ticket_id"  value="{{$ticket_id}}" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Client Name <span class="text-danger">*</span></label>
                    <input type="text" value="{{old('client_name')}}" name="client_name" class="form-control" >
                    @error('client_name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Client Phone <span class="text-danger">*</span></label>
                    <input type="number" value="{{old('client_phone')}}" name="client_phone" class="form-control"  min="0" oninput="validity.valid||(value='');">
                @error('client_phone')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Case Type <span class="text-danger">*</span></label>
                    <select class="select" name="case">
                        @foreach($data['case'] as $case)
                            <option value="{{$case->id}}"{{old('case')==$case->id?'selected':''}}>{{$case->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label>Priority <span class="text-danger">*</span></label>
                    <select class="select" name="priority">
                        @foreach($data['priority'] as $priority)
                            <option value="{{$priority->id}}" {{old('priority')==$priority->id?'selected':''}}>{{$priority->priority}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Assign <span class="text-danger">*</span></label>
                    <select class="select" id="type" name="assignType">
                        <option value="item0">Choose Assign Type</option>
                        <option value="dept">Department</option>
                        <option value="agent">Agent</option>
                        <option value="group">Group</option>
                    </select>
                    @error('assignType')
                    <span class="text-danger">{{$message}}Select Department or Agent.</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Product <span class="text-danger">*</span></label>
                    <select name="product_id" id="" class="select">
                        @foreach($data['product'] as $product)
                            <option value="{{$product->id}}" {{old('product_id')==$product->id?'selected':''}}>{{$product->name}}</option>
                        @endforeach
                    </select>
                    @error('product_id')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Assign To <span class="text-danger">*</span></label>
                    <select name="assign_id" id="assign_to" class="select">
                        <option></option>
                    </select>
                    @error('assign_id')
                    <span class="text-danger">Assign To is required.You must to select assign type first.</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Add Followers</label>
                    <select name="follower[]" id="follower" class="select" multiple>
                        @foreach($data['all_emp'] as $agent)
                            <option value="{{$agent->id}}">{{$agent->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="source">Source</label>
                    <input type="text" class="form-control" id="source" name="source">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="guest_description" name="description">{{old('description')}}</textarea>
                    @error('description')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
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
                    <input type="file" class="form-control"  id="files" name="files[]" multiple  />
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
                    $("#assign_to").html("@foreach($data['depts'] as $dept)<option value='{{$dept->id}}'>{{$dept->name}}</option> @endforeach");
                } else if (val == "agent") {
                    $("#assign_to").html(" @foreach($data['all_emp'] as $agent)@if($agent->role->name=='Agent')<option value='{{$agent->id}}'>{{$agent->name}}</option> @endif @endforeach");
                }
            });
        });
        ClassicEditor
            .create( document.querySelector( '#guest_description' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endsection
