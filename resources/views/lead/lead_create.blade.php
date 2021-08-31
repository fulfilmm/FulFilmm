@extends('layout.mainlayout')
@section("title","Lead Create")
@section('content')
    <style>
         a[aria-expanded=true] .fa-chevron-circle-right {
             display: none;
         }
        a[aria-expanded=false] .fa-chevron-circle-down {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <!-- Page Wrapper -->
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Leads</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Lead</li>
                            <li class="breadcrumb-item active">Create</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Page Header -->
            <!--Main Content -->
               <div class="my-5">
                   <form action="{{route("leads.store")}}" method="POST">
                       {{csrf_field()}}
                       <div class="row">
                           <div class="form-group col-md-4 col-xl-4 col-12">
                               <label for="">Lead ID <span class="text-danger">*</span></label>
                               <input type="text" class="form-control" name="lead_id" value="{{$lead_id}}" readonly>
                           </div>
                           <div class="form-group col-md-4 col-xl-4 col-12">
                               <label for="">Lead Title <span class="text-danger">*</span></label>
                               <input type="text" class="form-control" name="lead_title" required>
                           </div>
                           <div class="form-group col-md-4 col-xl-4 col-12">
                               <label for="">Sale Man <span class="text-danger">*</span></label>
                             <div class="col-md-12 col-12">
                                <div class="row">
                                    <select name="sale_man" id="saleman" class="form-control" required>
                                        @foreach($allemployees as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                             </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="form-group col-md-4 col-xl-4 col-12">
                               <label for="">Customer Name <span class="text-danger">*</span></label>
                              <div class="col-12">
                                  <div class="row " id="customer">
                                      <select name="customer_id" id="add_customer" class="form-control col-md-12" required>
                                          <option value="">Select Customer Name</option>
                                          @foreach($allcustomers as $key=>$value)
                                              <option value="{{$key}}">{{$value}}</option>
                                          @endforeach
                                      </select>
{{--                                      <div class="col-md-2 col-2 mt-1">--}}
{{--                                          <a  href='#' data-toggle='modal' class="btn btn-outline-dark" data-target='#add_new_ustomer'><i class="fa fa-plus"></i></a>--}}
{{--                                      </div>--}}
                                  </div>
                              </div>
                           </div>
{{--                           <a href="{{url("client/customer/create")}}"><i class="fa fa-plus"></i></a>--}}
                           <div class="form-group col-md-4 col-xl-4 col-12" id="tagdiv" >
                               <label for="category" >Industry <span class="text-danger">*</span></label>
                               <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-10 col-10">
                                                <div class="row">
                                                <select name="tags" id="industry" class="form-control " required>
                                                    @foreach($tags as $tag)
                                                        @if($tag->id==$last_tag->id)
                                                            <option value="{{$tag->id}}" selected>{{$tag->tag_industry}}</option>
                                                        @else
                                                            <option value="{{$tag->id}}">{{$tag->tag_industry}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-2 mt-1">
                                                <a data-toggle='modal' class="btn btn-outline-dark" data-target='#industry_add'><i class="fa fa-plus"></i></a>
                                            </div>
                                   </div>
                               </div>
                           </div>
                           <div class="form-group col-md-4 col-xl-4 col-12">
                               <label for="">Organization Name</label>
                               <input type="text" class="form-control" name="org_name">
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-md-4 col-xl-4 col-12">
                               <div class="form-group">
                                   <label for="">Priority</label>
                                   <select name="priority" id="" class="select">
                                       <option value="High">High</option>
                                       <option value="Medium">Medium</option>
                                       <option value="Low">Low</option>
                                   </select>
                               </div>
                           </div>
                           <div class="col-md-4 col-xl-4 col-12">
                               <label for="">Qualify Status</label>
                               <div class="form-check form-switch">
                                   <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="qualified">
                                   <label class="form-check-label" for="flexSwitchCheckDefault">Qualified</label>
                               </div>
                           </div>
                           <div class="col-md-4 col-xl-4 col-12">
                                   <input type="radio" name="type" value="1" checked>
                               <label>Lead</label>
                               <input type="radio" name="type" value="0" class="custom-radio mr-2 ml-5"><label for="">Inquery</label>

                           </div>
                       </div>

                       <textarea name="description" id="description"  rows="10" style="width:100%;" required>
                    </textarea>
                       <div class="form-group text-center mt-4">
                           <button type="submit " class="btn btn-primary">Submit</button>
                       </div>
                   </form>
               </div>
        </div>
        <div id="industry_add" class="modal custom-modal fade" data-backdrop="false" tabindex="-1" role="dialog" style="overflow:hidden">
            <div class="modal-dialog modal-dialog modal-sm">
                <div class="modal-content" style="background-color: #dee0e0">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Industry</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="form-group">
                                        <label>Tags</label>
                                        <input type="text" id="tags" class="form-control" name="tags" >
                                </div>
                        <button type="button" data-dismiss="modal" id="tags_create"  class="btn btn-primary float-right">Save</button>
                            </div>
                    </div>
                </div>
            </div>
{{--        <div class="modal custom-modal rounded"  id="add_new_ustomer">--}}
{{--            <div class="modal-dialog modal-md" role="document">--}}
{{--                <div class="modal-content">--}}
{{--                    <div class="modal-header">--}}
{{--                        <h4 class="modal-title">Add Contact</h4>--}}
{{--                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>--}}
{{--                    </div>--}}
{{--                    <div class="container " >--}}
{{--                        <div class="modal-body">--}}
{{--                            <form action="{{route('customers.store')}}" method="POST" >--}}
{{--                                @csrf--}}
{{--                                @include('customer.form')--}}
{{--                                <div class="input-group-append">--}}
{{--                                    <button class="btn btn-primary" type="submit">Submit</button>--}}
{{--                                </div>--}}
{{--                                </button>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    <!-- /Page Wrapper -->
{{--    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>--}}
        <script>
            ClassicEditor
                .create( document.querySelector( '#description' ) );

            $(document).ready(function() {
                $('#customer_company').select2();
            });
            $(document).ready(function() {
                $('#customer_position').select2();
            });
            $(document).ready(function() {
                $('#industry').select2({
                        "language": {
                            "noResults": function(){
                                return "<i class='text-danger'>Add New with Plus Button!<i>";
                            }
                        },
                        escapeMarkup: function (markup) {
                            return markup;
                        }

                    }

                );
            });
            $(document).ready(function() {
                $(document).on('click', '#add_contact', function () {

                    var customer_id=$("#customer_id").val();
                    var customer_name =$("#customer_name ").val();
                    var customer_phone=$("#customer_phone").val();
                    var customer_email=$("#customer_email").val();
                    var customer_company=$("#customer_company").val();
                    var customer_dept=$("#customer_dept").val();
                    var customer_position=$("#customer_position option:selected").val();
                    var customer_report_to=$("#customer_report_to").val();
                    var customer_address=$("#customer_address").val();
                    var customer_admin_company=$("#customer_admin_company").val();
                    var type="ajax";
                    $.ajax({
                        data : {
                            customer_id:customer_id,
                            name:customer_name,
                            phone:customer_phone,
                            email:customer_email,
                            company_id:customer_company,
                            department:customer_dept,
                            position:customer_position,
                            report_to:customer_report_to,
                            address:customer_address,
                            admin_company:customer_admin_company,
                            type:type
                        },
                        type:'POST',
                        url:"{{url("client/customer/create/")}}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success:function(data){
                            console.log(data);
                            $("#customer").load(location.href + " #customer>* ");
                            $("#add_customer").load(location.href + " #add_customer>* ");

                        }
                    });
                });
            });
            $(document).ready(function() {
                $('#add_customer').select2({
                        "language": {
                            "noResults": function(){
                                return "<a href='{{route('customers.create')}}'>Not Found.Add New !</a>";
                            }
                        },
                        escapeMarkup: function (markup) {
                            return markup;
                        }

                    }

                );
            });
            $(document).ready(function() {
                $('#saleman').select2({
                        "language": {
                            "noResults": function(){
                                return "<a href='{{route('employees.create')}}'>Not Found.Add New !</a>";
                            }
                        },
                        escapeMarkup: function (markup) {
                            return markup;
                        }

                    }

                );
            });

            // $(document).ready(function() {
            //     $(document).change(function (){
            //         var indust=$(".select2-search__field").val();
            //         $('#tags').val($('.select2-search__field').val());
            //     })
            //
            // });
            $(document).ready(function() {
                $(document).on('click', '#tags_create', function () {
                    var tags=$("#tags").val();
                    $.ajax({
                        type:'POST',
                        data : {tag_industry:tags},
                        url:'/tags/create',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success:function(data){
                            console.log(data);
                            $("#tagdiv").load(location.href + " #tagdiv>* ");
                        }
                    });
                });
            });

            $("#review").rating({
                "value": 0,
                "stars": 3,
                "click": function (e) {
                    console.log(e);
                    $("#starsInput").val(e.stars);
                }
            });
            $("#check").on("click", function(){
                if($("#check").is(":checked")){
                    $("button").remove();
                   $("#button").append("<button  class='btn btn-outline-primary float-right mb-3 mt-3' type='submit'>Save and Qualified</button>");
                }else {
                    $("button").remove();
                    $("#button").append("<button  class='btn btn-outline-primary float-right mb-3 mt-3' type='submit'>Save</button>");

                }
            });
        </script>
@endsection
