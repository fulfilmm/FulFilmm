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
                    <h3 class="page-title">Deal Add</h3>
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
            <form action="{{route('deals.update',$deal->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="full_form_name">Deal Name <span class="text-danger"> * </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-file"></i></span>
                                    </div>
                                    <input type="text" id="full_form_name" name="name" value="{{$deal->name}}"
                                           class="form-control " placeholder="Enter Deal Name..">

                                </div>
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="full_form_amount">Amount <span class="text-danger"> * </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-money"></i></span>
                                    </div>
                                    <input type="number" id="full_form_amount" name="amount" class="form-control" value="{{$deal->amount}}">
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
                                        <option value="MMK" {{$deal->unit=="MMK"?'selected':''}}>MMK</option>
                                        <option value="USD" {{$deal->unit=="USD"?'selected':''}}>USD</option>
                                    </select>
                                </div>
                                @error('unit')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="form-group" id="contact_div">
                                <label for="full_contact">Contact Name <span class="text-danger"> * </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <select name="contact_name" id="full_contact" class="form-control">
                                        @foreach($allcustomers as $key=>$value)
                                            <option value="{{$key}}" {{$key==$deal->contact?'selected':''}}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" data-toggle="modal" href="#add_contact" class="btn btn-outline-dark"><i
                                                class="fa fa-plus"></i></button>
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
                                    <input type="date" id="full_exp_date" name="exp_date" class="form-control" value="{{\Carbon\Carbon::parse($deal->close_date)->format('Y-m-d')}}">
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
                                    <input type="number" name="probability" id="full_probability" class="form-control" value="{{$deal->probability}}">
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
                                <select name="pipeline" id="full_pipeline" class="select col-md-10" style="width: 85%">
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
                                    <select name="sale_stage" id="full_sale_stage" class="select " style="width: 85%">
                                        <option value="New" {{$deal->sale_stage=='New'?'selected':''}}>New</option>
                                        <option value="Qualified" {{$deal->sale_stage=='Qualified'?'selected':''}}>Qualified</option>
                                        <option value="Quotation" {{$deal->sale_stage=='Quotation'?'selected':''}}>Quatation</option>
                                        <option value="Invoicing" {{$deal->sale_stage=='Invoicing'?'selected':''}}>Invoicing</option>
                                        <option value="Win" {{$deal->sale_stage=='Win'?'selected':''}}>Negotiation</option>
                                        <option value="Lost" {{$deal->sale_stage=='Lost'?'selected':''}}>Lost</option>
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
                                    <select name="assign_to" id="full_assign_to" class="select">
                                        @foreach($allemployees as $emp)
                                            <option value="{{$emp->id}}" {{$emp->id==$deal->assign_to?'selected':''}}>{{$emp->name}}</option>
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
                                    <select name="lead_source" id="full_lead_source" class="select">
                                        @foreach($lead_source as $key=>$val)
                                            <option value="{{$val}}" {{$val==$deal->lead_source?'selected':''}}>{{$val}}</option>
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
                                    <input type="text" id="next_step" name="next_step" class="form-control" value="{{$deal->next_step}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="full_type">Type</label>
                                <div class="input-group">
                                    <select name="type" id="full_type" class="select">
                                        <option value="Existing Business" {{$deal->type=="Existing Business"?'selected':''}}>Existing Business</option>
                                        <option value="New Business" {{$deal->type=="New Business"?'selected':''}}>New Business</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12" id="reason">
                            <div class="form-group">
                                <label for="lost_reason">Lost Reason</label>
                                <div class="input-group">
                                    <select name="lose_reason" id="lost_reason" class="select">
                                        <option value="Price" {{$deal->lost_reason=='Price'?'selected':''}}>Price</option>
                                        <option value="Authority" {{$deal->lost_reason=='Authority'?'selected':''}}>Authority</option>
                                        <option value="Timing" {{$deal->lost_reason=='Timing'?'selected':''}}>Timing</option>
                                        <option value="Missing Feature" {{$deal->lost_reason=='Missing Feature'?'selected':''}}>Missing Feature</option>
                                        <option value="Usability" {{$deal->lost_reason=='Usability'?'selected':''}}> Usability</option>
                                        <option value="Unknown" {{$deal->lost_reason=='Unknown'?'selected':''}}> Unknown</option>
                                        <option value="No need" {{$deal->lost_reason=='No need'?'selected':''}}>No Need</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description"> Description </label>
                        <textarea name="description" id="description" style="width: 100%" rows="10">{{$deal->description}}</textarea>
                    </div>
                    <div class="input-group text-center col-md-6 col-12 offset-md-3">
                        <a href="{{route('deals.index')}}" class="btn btn-danger col-5 mr-2">Cancel</a>
                        <button type="submit" class="btn btn-primary col-5">Save</button>
                    </div>
                </div>
            </form>
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
            ClassicEditor
                .create(document.querySelector('#description'));
            $(document).ready(function () {
                $('select').select2();
            });
        </script>
@endsection
