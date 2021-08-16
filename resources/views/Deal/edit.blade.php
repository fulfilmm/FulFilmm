@extends('layout.mainlayout')
@section("title",'Deal Edit')
@section('content')

        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Deal Edit</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{url("deal")}}">Deal</a></li>
                            <li class="breadcrumb-item active">Deal Edit</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Content Starts -->
            <form action="{{route('deals.update',$deal->id)}}" method="POST">
                @csrf
                @method('PUT')
            <div class="card ">
                <div class="col-12 my-3">
                    <div class="col-12 my-3">
                    <div class="row my-3">
                        <div class="col-md-2">
                            <label for="full_form_name" >Deal Name</label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" id="full_form_name" name="deal_name" class="form-control" value="{{$deal->name}}">
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <label for="amount">Amount</label>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="input-group">
                                <input type="number" id="amount" name="amount" class="form-control"value="{{$deal->amount}}" aria-describedby="basic-addon2">
                                    <select name="unit" name="unit" id="full_form_unit" class="form-control">
                                    @if($deal->unit=="MMK")
                                        <option value="MMK" selected>MMK</option>
                                        <option value="USD">USD</option>
                                    @else
                                        <option value="MMK">MMK</option>
                                        <option value="USD" selected>USD</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-2 col-12 mt-3">
                            <label for="full_org" >Organization</label>
                        </div>
                        <div class="col-md-4 col-12" id="edit_org_div">
                            <div class="input-group">
                                <select name="org_name" id="full_org" class="form-control">
                                    @foreach($companies as $key=>$value)
                                        @if($deal->org_name==$key)
                                            <option value="{{$key}}" selected>{{$value}}</option>
                                        @else
                                            <option value="{{$key}}" >{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <a data-toggle="modal" href="#add_company"  class="btn btn-outline-dark"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="col-md-2 col-12 mt-3">
                            <label for="full_contact">Contact Name</label>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="input-group" id="contact_div" >
                                <select name="contact_name" id="full_contact"  class=" form-control">
                                    @foreach($allcustomers as $client)
                                        @if($client->id==$deal->contact)
                                            <option value="{{$client->id}}" selected>{{$client->name}}</option>
                                        @else
                                            <option value="{{$client->id}}">{{$client->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <a data-toggle="modal" href="#add_user"  class="btn btn-outline-dark"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-2 mt-3">
                            <label for="full_exp_date" >Expected Close Date</label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="date" id="full_exp_date" name="exp_date" class="form-control"  value="{{\Carbon\Carbon::parse($deal->close_date)->format('Y-m-d')}}">
                            </div>
                        </div>
                        <div class="col-md-2 mt-3"><label for="full_pipeline">Pipeline</label></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="pipeline" id="full_pipeline" class="form-control ">
                                    @if($deal->pipeline=="Standard")
                                        <option value="Standard" selected>Standard</option>
                                    @else
                                    @endif
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-2 mt-3">
                            <label for="full_sale_stage" >Sale Stage</label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="sale_stage" id="full_sale_stage" class="form-control ">
                                    @foreach($sale_stage as $key=>$value)
                                        @if($deal->sale_stage==$value)
                                            <option value="{{$value}}" selected>{{$value}}</option>
                                        @else
                                          <option value="{{$value}}">{{$value}}</option>
                                      @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 mt-3"><label for="full_assign_to">Assigned To
                            </label></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="assign_to" id="full_assign_to" class="form-control">
                                    @foreach($allemployees as $emp)
                                        @if($emp->id==$deal->assign_to)
                                            <option value="{{$emp->id}}" selected>{{$emp->name}}</option>
                                        @else
                                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-2 mt-3">
                            <label for="full_lead_source" >Lead Source</label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="lead_source" id="full_lead_source" class="form-control">
                                    @foreach($lead_sources as $key=>$value)
                                        @if($deal->lead_source==$value)
                                            <option value="{{$value}}" selected>{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 mt-3">
                            <label for="next_step">Next Step</label></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" id="next_step" name="next_step" value="{{$deal->next_step}}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-2 mt-3">
                            <label for="full_type" >Type</label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="type" id="full_type" class="form-control">
                                        <option value="Existing Business" {{$deal->type=="Existing Business" ? 'selected' : ''}}>Existing Business</option>
                                        <option value="New Business" {{$deal->type=="New Business" ? 'selected' : ''}}>New Business</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-12 mt-3">
                            <label for="probability">Probability</label></div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="number" id="probability" name="probality" class="form-control" value="{{$deal->probability}}" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-2 mt-3">
                            <label for="weight_revenue">Weighted Revenue</label></div>
                        <div class="col-md-4">
                           <div class="input-group">
                                <input type="number" name="revenue" id="weight_revenue" value="{{$deal->weighted_revenue}}" class="form-control col-8">
                                <select name="revenue_unit" id="revenue_unit" class="form-control col-4">
                                    @if($deal->weighed_revenue_unit=="MMK")
                                        <option value="MMK" selected>MMK</option>
                                        <option value="USD">USD</option>
                                    @else
                                        <option value="MMK">MMK</option>
                                        <option value="USD" selected>USD</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 mt-3">
                            <label for="lost_reason" >Lost Reason</label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="lost_reason" id="lost_reason" class="form-control ">
                                   @foreach($lost_reason as $key=>$value)
                                    @if($deal->lost_reason==$value)
                                            <option value="{{$value}}" selected>{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <label for="description">Description </label>
                </div>
                <div class="mx-3 my-3">
                    <textarea name="description" id="description" style="width: 100%" rows="10">{{$deal->description}}</textarea>
                </div>
            </div>
            <div class="form-group text-center">
            <a href="#" data-dismiss="modal" class="btn btn-danger">Close</a>
            <button type="submit" href="#" id="save" class="btn btn-primary">Save</button>
            </div>
            </form>
            @include('Deal.add_company')
            @include('Deal.add_customer')
        </div>
        <!-- /Page Content -->
    <!-- /Page Wrapper -->
    <script>
        $(document).ready(function() {
            $(document).on('click', '#customer_add', function () {

                // var customer_id=$("#customer_id").val();
                var customer_name =$("#customer_name").val();
                var customer_phone=$("#customer_phone").val();
                var customer_email=$("#customer_email").val();
                var customer_company=$("#customer_company_id option:selected").val();
                var customer_address=$("#customer_address").text();
                $.ajax({
                    data : {
                        name:customer_name,
                        phone:customer_phone,
                        email:customer_email,
                        company_id:customer_company,
                        address:customer_address
                    },
                    type:'POST',
                    url:"{{route('add_new_customer')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(data){
                        console.log(data);
                        $("#contact_div").load(location.href + " #contact_div>* ");

                    }
                });
            });
        });
        $(document).ready(function() {
            $(document).on('click', '#create_com', function () {
                var name=$("#name").val();
                var business_type=$("#business_type option:selected").val();
                var phone=$("#phone").val();
                var address=$("#address").val();
                var mission=$("#mission").val();
                var vision=$("#vision").val();
                var email=$("#email").val();
                var ceo=$("#ceo_name").val();
                var registry=$("#company_registry").val();
                var linkedin=$("#linkedin").val();
                var web_link=$("#web_link").val();
                var user_company=$("#user_company").val();
                var facebook_page=$("#facebook_page").val();
                var parent_company=$("#parent_company option:selected").val();
                var parent_company_2=$("#parent_company_2 option:selected").val();
                $.ajax({
                    type:'POST',
                    data : {
                        name:name,
                        business_type:business_type,
                        phone:phone,
                        address:address,
                        mission:mission,
                        vision:vision,
                        email:email,
                        ceo_name:ceo,
                        company_registry:registry,
                        linkedin:linkedin,
                        web_link:web_link,
                        facebook_page:facebook_page,
                        parent_company:parent_company,
                        parent_company_2:parent_company_2,
                        user_company:user_company
                    },
                    url:"{{route('company_create')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(data){
                        // window.location.href = "/deal";
                        console.log(data);
                        $("#edit_org_div").load(location.href + " #edit_org_div>* ");
                    }
                });
            });
        });
{{--        $(document).ready(function() {--}}
{{--            $('select').select2({--}}
{{--                    "language": {--}}
{{--                    },--}}
{{--                    escapeMarkup: function (markup) {--}}
{{--                        return markup;--}}
{{--                    }--}}
{{--                }--}}

{{--            );--}}

{{--        });--}}
{{--        $(document).ready(function() {--}}
{{--            $('#quick_org').select2({--}}
{{--                    "language": {--}}
{{--                    },--}}
{{--                    escapeMarkup: function (markup) {--}}
{{--                        return markup;--}}
{{--                    }--}}
{{--                }--}}

{{--            );--}}

{{--        });--}}
{{--        $(document).ready(function() {--}}
{{--            $('#full_org').select2({--}}
{{--                    "language": {--}}
{{--                    },--}}
{{--                    escapeMarkup: function (markup) {--}}
{{--                        return markup;--}}
{{--                    }--}}
{{--                }--}}

{{--            );--}}

{{--        });--}}
    </script>
@endsection
