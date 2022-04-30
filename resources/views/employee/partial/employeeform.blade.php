

<div class="row">
    <div class="col-md-4 ">
        <div class="card shadow">
            <div class="text-center my-5" >
                <h4>Profile Picture</h4>
                <input type="file" id="file1" accept="image/*" name="profile_img"  class="offset-md-1" onchange="loadFile(event)" style="display:none"/>
                <div>
                    <img id="output" onClick="openSelect('#file1')" class="rounded mt-2 mb-4" src="{{isset($employee)?(url(asset($employee->profile_img?'img/profiles/'.$employee->profile_img:'img/profiles/plus.jpg'))):url(asset('/img/profiles/plus.jpg'))}}" width="100px" height="100px;">
                    @if(isset($employee))
                        <i class="fa fa-camera mt-5 " style="position: absolute; left: 210px;top: 70px;"></i>
                    @endif
                </div>
                <br>

            </div>

        </div>
        <div class="card shadow" id="first_card">
            <div class="col-md-12 mt-3">
                <div class="form-group">
                    <label for="name">Name</label>
                    <x-forms.basic.input name="name" title="Name" value="{{$employee->name ?? old('name')}}" required></x-forms.basic.input>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <div class="input-group">
                        <input type="radio" id="gender" class="mr-2 ml-3" name="gender" value="Male">
                        <label for="Male">Male</label>
                    </div>
                    <div class="input-group">
                        <input type="radio" id="gender" class="mr-2 ml-3" name="gender" value="Female">
                        <label for="Female">Female</label>
                    </div>
                    <hr>
                    <div class="input-group ">
                        <div class="checkbox">
                            <label for="can_login">
                                <input type="checkbox" value='1' name="can_login" id="can_login" {{isset( $employee->can_login) ?  $employee->can_login == 1 ? 'checked' : '' : ''}}>
                                Can login
                            </label>
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="mobile_seller">
                            <input type="radio" name="mobile_seller" value="1" {{isset( $employee->mobile_seller) ?  $employee->mobile_seller == 1 ? 'checked' : '' : ''}}>
                            Mobile Sale Man</label><br>
                    </div>

                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="email">Email</label>
                    <x-forms.basic.input name="email" title="Email" value="{{$employee->email ?? old('email')}}" required></x-forms.basic.input>
                </div>
            </div>
            @if(!isset($employee))
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="password">Password</label>

                        <x-forms.basic.input name="password" title="Password" type="password" value=""  required></x-forms.basic.input>
                        <input type="checkbox" class="mr-2 mt-2" onclick="myFunction()"><label for="" class="mt-2">Show Password</label>

                    </div>
                </div>
            @else
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" readonly>
                    </div>
                </div>
            @endif
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label for="">Role</label>
                    <x-forms.basic.select name="role_id"
                                          title="Asssign Role"
                                          value="{{$employee->role->id ?? old('role_id')}}"
                                          :options="$roles" required></x-forms.basic.select>
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow">
            <div class="col-12 my-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Department</label>
                            <x-forms.basic.select name="department_id" title="Department"
                                                  value="{{$employee->department_id ?? old('department_id')}}"
                                                  :options="$departments" required></x-forms.basic.select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="report_to">Report To</label>
                            <select name="report_to" id="report_to" class="form-control">
                                <option value="">Select Report Person</option>
                                @foreach($all_employee as $emp)
                                    @if($emp->role->name=='Sale Manager'|| $emp->role->name=='Stock Manager'||
                                    $emp->role->name=='Finance Manager'||$emp->role->name=='Super Admin'||$emp->role->name=='CEO'||
                                    $emp->role->name=='Admin Manager'||$emp->role->name=='General Manager'||$emp->role->name=='Hr Manager'||$emp->role->name=='Customer Service Manager')
                                        <option value="{{$emp->id}}" {{isset($employee)?($emp->id==$employee->report_to?'selected':''):old('report_to')}}>{{$emp->name}}</option>
                                        @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <x-forms.basic.input name="phone" title="Phone" value="{{$employee->phone ?? old('phone')}}" required></x-forms.basic.input>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="work_phone">Work Phone</label>
                            <x-forms.basic.input name="work_phone" type="tel" title="Work Phone" value="{{$employee->work_phone ?? old('work_phone')}}" required></x-forms.basic.input>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Office</label>
                            <select name="office_branch_id" id="branch_id" class="select form-control">
                                @foreach($office as $item)
                                    <option value="{{$item->id}}" {{isset($employee)?($employee->office_branch_id==$item->id?'selected':''):old('office_branch_id')}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 my-3" id="wh_div">
                        <label for="wh_id">Warehouse</label>
                        <select name="warehouse_id" id="wh_id" class="form-control">
                            <option value="">None</option>
                            @foreach($warehouse as $item)
                                <option value="{{$item->id}}" {{isset($employee)?($employee->warehouse_id==$item->id?'selected':''):old('warehouse_id')}} data-option="{{$item->branch_id}}">{{$item->warehouse_id}}-{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12" id="region_div">
                        <div class="form-group">
                            <label for="">Region</label>
                            <select name="region_id" id="region_id" class="form-control">
                                <option value="">None</option>
                                @foreach($region as $item)
                                    <option value="{{$item->id}}" {{isset($employee)?($employee->office_branch_id==$item->id?'selected':''):old('office_branch_id')}} data-option="{{$item->branch_id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="dob">Date Of Birth</label>
                            <input type="date" class="form-control" name="dob" title="dob" id="dob" value="{{$employee->dob??old('dob')}}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="join_date">Join Date</label>
                            <x-forms.basic.input name="join_date" title="Joined Date" type="date" value="{{$employee->join_date ?? old('join_date')}}" required></x-forms.basic.input>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" id="address" value="{{$employee->address??old('address')}}">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('output');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };
    function openSelect(file) {
        $(file).trigger('click');
    }


    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    $(document).ready(function () {
        $('select').select2();
    });
</script>
{{-- {{dd($errors->all())}} --}}

