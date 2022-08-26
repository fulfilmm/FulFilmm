@extends('layout.mainlayout')
@section('title','Lead Create')
@section('content')
    <div class="content container-fluid">
    {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
    @include('layout.partials.breadcrumb',['header'=>'Add New Lead'])
    <!-- /Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <form action="{{route('customers.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class=" card shadow">
                            <div class="col-12 mt-5 mb-2">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="radio" name="existing_business" value="0" checked>
                                            <label for="">New Business</label>
                                            <input type="radio" name="existing_business" class="ml-5" value="1">
                                            <label for="">Existing Business</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row g-3 date-icon-set-modal">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name"
                                                           class="form-label font-weight-bold text-muted text-uppercase">Customer
                                                        Name<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                        class="fa fa-user"></i></span>
                                                        </div>
                                                        <input type="text" name="name" class="form-control" id="name"
                                                               placeholder="Enter Full Name" value="{{old('name')}}"
                                                               required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="title">
                                                <label for='title'
                                                       class='form-label font-weight-bold text-muted text-uppercase pro_label'>Lead
                                                    Title </label>
                                                <div class='input-group' id='priority_field'>
                                                    <input type='text' class='form-control' name='title'
                                                           value="{{old('title')}}"></div>
                                            </div>
                                            <div class="col-md-6 mb-3" id="priority">
                                                <label for="Text6"
                                                       class="form-label font-weight-bold text-muted text-uppercase pro_label">Priority</label>
                                                <div class="input-group" id="priority_field">
                                                    <select name="priority" id="priority_type" class="form-control"
                                                            style="width: 100%">
                                                        <option value="High" {{old('priority_type')=='High'?'selected':''}}>
                                                            High
                                                        </option>
                                                        <option value="Medium" {{old('priority_type')=='Medium'?'selected':''}}>
                                                            Medium
                                                        </option>
                                                        <option value="Low" {{old('priority_type')=='Low'?'selected':''}}>
                                                            Low
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3" id="status">
                                                <label for="Text6"
                                                       class="form-label font-weight-bold text-muted text-uppercase pro_label">Status</label>
                                                <div class="input-group">
                                                    <select name="status" id="status" class="form-control"
                                                            style="width:100% ;">
                                                        <option value="New" {{old('status')=='New'?'selected':''}}>New
                                                        </option>
                                                        <option value="Qualified" {{old('status')=='Qualified'?'selected':''}}>
                                                            Qualified
                                                        </option>
                                                        <option value="Unqualified" {{old('Unqualified')=='Unqualified'?'selected':''}}>
                                                            Unqualified
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="interest_level"  class="form-label font-weight-bold text-muted text-uppercase pro_label">Interest Level</label>
                                                    <select name="interest_level" id="interest_level" class="form-control select2">
                                                        <option value="Low">Low</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="High">High</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="interest_level"  class="form-label font-weight-bold text-muted text-uppercase pro_label">Product</label>
                                                    <select name="interest_level" id="interest_level" class="form-control select2">
                                                        <option value="">None</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3" id="tag_industry">
                                                <label for="Text6"
                                                       class="form-label font-weight-bold text-muted text-uppercase pro_label">Industry</label>
                                                <div class="input-group">
                                                    <select name="tag_industry" id="industry" class="form-control select2">
                                                        @foreach($tags as $tag)
                                                            @if($tag->id==$last_tag->id)
                                                                <option value="{{$tag->id}}"
                                                                        selected>{{$tag->tag_industry}}</option>
                                                            @else
                                                                <option value="{{$tag->id}}" {{old('tag_industry')==$tag->id?'selected':''}}>{{$tag->tag_industry}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <button type="button" class="btn btn-white" data-toggle='modal'
                                                            data-target='#industry_add'><i
                                                                class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
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
                                                               class="custom-control-input" {{old('gender')=='Female'?'checked':''}}>
                                                        <label class="custom-control-label" for="female"><i
                                                                    class="fa fa-female"></i> Female </label>
                                                    </div>
                                                </div>
                                                @error('gender')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="company_id"
                                                       class="form-label font-weight-bold text-muted text-uppercase">Company
                                                    Name<span class="text-danger">*</span></label>
                                                <div class="input-group" id="company_div">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                    class="fa fa-building"></i></span>
                                                    </div>
                                                    <select name="company_id" id="company_id"
                                                            class="form-control select2">
                                                        <option value="">None</option>
                                                        @foreach($companies as $key=>$val)
                                                            <option value="{{$key}}" {{$key==old('company_id')?'selected':''}}>{{$val}}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="button" data-toggle="modal"
                                                            data-target="#add_new_company" class="btn btn-white"><i
                                                                class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="email"
                                                       class="form-label font-weight-bold text-muted text-uppercase">Email<span
                                                            class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                    class="fa fa-envelope"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="email" name="email"
                                                           placeholder="Enter Email" value="{{old('email')}}" required>
                                                </div>
                                                @error('email')
                                                <span class="offset-md-3 text-danger" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="phone"
                                                       class="form-label font-weight-bold text-muted text-uppercase">Phone<span
                                                            class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                    class="fa fa-phone"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="phone" name="phone"
                                                           placeholder="Enter Phone">
                                                </div>
                                                @error('phone')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <input type="hidden" name="customer_type" value="Lead">
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="branch">Branch</label>
                                                    <select name="branch_id" id="branch_id"
                                                            class="form-control select2">
                                                        @foreach($branch as $item)
                                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('branch_id')
                                                    <span class="text-danger">Select the branch where the customer is located</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="region_id">Region</label>
                                                    <select name="region_id" id="region_id" class="form-control select2"
                                                            onchange="region_select(this.value)">
                                                        <option value="">None</option>
                                                        @foreach($region as $item)
                                                            <option value="{{$item->id}}" {{old('region_id')==$item->id?'selected':''}}>{{$item->name}}{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Super Admin'?'('.$item->branch->name.')':''}}</option>
                                                        @endforeach
                                                        @error('region_id')
                                                        <span class="text-danger">Select the region where the customer is located</span>
                                                        @enderror
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="zone">Sale Zone</label>
                                                    <div class="input-group">
                                                        <select name="zone_id" id="zone" class="form-control select2">
                                                            <option value="">None</option>
                                                            @foreach($zone as $item)
                                                                <option value="{{$item->id}}"
                                                                        data-option="{{$item->region_id}}" {{$item->id==old('zone_id')?'selected':''}}>{{$item->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-white"
                                                                    data-toggle="modal" data-target="#add_zone"><i
                                                                        class="la la-plus"></i></button>

                                                        </div>
                                                        @error('zone_id')
                                                        <span class="text-danger">Select the zone where the customer is located</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 card shadow">
                            <div class="row mt-5 mb-2">
                                <div class="col-md-6 mb-3 position-relative">
                                    <div class="form-group">
                                        <label for="bod"
                                               class="form-label font-weight-bold text-muted text-uppercase">Birth
                                            Day</label>
                                        <div class="input-group">
                                            <input type="date"
                                                   class="form-control vanila-datepicker datepicker-input"
                                                   id="bod" max="{{\Carbon\Carbon::today()->format('Y-m-d')}}"
                                                   name="bod" placeholder="Enter Birth Day"
                                                   autocomplete="off" value="{{old('bod')}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="fb"
                                           class="form-label font-weight-bold text-muted text-uppercase">Facebook</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-facebook"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="fb" name="facebook"
                                               placeholder="Enter facebook link" value="{{old('facebook')}}">
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
                                               placeholder="Enter linkedin link" value="{{old('linkedin')}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mb-3">
                                    <label for="address"
                                           class="form-label font-weight-bold text-muted text-uppercase">Address</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-map-o"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="address" name="address"
                                               placeholder="Enter Address" value="{{old('address')}}">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card shadow col-12">
                            <div class="row mt-5 mb-2">
                                <div class="col-md-6 mb-3">
                                    <label for="report_to"
                                           class="form-label font-weight-bold text-muted text-uppercase">Report
                                        Person</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="report_to" name="report_to"
                                               placeholder="Enter report person name" value="{{old('report_to')}}">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="report_to_position"
                                           class="form-label font-weight-bold text-muted text-uppercase">Report
                                        Person's Position</label>
                                    <input type="text" class="form-control" id="report_to_position"
                                           name="report_to_position"
                                           placeholder="Enter report person's position"
                                           value="{{old('report_to_position')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="dept" class="form-label font-weight-bold text-muted text-uppercase">Department</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-users"></i></span>
                                            </div>
                                            <input type="text" id="dept" name="department" class="form-control"
                                                   placeholder="Enter Contact Department" value="{{old('department')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="position"
                                               class="form-label font-weight-bold text-muted text-uppercase">Position</label>
                                        <input type="text" id="position" name="position" class="form-control"
                                               placeholder="Enter Contact Position" value="{{old('position')}}">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card shadow col-12">
                            <div class="form-group mt-3 mb-2">
                                <label for="bio"
                                       class="form-label font-weight-bold text-muted text-uppercase">Bio</label>
                                <textarea name="bio" class="form-control" id="bio" rows="10"
                                          placeholder="Enter Bio">{{old('bio')}}</textarea>
                            </div>
                        </div>
                        <div id="industry_add" class="modal custom-modal fade" data-backdrop="true" tabindex="-1"
                             role="dialog" style="overflow:hidden">
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
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-3">
                                Create
                            </button>
                        </div>
                    </div>
                </form>
                @include('company.quickcompany')
                @include('customer.addzone')
            </div>
        </div>
        <script>
            ClassicEditor.create($('#bio')[0], {
                toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
            });
            $(document).ready(function () {
                $('.select2').select2();
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
                $(document).on('click', '#tags_create', function () {
                    var tags = $("#tags").val();
                    $.ajax({
                        type: 'POST',
                        data: {tag_industry: tags},
                        url: '/tags/create',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                            console.log(data);

                            $("#tag_industry").load(location.href + " #tag_industry>* ");
                        }
                    });
                });
            });

            var region_id = document.querySelector('#region_id');
            var zone_id = document.querySelector('#zone');
            var zone_optoion = zone_id.querySelectorAll('option');

            // alert(product)
            function region_select(selValue) {
                zone.innerHTML = '';

                for (var i = 0; i < zone_optoion.length; i++) {
                    if (zone_optoion[i].dataset.option === selValue) {
                        zone.appendChild(zone_optoion[i]);

                    }
                }
            }

            region_select(region_id.value);
        </script>
@endsection
