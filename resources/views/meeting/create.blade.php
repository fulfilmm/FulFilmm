@extends('layout.mainlayout')
@section('title','Meeting Create')
@section('content')
    <!-- Page Wrapper -->
    <style>
        .ck-editor__editable {
            min-height: 200px !important;

        }
        .ck-file-dialog-button{
            display: none;
        }
        .ck-dropdown__button{
            display: none;
        }
    </style>
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
                   <div class="col-12">
                       <div class="form-group">
                           <label for="latter">Invitation Letter</label>
                           <textarea name="letter" class="form-control" id="letter" cols="30" rows="10" style="height: 220px"></textarea>
                       </div>
                   </div>
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
                                   <input type="text" value="{{old('due_date')}}" name="due_date" class="form-control" id="date" required>
                                   @error('due_date')
                                   <span class="text-danger">{{$message}}</span>
                                   @enderror
                               </div>
                           </div>
                           <div class="col-md-12">
                               <label for="">Meeting Type</label>
                           <div class="form-group" id="meeting_type">
                           <input type="radio" class="ml-3" name="meeting_type"  value="Real" {{old('meeting_type')=="Real" ? 'checked' :""}} checked><label for="real" class="ml-2 mr-3"> Meeting</label>
                           <input type="radio" class="ml3" name="meeting_type" value="Visual" {{old('meeting_type')=="Visual" ? 'checked' :""}}><label for="visual" class="ml-2"> Online Meeting</label>
                           </div>
                           </div>
                           <div id="realtive_field">
                               <div class="col-md-12" id="for_real">
                                   <div class="form-group">
                                       <label for="room_no">Room No(Room Name) <span class="text-danger">*</span></label>
                                       <select id="room_no" name="room_no" class="form-control select" >
                                           <option value="">Choose Your Booking Room</option>
                                          @foreach($data['rooms'] as $key=>$val)
                                           <option value="{{$key}}">{{$val}}</option>
                                           @endforeach
                                       </select>
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
                                       @foreach($data['employees'] as $key=>$val)
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
                                       <input type="text" name="guest_name[]" class="form-control m-input" placeholder="Mr/Mrs" autocomplete="off">
                                   </div>
                               </div>

                               <div id="guest"></div>
                               <button id="add_guest" type="button" class="btn btn-outline-secondary float-right">Add Guest</button>
                           </div>
                       </div>
                   </div>
               </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-outline-primary col-md-2 col-4">Submit</button>
                </div>
            </form>
        </div>

    </div>
    <!-- /Page Content -->

    <!-- /Page Wrapper -->
    x
    <script type="text/javascript">
        // add row

        jQuery(document).ready(function () {
            'use strict';

            jQuery('#date').datetimepicker();
        });
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
        });

        $("#add_guest").click(function () {
            var html = '';
            html += '<div id="add_guestrow">';
            html += '<div class="input-group mb-3">';
            html += '<input type="email" name="guest_email[]" value="{{old('guest_email[]')}}" class="form-control m-input" placeholder="Enter Guest Person Email" autocomplete="off">';
            html += '<input type="text" name="guest_name[]" value="{{old('guest_email[]')}}" class="form-control m-input" placeholder="Mr/Mrs" autocomplete="off">';
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
                    $('#realtive_field').append('<div class="col-md-12" id="for_real"><div class="form-group"><label for="room_no">Room No(Room Name) <span class="text-danger">*</span></label><select id="room_no" name="room_no" class="form-control select" ><option value="">Choose Your Booking Room</option>@foreach($data['rooms'] as $key=>$val)<option value="{{$key}}">{{$val}}</option>@endforeach</select></div></div>');
                }
            });
        });

        ClassicEditor.create($('#letter')[0],{
            toolbar: [ 'heading','bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList','insertTable','fontColor','fontfamily','fontsize']

        });

    </script>
@endsection
