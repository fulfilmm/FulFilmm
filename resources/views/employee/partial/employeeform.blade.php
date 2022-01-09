


    <div class="row">
        <div class="col-md-4">
            <div class="text-center my-2" >
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

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <x-forms.basic.input name="name" title="Name" value="{{$employee->name ?? old('name')}}" required></x-forms.basic.input>
                    </div>
                </div>
                <div class="col-md-6">
                   <div class="form-group">
                       <label for="">Department</label>
                       <x-forms.basic.select name="department_id" title="Department"
                                             value="{{$employee->department_id ?? old('department_id')}}"
                                             :options="$departments" required></x-forms.basic.select>
                   </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <x-forms.basic.input name="email" title="Email" value="{{$employee->email ?? old('email')}}" required></x-forms.basic.input>
                    </div>
                </div>
                @if(!isset($employee))
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Password</label>

                            <x-forms.basic.input name="password" title="Password" type="password" value="" required></x-forms.basic.input>

                    </div>
                </div>
                @endif
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <x-forms.basic.input name="phone" title="Phone" value="{{$employee->phone ?? old('phone')}}" required></x-forms.basic.input>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="work_phone">Work Phone</label>
                        <x-forms.basic.input name="work_phone" type="tel" title="Work Phone" value="{{$employee->work_phone ?? old('work_phone')}}" required></x-forms.basic.input>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Role</label>
                        <x-forms.basic.select name="role_id"
                                              title="Asssign Role"
                                              value="{{$employee->role->id ?? old('role_id')}}"
                                              :options="$roles" required></x-forms.basic.select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="join_date">Join Date</label>
                        <x-forms.basic.input name="join_date" title="Joined Date" type="date" value="{{$employee->join_date ?? old('join_date')}}" required></x-forms.basic.input>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="input-group ">

                        <div class="checkbox">
                            <label for="can_login">
                                <input type="checkbox" value='1' name="can_login" id="can_login" {{isset( $employee->can_login) ?  $employee->can_login === 1 ? 'checked' : '' : ''}}>
                                Can login
                            </label>
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
    $(document).ready(function () {
        $('select').select2();
    });
</script>
{{-- {{dd($errors->all())}} --}}

