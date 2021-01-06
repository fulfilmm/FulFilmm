


        <form action="{{isset( $employee) ? route('employees.update',$employee->id): route('employees.store')}}" method="POST" >
            @csrf
            @if (isset($employee))
            @method('put')
            @endif
            <x-forms.basic.input name="name" title="Name" value="{{$employee->name ?? old('name')}}" required></x-forms.basic.input>
            <x-forms.basic.select name="department_id" title="Department" value="{{$employee->department_id ?? old('department_id')}}" :options="$departments->pluck('name', 'id')" required></x-forms.basic.select>
            <x-forms.basic.input name="email" title="Email" value="{{$employee->email ?? old('email')}}" required></x-forms.basic.input>
            <x-forms.basic.input name="password" title="Password" type="password" value="" required></x-forms.basic.input>
            <x-forms.basic.input name="phone" title="Phone" value="{{$employee->phone ?? old('phone')}}" required></x-forms.basic.input>
            <x-forms.basic.input name="work_phone" type="tel" title="Work Phone" value="{{$employee->work_phone ?? old('work_phone')}}" required></x-forms.basic.input>
            <x-forms.basic.input name="join_date" title="Joined Date" type="date" value="{{$employee->join_date ?? old('join_date')}}" required></x-forms.basic.input>

            {{-- <input type="text" name="department_id" placeholder="department"
           > --}}

            {{-- <input type="text" name="role_id"  placeholder="role" value="" > --}}

            <x-forms.basic.input name="role_id" title="Role" value="{{$employee->role_id ?? old('role_id')}}" required></x-forms.basic.input>

            <div class="form-group row">
                <label class="col-form-label col-md-2">Can login</label>
                <div class="col-md-10">
                    <div class="checkbox">
                        <label for="can_login">
                            <input type="checkbox" value='1' name="can_login" id="can_login" checked={{isset( $employee->can_login) ? 'checked' : ''}}>

                        </label>
                    </div>
                </div>
            </div>
            <button
            class="btn btn-primary "
            type="submit">
            submit
        </button>
        </form>
            {{-- {{dd($errors->all())}} --}}

