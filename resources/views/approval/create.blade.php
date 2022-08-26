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
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
               <div class="col-12 my-3">
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
                                       <select class="form-control" name="type" id="type">
                                           <option value="General Approval">General Approval</option>
                                           <option value="Business Trip">Business Trip</option>
                                           <option value="Payment">Payment</option>
                                           <option value="Procurement">Procurement</option>
                                           <option value="Items Request">Item Request</option>
                                           <option value="Material Request">Material Request</option>
                                           <option value="Service Request">Service Request</option>
                                           <option value="Work Request">Work Request</option>
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
                                       <input type="number" class="form-control " id="budget" name="budget">
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
                               <label for="contact">Supplier</label>
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
                                       <input type="number" class="form-control total_amount" name="payment_amount" id="payment_amount">
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
                                       <input type="number" class="form-control total_amount" name="procurement_amount" id="procurement_amount">
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-6 col-12">
                               <div class="form-group">
                                   <label for="contact">Supplier</label>
                                   <select name="supplier" id="contact" class="form-control " style="width: 100%;">
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
                       <div  id="warehouse_div">
                           <div class="form-group">
                               <label for="">Warehouse</label>
                               <select name="" id="" class="form-control" style="width: 100%">
                                   <option value="">None</option>
                                   @foreach($warehouse as $item)
                                       <option value="{{$item->id}}">{{$item->name}}</option>
                                       @endforeach
                               </select>
                           </div>
                       </div>
                       <div id="item_table">
                           <button type="button" class='delete btn btn-danger btn-sm'>Remove</button>
                           <button type="button" class='addmore btn btn-white btn-sm'>Add More</button><br>
                           <span class="text-danger" style="font-size: 12px;">!If you want to remove row,checked row checkbox and click remove button</span><br>
                           <table class="table-hover table table-bordered">
                               <tr>
                                   <th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
                                   <th>Product/Particular</th>
                                   <th>Variant</th>
                                   <th>Quantity</th>
                                   <th>Amount</th>
                               </tr>
                               <tr>
                                   <td><input type='checkbox' class='case'/></td>
                                   <td><input type='text' class="form-control form-control-sm" id='product' name='product[]'/></td>
                                   <td><input type='text' class="form-control form-control-sm" id='varaiant' name='variant[]'/></td>
                                   <td><input type='text' class="form-control form-control-sm" id='qty' name='qty[]'/></td>
                                   <td><input type='text' class="form-control form-control-sm sub_amount" id='amount' name='amount[]'></td>
                               </tr>
                           </table>

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
            </div>
        </div>
        <!-- /Page Header -->


    </div>

    <!-- /Add Event Modal -->
    <script>
        $(document).keyup(".sub_amount", function(){
            var sum=0;
            $(".sub_amount").each(function(){
                if($(this).val() != "")
                    sum += parseInt($(this).val());
            });

            $(".total_amount").val(sum);
        });
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
            $('#warehouse_div').hide();
            $('#item_table').hide();

            $('#type').on('change',function () {
                var type=$('#type option:selected').val();
                if(type=='Business Trip'){
                $('#business_trip').show();
                    $('#payment').hide();
                    $('#procurement').hide();
                    $('#warehouse_div').hide();
                    $('#item_table').hide();

                }else if(type=='Payment'){
                    $('#business_trip').hide();
                    $('#payment').show();
                    $('#procurement').hide();
                    $('#warehouse_div').hide();
                    $('#item_table').show();
                }else if (type=='Procurement') {
                    $('#business_trip').hide();
                    $('#payment').hide();
                    $('#procurement').show();
                    $('#warehouse_div').hide();
                    $('#item_table').show();

                }else if(type=='Items Request'){
                    $('#business_trip').hide();
                    $('#payment').hide();
                    $('#procurement').hide();
                    $('#warehouse_div').show();
                    $('#item_table').show();
                }else {
                    $('#business_trip').hide();
                    $('#payment').hide();
                    $('#procurement').hide();
                    $('#warehouse_div').hide();
                    $('#item_table').hide();
                }
            })
        });
        $(document).ready(function () {
            $('select').select2();
        });
        $(".delete").on('click', function() {
            $('.case:checkbox:checked').parents("tr").remove();
            $('.check_all').prop("checked", false);
            check();

        });
        var i=2;
        $(".addmore").on('click',function(){
            count=$('table tr').length;
            var data="<tr><td><input type='checkbox' class='case'/></td>";
            data +="<td><input type='text' class='form-control form-control-sm' id='product"+i+"' name='product[]'/></td> <td><input type='text' class='form-control form-control-sm' id='variant"+i+"' name='variant[]'/></td><td><input type='text' class='form-control form-control-sm' id='qty"+i+"' name='qty[]'/></td><td><input type='text' class='form-control form-control-sm sub_amount' id='amount"+i+"' name='amount[]' /></td></tr>";
            $('table').append(data);
            i++;
        });

        function select_all() {
            $('input[class=case]:checkbox').each(function(){
                if($('input[class=check_all]:checkbox:checked').length == 0){
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        }

        function check(){
            obj = $('table tr').find('span');
            $.each( obj, function( key, value ) {
                id=value.id;
                $('#'+id).html(key+1);
            });
        }

    </script>
@endsection
