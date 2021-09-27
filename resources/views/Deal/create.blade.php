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
                                <label for="full_form_amount">Amount <span class="text-danger"> * </span></label>
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
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="full_org">Organization <span class="text-danger"> * </span></label>
                                <div class="input-group" id="full_org">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-money"></i></span>
                                    </div>
                                    <select name="org_name" class="form-control">
                                        @foreach($companies as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-prepend">
                                        <button data-toggle="modal" href="#add_company"
                                                class="btn btn-outline-dark rounded"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                @error('org_name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group" id="full_org_div">
                                <label for="full_contact">Contact Name <span class="text-danger"> * </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <select name="contact_name" id="full_contact" class="form-control">
                                        @foreach($allcustomers as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <button data-toggle="modal" href="#add_user" class="btn btn-outline-dark"><i
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
                                    <select name="assign_to" id="full_assign_to" class="select">
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
                                    <select name="lead_source" id="full_lead_source" class="select">
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
                                    <select name="type" id="full_type" class="select">
                                        <option value="Existing Business">Existing Business</option>
                                        <option value="New Business">New Business</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="weight_revenue">Weighted Revenue</label>
                                <div class="input-group">
                                    <input type="number" name="revenue" id="weight_revenue" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="lost_reason">Lost Reason</label>
                                <div class="input-group">
                                    <select name="lose_reason" id="lost_reason" class="select">
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
        <script>
            $(document).ready(function () {
                $(document).on('click', '#customer_add', function () {

                    // var customer_id=$("#customer_id").val();
                    var customer_name = $("#customer_name").val();
                    var customer_phone = $("#customer_phone").val();
                    var customer_email = $("#customer_email").val();
                    var customer_company = $("#customer_company_id option:selected").val();
                    var customer_address = $("#customer_address").text();
                    $.ajax({
                        data: {
                            name: customer_name,
                            phone: customer_phone,
                            email: customer_email,
                            company_id: customer_company,
                            address: customer_address
                        },
                        type: 'POST',
                        url: "{{route('add_new_customer')}}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                            console.log(data);
                            $("#contact_div").load(location.href + " #contact_div>* ");

                        }
                    });
                });
            });
            $(document).ready(function () {
                $(document).on('click', '#create_com', function () {
                    var name = $("#name").val();
                    var business_type = $("#business_type option:selected").val();
                    var phone = $("#phone").val();
                    var address = $("#address").val();
                    var mission = $("#mission").val();
                    var vision = $("#vision").val();
                    var email = $("#email").val();
                    var ceo = $("#ceo_name").val();
                    var registry = $("#company_registry").val();
                    var linkedin = $("#linkedin").val();
                    var web_link = $("#web_link").val();
                    var user_company = $("#user_company").val();
                    var facebook_page = $("#facebook_page").val();
                    var parent_company = $("#parent_company option:selected").val();
                    var parent_company_2 = $("#parent_company_2 option:selected").val();
                    $.ajax({
                        type: 'POST',
                        data: {
                            name: name,
                            business_type: business_type,
                            phone: phone,
                            address: address,
                            mission: mission,
                            vision: vision,
                            email: email,
                            ceo_name: ceo,
                            company_registry: registry,
                            linkedin: linkedin,
                            web_link: web_link,
                            facebook_page: facebook_page,
                            parent_company: parent_company,
                            parent_company_2: parent_company_2,
                            user_company: user_company
                        },
                        url: "{{route('company_create')}}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                            // window.location.href = "/deal";
                            console.log(data);
                            $("#org_div").load(location.href + " #org_div>* ");
                            $("#full_org_div").load(location.href + " #full_org_div>* ");
                        }
                    });
                });
            });
            ClassicEditor
                .create(document.querySelector('#description'));
        </script>
    @include('Deal.add_company')
    @include('Deal.add_customer')
@endsection
