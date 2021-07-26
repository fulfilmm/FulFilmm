@extends('layout.mainlayout')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Meeting Create</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Meeting</li>
                        <li class="breadcrumb-item active">Create</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card col-12 col-md-12">
            <div class="card-header"> <h4>Meeting Create</h4></div>
            <form action="{{route('meetings.store')}}" method="POST" class="mt-2">
              {{csrf_field()}}
               <div class="row">
                   <div class="col-md-6">
                       <div class="card">
                           <div class="col-12 mt-2">
                           <div class="form-group">
                               <label for="title">Title <span class="text-danger">*</span></label>
                               <input type="text" id="title" class="form-control" name="title" value="{{old('title')}}" required>
                               @error('title')
                               <span class="text-danger">{{$message}}</span>
                               @enderror
                           </div>
                           </div>
                           <div class="col-12">
                               <label for="agenda">Agenda <span class="text-danger">*</span></label>
                               <div class="row">
                                   <div class="col-lg-12">
                                       <div id="inputFormRow">
                                           <div class="input-group mb-3">
                                               <input type="text" name="agender[]" class="form-control m-input" placeholder="Enter Agenda" autocomplete="off" required>
                                           </div>
                                       </div>

                                       <div id="newRow"></div>
                                       <button id="addRow" type="button" class="btn btn-outline-warning float-right">Add More</button>
                                   </div>
                                   @error('agender[].*')
                                   <span class="text-center">{{$message}}</span>
                                   @enderror
                               </div>
                           </div>
                           <div class="col-md-12">
                               <div class="form-group">
                                   <label for="date">Date  <span class="text-danger">*</span></label>
                                   <input type="datetime-local" value="{{old('due_date')}}" name="due_date" class="form-control" id="date" required>
                                   @error('due_date')
                                   <span class="text-danger">{{$message}}</span>
                                   @enderror
                               </div>
                           </div>
                           <div class="col-md-12">
                               <label for="">Meeting Type</label>
                           <div class="form-group" id="meeting_type">
                           <input type="radio" class="ml-3" name="meeting_type"  value="Real" {{old('meeting_type')=="Real" ? 'checked' :""}} checked><label for="real" class="ml-2 mr-3"> Real Meeting</label>
                           <input type="radio" class="ml3" name="meeting_type" value="Visual" {{old('meeting_type')=="Visual" ? 'checked' :""}}><label for="visual" class="ml-2"> Visual Meeting</label>
                           </div>
                           </div>
                           <div id="realtive_field">
                               <div class="col-md-12" id="for_real">
                                   <div class="form-group">
                                       <label for="">Address <span class="text-danger">*</span></label>
                                       <input type="text" class="form-control" name="address" value="{{old('address')}}" required>
                                   </div>
                                   <div class="form-group">
                                       <label for="location">Room No(Room Name) <span class="text-danger">*</span></label>
                                       <input type="text" id="location" name="room_no" class="form-control" value="{{old('room_no')}}" required>

                                   </div>
                               </div>
                           </div>

                       </div>
                   </div>
                   <div class="col-md-6">
                       <div class="card">
                           <div class="card-header">Invite Meeting Member</div>
                           <div class="card-body">
                               <div class="fom-group">
                                   <label for="internal">Internal Member <span class="text-danger">*</span></label>
                                   <select class="select" name="internal_members[]" multiple required>
                                       @foreach($employees as $key=>$val)
                                           @if(\Illuminate\Support\Facades\Auth::guard('employee')->user()->id!=$key)
                                       <option value="{{$key}}">{{$val}}</option>
                                           @endif
                                       @endforeach
                                   </select>
                               </div>
                               <label for="agenda" class="mt-3">Guest Member</label>
                               <div id="add_guestrow">
                                   <div class="input-group mb-3">
                                       <input type="email" name="guest_email[]" class="form-control m-input" placeholder="Enter Guest Person Email" autocomplete="off">
                                   </div>
                               </div>

                               <div id="guest"></div>
                               <button id="add_guest" type="button" class="btn btn-outline-secondary float-right">Add Guest</button>
                           </div>
                       </div>
                   </div>
               </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                </div>
            </form>
        </div>

    </div>
    <!-- /Page Content -->

    <!-- /Page Wrapper -->
    <script type="text/javascript">
        // add row
        $("#addRow").click(function () {
            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html += '<input type="text" name="agender[]" class="form-control m-input" placeholder="Enter Agenda" autocomplete="off" required>';
            html += '<div class="input-group-append">';
            html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="fa fa-minus"></i></button>';
            html += '</div>';
            html += '</div>';

            $('#newRow').append(html);
        });

        // remove row
        $(document).on('click', '#removeRow', function () {
            $(this).closest('#inputFormRow').remove();
        })

        $("#add_guest").click(function () {
            var html = '';
            html += '<div id="add_guestrow">';
            html += '<div class="input-group mb-3">';
            html += '<input type="email" name="guest_email[]" value="{{old('guest_email[]')}}" class="form-control m-input" placeholder="Enter Guest Person Email" autocomplete="off">';
            html += '<div class="input-group-append">';
            html += '<button id="remove_guest" type="button" class="btn btn-outline-info"><i class="fa fa-trash"></i></button>';
            html += '</div>';
            html += '</div>';

            $('#guest').append(html);
        });

        // remove row
        $(document).on('click', '#remove_guest', function () {
            $(this).closest('#add_guestrow').remove();
        });
        $(document).ready(function(){
            var default_select=$("input[name='meeting_type']:checked").val();
            if(default_select=='Real'){
                $('#for_visual').hide();
            }else {
                $('#for_real').remove();
                $('#realtive_field').append("<div class='col-md-12' id='visual_input'><div class='form-group' ><label for=''>Meeting Link <span class='text-danger'>*</span></label><input type='text' class='form-control' value='{{old("link")}}' name='link' required></div><div class='form-group'><label for=''>Password <span class='text-danger'>*</span></label><input type='text' name='password' value='{{old("password")}}' class='form-control' required></div>");
            }

            $('#meeting_type').change(function(){
                var type=$("input[name='meeting_type']:checked").val();
                if(type=='Visual'){
                    $('#for_real').remove();
                    $('#realtive_field').append("<div class='col-md-12' id='visual_input'><div class='form-group' ><label for=''>Meeting Link <span class='text-danger'>*</span></label><input type='text' class='form-control' value='{{old("link")}}' name='link' required></div><div class='form-group'><label for=''>Password <span class='text-danger'>*</span></label><input type='text' name='password' value='{{old("password")}}' class='form-control' required></div>");
                }else {

                    $('#visual_input').remove();
                    $('#realtive_field').append('<div class="col-md-12" id="for_real"><div class="form-group"><label for="">Address <span class="text-danger">*</span></label><input type="text" class="form-control" name="address" value="{{old('address')}}" required></div><div class="form-group"><label for="location">Room No(Room Name) <span class="text-danger">*</span></label><input type="text" id="location" name="room_no" value="{{old('room_no')}}" class="form-control" required></div></div>');
                }
            });
        });

    </script>
@endsection
