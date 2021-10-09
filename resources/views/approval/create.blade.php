@extends('layout.mainlayout')
@section('title','Approval')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Approval Request</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Approval Request</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_event"><i
                                class="fa fa-plus"></i> Add Approval</a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <form action="{{route('approvals.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="approval_title">Title<span class="text-danger">*</span></label>
                           <div class="input-group">
                               <div class="input-group-prepend">
                                   <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                               </div>
                               <input class="form-control" type="text" name="title" id="approval_title"
                                      value="{{ old('title') }}">
                           </div>
                            @error('title')
                            {{-- <span class="invalid-feedback" role="alert"> --}}
                            <span class="text-danger">{{ $message }}</span>
                            {{-- </span> --}}
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="target_date">Target Date <span class="text-danger">*</span></label>
                           <div class="input-group">
                               <div class="input-group-prepend">
                                   <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                               </div>
                               <input class="form-control" type="text" name="target_date" id="target_date"
                                      value="{{ old('target_date') }}" placeholder="Target Date">
                           </div>
                            @error('target_date')
                            {{-- <span class="invalid-feedback" role="alert"> --}}
                            <span class="text-danger">{{ $message }}</span>
                            {{-- </span> --}}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="approver" class="control-label">Approver Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user-secret"></i></span>
                                </div>
                                <select class="form-control" name="approve_id" id="approver">
                                    @foreach($all_emp as $emp)
                                        @if($emp->role->name=='Manager'||$emp->role->name=='CEO')
                                            <option {{ old('approve_id') == $emp->id ? "selected" : "" }} value="{{$emp->id}}">{{$emp->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="secondary" class="control-label">Secondary Request Name(Optional)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user-secret"></i></span>
                                </div>
                            <select class="form-control" name="secondary_id" id="secondary">
                                <option disabled selected>Select Secondary Approver</option>
                                @foreach($all_emp as $emp)
                                    @if($emp->role->name=='Manager'||$emp->role->name=='CEO')
                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="type" class="control-label">Approval Type <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-th-list"></i></span>
                                </div>
                            <select class="form-control" name="type" id="type">
                                <option value="General Approval">General Approval</option>
                                <option value="Business Trip">Business Trip</option>
                                <option value="Payment">Payment</option>
                                <option value="Procurement">Procurement</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cc">Tags</label>
                            <select name="cc[]" id="cc" class="select" multiple>
                                @foreach($all_emp as $emp)
                                    @if($emp->id != \Illuminate\Support\Facades\Auth::guard('employee')->user()->id)
                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row" id="business_trip">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="">From Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            <input type="text" class="form-control" id="from" name="from" placeholder="From Date">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="">To Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            <input type="text" class="form-control" id="to_date" name="to_date" placeholder=" To Date">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cc">Trip Members</label>
                            <select name="members[]" id="member" class="select" multiple>
                                @foreach($all_emp as $emp)
                                    @if($emp->id != \Illuminate\Support\Facades\Auth::guard('employee')->user()->id)
                                        <option value="{{$emp->name}}">{{$emp->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="budget">Budget</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-money"></i></span>
                                </div>
                            <input type="number" class="form-control" id="budget" name="budget">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="location">Location</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-map"></i></span>
                                </div>
                            <input type="text" class="form-control" id="location" name="location">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="payment">
                    <div class="col-md-6 col-12">
                        <label for="contact">Contact</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-users"></i></span>
                            </div>
                        <select name="contact" id="contact" class="form-control ">
                            <option value="">Choose Contact</option>
                            @foreach($customer as $contact)
                                <option value="{{$contact->id}}">{{$contact->name}}</option>
                                @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="payment_amount">Amount</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-money"></i></span>
                                </div>
                            <input type="number" class="form-control" name="payment_amount" id="payment_amount">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="procurement">
                    <div class="col-md-6 col-12">
                        <label for="quantity">Quantity</label>
                        <div class="input-group">
                        <input type="text" class="form-control" name="quantity" id="quantity">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="procurement_amount">Amount</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-money"></i></span>
                                </div>
                            <input type="number" class="form-control" name="procurement_amount" id="procurement_amount">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <label for="contact">Supplier</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-users"></i></span>
                            </div>
                            <select name="supplier" id="contact" class="form-control ">
                                <option value="">Choose Supplier</option>
                                @foreach($customer as $contact)
                                    @if($contact->customer_type=='Supplier')
                                    <option value="{{$contact->id}}">{{$contact->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-2">
                    <label for="desc">Content <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="desc" name="description"></textarea>
                    @error('description')
                    {{-- <span class="invalid-feedback" role="alert"> --}}
                    <span class="text-danger">{{ $message }}</span>
                    {{-- </span> --}}
                    @enderror
                </div>

                <div class="form-group">
                    <label for="resume" class="control-label">Upload Document Files(Allow Multiple Select)</label>
                    <input type="file" class="form-control" name="doc_file[]" id="fileupload" multiple/>
                    @error('doc_file')
                    {{-- <span class="invalid-feedback" role="alert"> --}}
                    <strong class="text-danger">{{ $message }}</strong>
                    {{-- </span> --}}
                    @enderror
                </div>
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                </div>
            </form>
        </div>
        <!-- /Page Header -->


    </div>

    <!-- /Add Event Modal -->
    <script>
        jQuery(document).ready(function () {
            'use strict';

            jQuery('#target_date').datetimepicker();
            jQuery('#from').datetimepicker();
            jQuery('#to_date').datetimepicker();
        });
        $(document).ready(function () {
            $('#business_trip').hide();
            $('#payment').hide();
            $('#procurement').hide();

            $('#type').on('change',function () {
                var type=$('#type option:selected').val();
                if(type=='Business Trip'){
                $('#business_trip').show();
                    $('#payment').hide();
                    $('#procurement').hide();

                }else if(type=='Payment'){
                    $('#business_trip').hide();
                    $('#payment').show();
                    $('#procurement').hide();
                }else if (type=='Procurement') {
                    $('#business_trip').hide();
                    $('#payment').hide();
                    $('#procurement').show();
                }else {
                    $('#business_trip').hide();
                    $('#payment').hide();
                    $('#procurement').hide();
                }
            })
        })
    </script>
@endsection
