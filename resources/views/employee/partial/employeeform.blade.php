


<form action="{{isset( $employee) ? route('employees.update',$employee->id): route('employees.store')}}" method="POST" >
    @csrf
    @if (isset($employee))
    @method('put')
    @endif
    <x-forms.basic.input name="name" title="Name" value="{{$employee->name ?? old('name')}}" required></x-forms.basic.input>
    <x-forms.basic.select name="department_id" title="Department"
    value="{{$employee->department_id ?? old('department_id')}}"
    :options="$departments" required></x-forms.basic.select>
    <x-forms.basic.input name="email" title="Email" value="{{$employee->email ?? old('email')}}" required></x-forms.basic.input>

    <x-forms.basic.input name="password" title="Password" type="password" value="" required></x-forms.basic.input>
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
        <label class="col-form-label col-md-2">Can Post Assignments</label>
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
{{-- {{dd($errors->all())}} --}}

