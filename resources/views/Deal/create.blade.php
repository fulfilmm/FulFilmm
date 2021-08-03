@extends('layout.mainlayout')
@section('content')
    <style>
        .scoll{
            height: 490px;
            overflow: scroll;
        }

    </style>
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

            <!-- Content Starts -->
            @include('Deal.quickform')
            <!-- /Content End -->
            @include('Deal.fullform')
            @include('Deal.add_company')
            @include('Deal.add_customer')
            <script>
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
                                user_company:user_company,
                            },
                            url:"{{route('company_create')}}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success:function(data){
                                // window.location.href = "/deal";
                                console.log(data);
                                $("#org_div").load(location.href + " #org_div>* ");
                                $("#full_org_div").load(location.href + " #full_org_div>* ");
                            }
                        });
                    });
                });
                $(document).ready(function() {
                    $(document).on('click', "#quick_save", function () {
                        var name=$("#deal_name").val();
                        var amount=$("#amount").val();
                        var exp_close_date=$("#close_date").val();
                        var pipeline=$("#pipeline").val();
                        var sale_stage=$("#sale_stage").val();
                        var assign_to=$("#assign_to").val();
                        var lead_source=$("#lead_source").val();
                        var propability=$("#propability").val();
                        var org_name=$("#quick_org option:selected").val();
                        var currency=$("#unit").val();
                        $.ajax({
                            type:'POST',
                            data : {
                                currency:currency,
                                name:name,
                                amount:amount,
                                close_date:exp_close_date,
                                pipeline:pipeline,
                                sale_stage:sale_stage,
                                assign_to:assign_to,
                                lead_source:lead_source,
                                propability:propability,
                                org_name:org_name,
                                form_type:'quick'
                            },
                            url:"{{route('deals.store')}}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success:function(data){
                                console.log(data);
                                window.location.href = "/deals";
                            }
                        });
                    });
                });

                $(document).ready(function() {
                    $(document).on('click', '#full_form_save', function () {
                        var name=$("#full_form_name").val();
                        var amount=$("#full_form_amount").val();
                        var unit=$("#full_form_unit option:selected").val();
                        var org=$("#full_org option:selected").val();
                        var contact=$("#full_contact option:selected").val();
                        var exp_date=$("#full_exp_date").val();
                        var pipeline=$("#full_pipeline option:selected").val();
                        var sale_stage=$("#full_sale_stage option:selected").val();
                        var asign_to=$("#full_assign_to option:selected").val();
                        var lead_source=$("#full_lead_source option:selected ").val();
                        var next_step=$("#next_step").val();
                        var type=$("#full_type option:selected").val();
                        var probability=$("#full_probability").val();
                        // var camping_source=$("#camp_source option:selected").val();
                        var weight_revenue=$("#weight_revenue ").val();
                        var revenue_unit=$("#revenue_unit option:selected").val();
                        var lost_reason=$("#lost_reason option:selected").val();
                        var description=$('#description').text();
                        $.ajax({
                            data : {
                                name:name,
                                amount:amount,
                                unit:unit,
                                full_org:org,
                                contact:contact,
                                exp_date:exp_date,
                                pipeline:pipeline,
                                sale_stage:sale_stage,
                                asign_to:asign_to,
                                lead_source:lead_source,
                                next_step:next_step,
                                probability:probability,
                                // camping_source:camping_source,
                                weight_revenue:weight_revenue,
                                revenue_unit:revenue_unit,
                                lost_reason:lost_reason,
                                description:description,
                                type:'full',
                            },
                            type:'POST',
                            url:"{{route('deals.store')}}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success:function(data){
                                window.location.href = "/deals";
                                console.log(data);
                                // $("#org_div").load(location.href + " #org_div>* ");
                                // $("#full_org_div").load(location.href + " #full_org_div>* ");
                            }
                        });
                    });
                });
            </script>
@endsection
