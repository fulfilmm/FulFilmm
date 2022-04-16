    <div class=" card shadow">
    <div class="col-12 mt-5 mb-2">
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card-body rounded bg-light">
                    <div class="d-flex justify-content-center mt-5">
                        <div class="text-center">
                            <input type="file" id="file1" accept="image/*" name="profile_img"
                                   class="offset-md-1" onchange="loadFile(event)"
                                   style="display:none"/>
                            <img id="output" onClick="openSelect('#file1')"
                                 class="rounded mt-2 mb-4"
                                 src="{{isset($employee)?(url(asset($employee->profile_img?'img/profiles/'.$employee->profile_img:'img/profiles/plus.jpg'))):url(asset('/img/profiles/plus.jpg'))}}"
                                 width="100px" height="100px;" alt=""><br>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-2 mb-3">
                        <p class="mb-0 text-muted font-weight-bold">Upload Image</p>
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
                                       placeholder="Enter Full Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="company_id"
                               class="form-label font-weight-bold text-muted text-uppercase">Company
                            Name<span class="text-danger">*</span></label>
                        <div class="input-group" id="company_div">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-building"></i></span>
                            </div>
                            <select name="company_id" id="company_id" class="form-control">
                                @foreach($companies as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                @endforeach
                            </select>
                            <button type="button" data-toggle="modal" data-target="#add_new_company" class="btn btn-white"><i
                                        class="fa fa-plus"></i></button>
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
                                   placeholder="Enter Email" required>
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
                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                            </div>
                            <input type="text" class="form-control" id="phone" name="phone"
                                   placeholder="Enter Phone">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="credit">Credit Limit</label>
                            <input type="number" class="form-control" name="credit_limit" value="{{old('credit_limit')}}">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3" id="refesh_div">
                        <label for="customer_type" class="form-label font-weight-bold text-muted text-uppercase">
                            Type</label>
                        <select name="customer_type" id="customer_type" class="form-control">
                            <option value="Customer">Customer</option>
                            <option value="Lead">Lead</option>
                            <option value="In Query">In Query</option>
                            <option value="Partner">Partner</option>
                            <option value="Competitor">Competitor</option>
                            <option value="Supplier">Supplier</option>
                            <option value="Courier">Courier</option>
                        </select>
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
                                       class="custom-control-input">
                                <label class="custom-control-label" for="female"><i
                                            class="fa fa-female"></i> Female </label>
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
                              id="bod" min="{{\Carbon\Carbon::today()->format('Y-m-d')}}" name="bod" placeholder="Enter Birth Day"
                              autocomplete="off">
                   </div>
               </div>
           </div>
           <div class="col-md-6 mb-3">
               <label for="region"
                      class="form-label font-weight-bold text-muted text-uppercase">Region</label>
               <input type="text" class="form-control" id="region" name="region" value="{{old('region')}}">
           </div>

           <div class="col-md-6 mb-3">
               <label for="fb"
                      class="form-label font-weight-bold text-muted text-uppercase">Facebook</label>
               <div class="input-group">
                   <div class="input-group-prepend">
                       <span class="input-group-text"><i class="fa fa-facebook"></i></span>
                   </div>
                   <input type="text" class="form-control" id="fb" name="facebook"
                          placeholder="Enter facebook link">
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
                          placeholder="Enter linkedin link">
               </div>
           </div>
           <div class="col-md-12 mb-3">
               <label for="address"
                      class="form-label font-weight-bold text-muted text-uppercase">Address</label>
               <div class="input-group">
                   <div class="input-group-prepend">
                       <span class="input-group-text"><i class="fa fa-map-o"></i></span>
                   </div>
                   <input type="text" class="form-control" id="address" name="address"
                          placeholder="Enter Address">
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
                           placeholder="Enter report person name">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="position"
                       class="form-label font-weight-bold text-muted text-uppercase">Report
                    Person's Position</label>
                <input type="text" class="form-control" id="position" name="position"
                       placeholder="Enter report person's position">
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="dept" class="form-label font-weight-bold text-muted text-uppercase">Department</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-users"></i></span>
                        </div>
                        <input type="text" id="dept" name="department" class="form-control" placeholder="Enter Contact Department">
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="position" class="form-label font-weight-bold text-muted text-uppercase">Position</label>
                    <input type="text" id="position" name="position" class="form-control" placeholder="Enter Contact Position">
                </div>
            </div>
            <div class="col-md-6 mb-3" id="title">
                <label for='title'
                       class='form-label font-weight-bold text-muted text-uppercase pro_label'>Title </label>
                <div class='input-group' id='priority_field'>
                    <input type='text' class='form-control' name='title'></div>
            </div>
            <div class="col-md-6 mb-3" id="priority">
                <label for="Text6"
                       class="form-label font-weight-bold text-muted text-uppercase pro_label">Priority</label>
                <div class="input-group" id="priority_field">
                    <select name="priority" id="priority_type" class="form-control" style="width: 100%">
                        <option value="High">High</option>
                        <option value="Medium">Medium</option>
                        <option value="Low">Low</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mb-3" id="tag_industry">
                <label for="Text6" class="form-label font-weight-bold text-muted text-uppercase pro_label">Industry</label>
                <div class="input-group">
                    <select name="tag_industry" id="industry" class="form-control" style="width: 80%">
                        @foreach($tags as $tag)
                            @if($tag->id==$last_tag->id)
                                <option value="{{$tag->id}}" selected>{{$tag->tag_industry}}</option>
                            @else
                                <option value="{{$tag->id}}">{{$tag->tag_industry}}</option>
                            @endif
                        @endforeach
                    </select>
                    <div class="input-group-prepend">
                        <a href="" class="input-group-text" data-toggle='modal' data-target='#industry_add'><i
                                    class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3" id="status">
                <label for="Text6" class="form-label font-weight-bold text-muted text-uppercase pro_label">Status</label>
                <div class="input-group">
                    <select name="status" id="status" class="form-control" style="width:100% ;">
                        <option value="New">New</option>
                        <option value="Qualified">Qualified</option>
                        <option value="Unqualified">Unqualified</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 mb-3" id="case">
                <div class="form-group">
                    <label for="case_text">Case</label>
                    <input type="text" class="form-control" name="case" id="case_text">
                </div>
            </div>
        </div>

    </div>
    <div class="card shadow col-12">
    <div class="form-group mt-3 mb-2">
        <label for="bio" class="form-label font-weight-bold text-muted text-uppercase">Bio</label>
        <textarea name="bio" class="form-control" id="bio" rows="10"
                  placeholder="Enter Bio"></textarea>
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

        <script>
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
            $(document).ready(function () {
                $('select').select2();
            });
        </script>