@extends('layout.mainlayout')
@section('name', 'Customer Create')
@section('content')
    <!-- Page Header -->
    <div class="content container-fluid">
    {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
    @include('layout.partials.breadcrumb',['header'=>'Contact Edit Form'])
    <!-- /Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form action="{{route('customers.update',$record->id)}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card-body rounded bg-light">
                                        <div class="d-flex justify-content-center mt-5">
                                            <div class="text-center my-2">
                                                <input type="file" id="file1" accept="image/*" name="profile_img"
                                                       class="offset-md-1" onchange="loadFile(event)"
                                                       style="display:none"/>
                                                <img id="output" onClick="openSelect('#file1')"
                                                     class="rounded mt-2 mb-4"
                                                     src="{{$record->profile!=null? url(asset('img/profiles/'.$record->profile)):''}}"
                                                     width="100px" height="100px;" alt=""><br>
                                                <input type="hidden" name="oldpic" value="{{$record->profile}}">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mt-2 mb-5">
                                            <p class="mb-0 text-muted font-weight-bold">Upload Image</p>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label for="bio" class="form-label font-weight-bold text-muted text-uppercase">Bio</label>
                                        <textarea name="bio" class="form-control" id="bio" rows="10"
                                                  placeholder="Enter Bio">{{$record->bio}}</textarea>
                                    </div>
                                    <div class="col-md-12 my-3">
                                        <label class="form-label font-weight-bold text-muted text-uppercase">Gender<span
                                                    class="text-danger">*</span></label><br>
                                        <div class="form-check form-check-inline">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="male" name="gender" value="Male"
                                                       class="custom-control-input" checked>
                                                <label class="custom-control-label" for="male"><i
                                                            class="fa fa-male"></i> Male </label>
                                            </div>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="female" name="gender" value="Female"
                                                       class="custom-control-input">
                                                <label class="custom-control-label" for="female"><i
                                                            class="fa fa-female"></i> Female </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row g-3 date-icon-set-modal">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="name"
                                                       class="form-label font-weight-bold text-muted text-uppercase">Full
                                                    Name<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                                    </div>
                                                    <input type="text" name="name" class="form-control" id="name"
                                                           placeholder="Enter Full Name" required
                                                           value="{{$record->name}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-12">
                                            <label for="credit">Credit Limit</label>
                                            <input type="number" class="form-control" name="credit_limit" id="credit" value="{{$record->credit_limit??0.0}}">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="branch">Branch</label>
                                                <div class="input-group">
                                                    <select name="branch_id" id="branch" class="form-control">
                                                        <option value="">None</option>
                                                        @foreach($branch as $item)
                                                            <option value="{{$item->id}}" {{$record->branch_id==$item->id?'selected':''}}>{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cus_region_id">Region</label>
                                                <select name="region_id" id="cus_region_id" class="form-control" onchange="childregion(this.value);">
                                                    <option value="">None</option>
                                                    @foreach($region as $item)
                                                        <option value="{{$item->id}}" {{$record->region_id==$item->id?'selected':''}}>{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="zone">Sale Zone</label>
                                                <div class="input-group">
                                                    <select name="zone_id" id="zone_id" class="form-control">
                                                        @foreach($zone as $item)
                                                            <option value="{{$item->id}}" {{$record->zone_id==$item->id?'selected':''}} data-option="{{$item->region_id}}">{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-white" data-toggle="modal" data-target="#add_zone"><i class="la la-plus"></i></button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3 position-relative">
                                            <div class="form-group">
                                                <label for="bod"
                                                       class="form-label font-weight-bold text-muted text-uppercase">Birth
                                                    Day</label>
                                                <div class="input-group">
                                                    <input type="date"
                                                           class="form-control vanila-datepicker datepicker-input"
                                                           id="bod" name="dob" placeholder="Enter Birth Day"
                                                           value="{{\Carbon\Carbon::parse($record->dob)->format('Y-m-d')}}" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="company_id"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Company
                                                Name<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-building"></i></span>
                                                </div>
                                                <select name="company_id" id="company_id" class="form-control">
                                                    @foreach($companies as $key=>$val)
                                                        <option value="{{$key}}" {{$key==$record->company_id?'selected':''}}>{{$val}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Email<span
                                                        class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="email" name="email"
                                                       value="{{$record->email}}" placeholder="Enter Email" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="phone"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Phone<span
                                                        class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                       placeholder="Enter Phone" value="{{$record->phone}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="address"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Address</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-map-o"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="address" name="address"
                                                       placeholder="Enter Address" value="{{$record->address}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="report_to"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Report
                                                Person</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="report_to" name="report_to"
                                                       placeholder="Enter report person name"
                                                       value="{{$record->report_to}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="position"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Report
                                                Person's Position</label>
                                            <input type="text" class="form-control" id="position" name="position_of_report_to"
                                                   placeholder="Enter report person's position"
                                                   value="{{$record->position_of_report_to}}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="fb"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Facebook</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-facebook"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="fb" name="facebook"
                                                       placeholder="Enter facebook link" value="{{$record->facebook}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="linkedin"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Linkedin</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-linkedin"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="linkedin" name="linkedin"
                                                       placeholder="Enter Linkedin link" value="{{$record->linkedin}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3" id="refesh_div">
                                    <label for="customer_type"
                                           class="form-label font-weight-bold text-muted text-uppercase">
                                        Type</label>
                                    <select name="customer_type" id="customer_type" class="form-control">
                                        <option value="Customer" {{$record->customer_type=='Customer'?'selected':''}}>Customer</option>
                                        <option value="Lead" {{$record->customer_type=='Lead'?'selected':''}}>Lead</option>
                                        <option value="In Query" {{$record->customer_type=='In Query'?'selected':''}}>In Query</option>
                                        <option value="Partner" {{$record->customer_type=='Partner'?'selected':''}}>Partner</option>
                                        <option value="Competitor" {{$record->customer_type=='Competitor'?'selected':''}}>Competitor</option>
                                        <option value="Supplier" {{$record->customer_type=='Supplier'?'selected':''}}>Supplier</option>
                                        <option value="Courier" {{$record->customer_type=='Courier'?'selected':''}}>Courier</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="dept" class="form-label font-weight-bold text-muted text-uppercase">Department</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-users"></i></span>
                                            </div>
                                            <input type="text" id="dept" name="department" class="form-control"
                                                   placeholder="Enter Contact Department" value="{{$record->department}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="position"
                                               class="form-label font-weight-bold text-muted text-uppercase">Position</label>
                                        <input type="text" id="position" name="position" class="form-control"
                                               placeholder="Enter Contact Position" value="{{$record->position}}">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3" id="title">
                                    <label for='title'
                                           class='form-label font-weight-bold text-muted text-uppercase pro_label'>Title </label>
                                    <div class='input-group' id='priority_field'>
                                        <div class='input-group-prepend'>
                        <span class='input-group-text'><i class='fa fa-arrow-circle-down'></i>
                        </span>
                                        </div>
                                        <input type='text' class='form-control' name='title' value="{{$record->lead_title}}"></div>
                                </div>
                                <div class="col-md-4 mb-3" id="priority">
                                    <label for="Text6"
                                           class="form-label font-weight-bold text-muted text-uppercase pro_label">Priority</label>
                                    <div class="input-group" id="priority_field">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                        class="fa fa-arrow-circle-down"></i></span>
                                        </div>
                                        <select name="priority" id="priority_type" class="form-control">
                                            <option value="High">High</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3" id="tag_industry">
                                    <label for="Text6"
                                           class="form-label font-weight-bold text-muted text-uppercase pro_label">Industry</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-tag"></i></span>
                                        </div>
                                        <select name="tag_industry" id="industry" class="form-control">
                                            @foreach($tags as $tag)
                                                @if($tag->id==$last_tag->id)
                                                    <option value="{{$tag->id}}"
                                                            selected>{{$tag->tag_industry}}</option>
                                                @else
                                                    <option value="{{$tag->id}}">{{$tag->tag_industry}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="input-group-prepend">
                                            <a href="" class="input-group-text" data-toggle='modal'
                                               data-target='#industry_add'><i
                                                        class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3" id="status">
                                    <label for="Text6"
                                           class="form-label font-weight-bold text-muted text-uppercase pro_label">Status</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-user-secret"></i>
                    </span>
                                        </div>
                                        <select name="status" id="status" class="form-control">
                                            <option value="New" {{$record->status=='New'?'selected':''}}>New</option>
                                            <option value="Qualified" {{$record->status=='Qualified'?'selected':''}}>Qualified</option>
                                            <option value="Unqualified" {{$record->status=='Unqualified'?'selected':''}}>Unqualified</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="checkbox" name="canlogin"
                                       id="canlogin" {{$record->can_login?'checked':''}} ><label for="canlogin"
                                                                                                 class="ml-1">Can
                                    login</label>
                            </div>

                        </div>
                        <div class="d-flex justify-content-end mt-3 border-top">
                            <button type="submit" class="btn btn-primary mt-3">
                                Update
                            </button>
                        </div>
                </div>
                </form>
                @include('customer.addzone')
                <div id="industry_add" class="modal custom-modal fade" data-backdrop="true" tabindex="-1" role="dialog"
                     style="overflow:hidden">
                    <div class="modal-dialog modal-dialog modal-sm modal-dialog-centered">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Industry</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="tags">Tags</label>
                                    <input type="text" id="tags" class="form-control" name="tags">
                                </div>
                                <button type="button" data-dismiss="modal" id="tags_create"
                                        class="btn btn-primary float-right">Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        $(document).ready(function () {
            $('select').select2();
        });
        var loadFile = function (event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };

        function openSelect(file) {
            $(file).trigger('click');
        }
        $(document).ready(function () {
            var customer_type = $('#customer_type option:selected').val();
            if(customer_type=='Lead'){
                $('#title').show();
                $('#priority').show();
                $('#tag_industry').show();
                $('#status').show();
            }else{
                $('#title').hide();
                $('#priority').hide();
                $('#tag_industry').hide();
                $('#status').hide();
            }

            $('#customer_type').on('change', function () {
                var customer_type = $('#customer_type option:selected').val();
                if (customer_type == "Lead") {
                    $('#title').show();
                    $('#priority').show();
                    $('#tag_industry').show();
                    $('#status').show();

                } else {
                    $('#title').hide();
                    $('#priority').hide();
                    $('#tag_industry').hide();
                    $('#status').hide();

                }
            })
        });
        $(document).ready(function () {
            $(document).on('click', '#tags_create', function () {
                var tags = $("#tags").val();
                $.ajax({
                    type: 'POST',
                    data: {tag_industry: tags},
                    url: '/tags/create',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        console.log(data);
                        window.location.href = "/customers/{{$record->id}}/edit";
                    }
                });
            });
        });

        var main = document.querySelector('#cus_region_id');
        var child = document.querySelector('#zone_id');
        var zone_optoion = child.querySelectorAll('option');
        // console.log(options3);
        // alert(product)
        function childregion(selValue) {
            zone_id.innerHTML='';

            for(var i = 0; i < zone_optoion.length; i++) {
                if(zone_optoion[i].dataset.option === selValue) {
                    zone_id.appendChild(zone_optoion[i]);

                }
            }
        }
        childregion(main.value);
    </script>
@endsection
