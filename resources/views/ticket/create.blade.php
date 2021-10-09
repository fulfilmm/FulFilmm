@extends('layout.mainlayout')
@section('title','Ticket Post')
@section('content')
    <link rel="stylesheet" href="{{url(asset('css/ticket.css'))}}">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Tickets Create</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tickets</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="col-md-12 col-sm-12 col-12">
            <form action="{{route('tickets.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("POST")
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Subject <span class='text-danger'>*</span></label>
                                <input class="form-control @error('subject')is-invalid @enderror" type="text" name="subject" value="{{old('subject')}}">
                                @error('subject')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <input type="hidden" name="complain_id" value="{{isset($complain)?$complain->id:''}}">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ticket Id</label>
                                <input class="form-control" type="text" name="ticket_id" value="{{$ticket_id}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Case Type <span class="text-danger">*</span></label>
                                <select class="select" name="case">
                                    @foreach($data['case'] as $case)
                                        <option value="{{$case->id}}" {{old('case')==$case->id?'selected':''}}>{{$case->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6" id="client">
                            <div class="form-group">
                                <label>Client <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select class="form-control" name="client">
                                        @foreach($data['client'] as $client)
                                            <option value="{{$client->id}}" {{isset($complain)?($complain->email==$client->email?'selected':''):(old('client')==$client->id?'selected':'')}}>{{$client->name}}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-white" type="button" data-toggle="modal" href="#add_contact" ><i class="la la-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Product <span class='text-danger'>*</span></label>
                                <select name="product_id" id="" class="select">
                                    <option value="">None</option>
                                    @foreach($data['product'] as $product)
                                        <option value="{{$product->id}}"{{old('product_id')==$product->id?'selected':''}}>{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Assign Type<span class="text-danger">*</span></label>
                                <select class="select" id="type" name="assignType">
                                    <option value="item0">Unassign</option>
                                    <option value="dept">Department</option>
                                    <option value="group">Group</option>
                                    <option value="agent">Agent</option>
                                </select>
                                @error('assignType')
                                <span class="text-danger">{{$message}}Select Department or Agent.</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Add Followers</label>
                                <select name="follower[]" id="follower" class="select" multiple>
                                    @foreach($data['all_emp'] as $agent)
                                        <option value="{{$agent->id}}" >{{$agent->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Assign To <span class="text-danger">*</span>  </label>
                                <select name="assign_id" id="assign_to" class="select">
                                    <option></option>
                                </select>
                                @error('assign_id')
                                <span class="text-danger">Assign To is required.You must to select assign type first.</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="source">Source</label>
                               <select class='select' name="source" id="source">
                                    <option value="Phone">Phone</option>
                                    <option value="Email">Email</option>
                                    <option value="Web Messager">Web Messager</option>
                                    <option value="Viber">Viber</option>
                                    <option value="Whatapp">Whatapp</option>
                                    <option value="Other">Other</option>
                               </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                            <label for='tag'>Tag</label>
                            <input type="text" class='form-control' name='tag'>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="description">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description')is-invalid @enderror"  id="description" name="description" style="height: 200px;" >
                                    {{isset($complain)?$complain->description:''}}
                                </textarea>
                           @error('description')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Upload Files</label>
                                <input class="form-control" value="{{isset($complain)?url(asset('/ticket_attach/'.$complain->attach_file))??'':''}}" name="attachment" type="file">
                                @error('attachment')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                <div>
                    <label align="center">Upload your images</label>
                        <div id="inputFormRow">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control"  id="files" name="files[]" />
                            </div>
                        </div>
                        <div id="newRow"></div>
                      <div class="input-group">
                        <button id="addRow" type="button" class="btn btn-white float-right">Add More Image</button>
                      </div>
                        @error('files.*')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
        </div>
        @include('customer.quickcustomer')
    </div>

<script>
    $("#addRow").click(function () {
        var html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<input type="file" class="form-control"  id="files" name="files[]"/>';
        html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="la la-close"></i></button>';
        html += '</div>';
        html += '</div>';

        $('#newRow').append(html);
    });
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
    });
    $(document).ready(function() {
        $(document).on('click', '#customer_add', function () {
            // var customer_id=$("#customer_id").val();
            var customer_name =$("#customer_name").val();
            var customer_phone=$("#customer_phone").val();
            var customer_email=$("#customer_email").val();
            var customer_company=$("#customer_company_id option:selected").val();
            var customer_address=$("#customer_address").text();
            var type="ajax";
            $.ajax({
                data : {
                    name:customer_name,
                    phone:customer_phone,
                    email:customer_email,
                    company_id:customer_company,
                    address:customer_address,
                },
                type:'POST',
                url:"{{route('add_new_customer')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                    console.log(data);
                    $("#client").load(location.href + " #client>* ");

                }
            });
        });
    });
    $(document).ready(function () {

        $("#type").change(function () {
            var val = $(this).val();
            if (val == "dept") {
                $("#assign_to").html("@foreach($data['depts'] as $dept)<option value='{{$dept->id}}' {{old('assign_id')==$dept->id?'selected':''}}>{{$dept->name}}</option> @endforeach");
            } else if (val == "agent") {
                $("#assign_to").html(" @foreach($data['all_emp'] as $agent)@if($agent->role->name=='Agent')<option value='{{$agent->id}}'>{{$agent->name}}</option> @endif @endforeach");
            }else if(val=='group'){
                $("#assign_to").html("@foreach($group as $key=>$val)<option value='{{$key}}'>{{$val}}</option> @endforeach");
            }else {
                $("#assign_to").html("<option value=''></option>");
            }
        });
    });

    ClassicEditor.create($('#description')[0], {
        toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
    });

</script>
@endsection
