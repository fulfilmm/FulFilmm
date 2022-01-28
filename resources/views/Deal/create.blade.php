@extends('layout.mainlayout')
@section('title','Deal Create')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Deal Add</h3> working
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("home")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{url("/deal")}}">Deal</a></li>
                        <li class="breadcrumb-item active">Deal Add</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <!-- /Content End -->

        <div class="container scoll">
            <form action="{{route('deals.store')}}" method="POST">
                @csrf
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="full_form_name">Deal Name <span class="text-danger"> * </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-file"></i></span>
                                    </div>
                                    <input type="text" id="full_form_name" name="name" value="{{old('deal_name')}}"
                                           class="form-control " placeholder="Enter Deal Name..">

                                </div>
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="full_form_amount">Weighted Amount <span class="text-danger"> * </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-money"></i></span>
                                    </div>
                                    <input type="number" id="full_form_amount" name="amount" class="form-control">
                                </div>
                                @error('amount')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="currency">Currency Unit <span class="text-danger"> * </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-money"></i></span>
                                    </div>
                                    <select name="unit" id="full_form_unit" class="form-control">
                                        <option value="MMK">MMK</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                                @error('unit')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 col-12" >
                            <div class="form-group" >
                                <label for="full_contact">Contact Name <span class="text-danger"> * </span></label>
                                <div class="input-group" id="contact_div">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <select name="contact_name"  id="full_contact" class="form-control">
                                        @foreach($allcustomers as $customer)
                                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('contact_name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12" >
                            <div class="form-group" >
                                <label for="full_contact">Lead Title<span class="text-danger"> * </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="lead_title" id="lead_title">
                                </div>
                                @error('contact_name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="full_exp_date">Expected Close Date <span
                                            class="text-danger"> * </span></label>
                                <div class="input-group">
                                    <input type="date" id="full_exp_date" name="exp_date" class="form-control">
                                </div>
                                @error('exp_date')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="full_probability">Probability</label>
                                <div class="input-group">
                                    <input type="number" name="probability" id="full_probability" class="form-control">
                                    <button type="button" class="btn btn-white ">%</button>
                                </div>
                            </div>
                            @error('probability')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 col-12">
                            <label for="full_pipeline">Pipeline <span class="text-danger"> * </span></label>
                            <div class="input-group">
                                <select name="pipeline" id="full_pipeline" class="form-control" >
                                    <option value="Standard">Standard</option>
                                </select>
                            </div>
                            @error('pipeline')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="full_sale_stage">Sale Stage <span class="text-danger"> * </span></label>
                                <div class="input-group">
                                    <select name="sale_stage" id="full_sale_stage" class="form-control" style="width: 100%">
                                        <option value="New">New</option>
                                        <option value="Qualified">Qualified</option>
                                        <option value="Quotation">Quatation</option>
                                        <option value="Invoicing">Invoicing</option>
                                        <option value="Win">Negotiation</option>
                                        <option value="Lost">Lost</option>
                                    </select>
                                </div>
                                @error('sale_stage')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="full_assign_to">Assign Staff</label>
                                <div class="input-group">
                                    <select name="assign_to" id="full_assign_to" class="form-control">
                                        @foreach($allemployees as $emp)
                                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('assign_to')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="full_lead_source">Lead Source</label>
                                <div class="input-group">
                                    <select name="lead_source" id="full_lead_source" class="form-control">
                                        @foreach($lead_source as $key=>$val)
                                            <option value="{{$val}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="next_step">Remark</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                    </div>
                                    <input type="text" id="next_step" name="next_step" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="full_type">Type</label>
                                <div class="input-group">
                                    <select name="type" id="full_type" class="form-control">
                                        <option value="Existing Business">Existing Business</option>
                                        <option value="New Business">New Business</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12" id="reason">
                            <div class="form-group">
                                <label for="lost_reason">Lost Reason</label>
                                <div class="input-group">
                                    <select name="lose_reason" id="lost_reason" class="form-control select">
                                        <option value="">None</option>
                                        <option value="Price">Price</option>
                                        <option value="Authority">Authority</option>
                                        <option value="Timing">Timing</option>
                                        <option value="Missing Feature">Missing Feature</option>
                                        <option value="Usability"> Usability</option>
                                        <option value="Unknown"> Unknown</option>
                                        <option value="No need">No Need</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description"> Description </label>
                        <textarea name="description" id="description" style="width: 100%" rows="10"></textarea>
                    </div>
                    <div class="input-group text-center col-md-6 col-12 offset-md-3">
                        <a href="{{route('deals.index')}}" class="btn btn-danger col-5 mr-2">Cancel</a>
                        <button type="submit" class="btn btn-primary col-5">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        <script>
            $(document).ready(function () {
                var sale_stage=$('#full_sale_stage option:selected').val();
                if(sale_stage=="Lost"){
                    $('#reason').show();
                }else {
                    $('#reason').hide();
                }
                $('#full_sale_stage').on('change',function () {
                    var sale_stage=$('#full_sale_stage option:selected').val();
                    if(sale_stage=="Lost"){
                        $('#reason').show();
                    }else {
                        $('#reason').hide();
                    }
                })
            });
            $(document).ready(function () {
                var selet_contact=$('#full_contact option:selected').val();
               @foreach($allcustomers as $customer)
                    if(selet_contact=={{$customer->id}}){
                        var lead_title="{{$customer->lead_title}}";
                        $('#lead_title').val(lead_title);
               }
                @endforeach
                $('#full_contact').on('change',function () {
                    var selet_contact=$('#full_contact option:selected').val();
                    @foreach($allcustomers as $customer)
                    if(selet_contact=={{$customer->id}}){
                        var lead_title="{{$customer->lead_title}}";
                        $('#lead_title').val(lead_title);
                    }
                    @endforeach
                })
            });

            ClassicEditor.create($('#description')[0], {
                toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
            });
            $(document).ready(function () {
                $('select').select2();
            });

        </script>
@endsection
