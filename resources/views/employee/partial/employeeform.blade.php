


<form action="{{isset( $employee) ? route('employees.update',$employee->id): route('employees.store')}}" method="POST" enctype="multipart/form-data" >
    @csrf
    @if (isset($employee))
    @method('put')
    @endif
    <div class="text-center my-2" >
        <h4>Profile Picture</h4>
        <input type="file" id="file1" accept="image/*" name="profile_img"  class="offset-md-1" onchange="loadFile(event)" style="display:none"/>
        <img id="output" onClick="openSelect('#file1')" class="rounded mt-2 mb-4" src="{{isset($employee)?(url(asset($employee->profile_img?'img/profiles/'.$employee->profile_img:'img/profiles/plus.jpg'))):url(asset('/img/profiles/plus.jpg'))}}" width="100px" height="100px;"><br>
    </div>
    <x-forms.basic.input name="name" title="Name" value="{{$employee->name ?? old('name')}}" required></x-forms.basic.input>
    <x-forms.basic.select name="department_id" title="Department"
    value="{{$employee->department_id ?? old('department_id')}}"
    :options="$departments" required></x-forms.basic.select>
    <x-forms.basic.input name="email" title="Email" value="{{$employee->email ?? old('email')}}" required></x-forms.basic.input>
    @if(!isset($employee))
    <x-forms.basic.input name="password" title="Password" type="password" value="" required></x-forms.basic.input>
    @endif
    <x-forms.basic.input name="phone" title="Phone" value="{{$employee->phone ?? old('phone')}}" required></x-forms.basic.input>
    <x-forms.basic.input name="work_phone" type="tel" title="Work Phone" value="{{$employee->work_phone ?? old('work_phone')}}" required></x-forms.basic.input>
    <x-forms.basic.input name="join_date" title="Joined Date" type="date" value="{{$employee->join_date ?? old('join_date')}}" required></x-forms.basic.input>

    <x-forms.basic.select name="role_id"
    title="Asssign Role"
    value="{{$employee->role->id ?? old('role_id')}}"
    :options="$roles" required></x-forms.basic.select>


    <div class="form-group row">
        <label class="col-form-label col-md-2">Can login</label>
        <div class="col-md-10">
            <div class="checkbox">
                <label for="can_login">
                    <input type="checkbox" value='1' name="can_login" id="can_login" {{isset( $employee->can_login) ?  $employee->can_login === 1 ? 'checked' : '' : ''}}>
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-md-2">Assignment Post</label>
        <div class="col-md-10">
            <div class="checkbox">
                <label for="can_post_assignments">
                    {{--                            @dd(isset( $employee->can_post_assignments))--}}
                    <input type="checkbox" value='1' name="can_post_assignments" id="can_post_assignments" {{isset( $employee->can_post_assignments) ?  $employee->can_post_assignments === 1 ? 'checked' : '' : ''}}>

                </label>
            </div>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">submit</button>
    <a href="{{route('employees.index')}}" class="btn btn-secondary ml-3">Cancel</a>
</form>
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
</script>
{{-- {{dd($errors->all())}} --}}

