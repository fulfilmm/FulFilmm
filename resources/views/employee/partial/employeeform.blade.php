


        <form action="{{isset( $employee) ? route('employees.update',$employee->id): route('employees.store')}}" method="POST" >
            @csrf 
            @if (isset($employee))
            @method('put')
            @endif
            @include('forms.dynamic-input',['required'=>true,'name'=>'name','value'=> $employee->name ?? old('name'),'title'=>'Name'])
              @include('forms.select',['required'=>true,'value'=> $employee->department_id ?? old('department_id'),'title'=>"Department",'options'=>$departments->pluck('name','id'),
              'name'=>'department_id'])
              @include('forms.dynamic-input',['required'=>true,'name'=>'email','value'=> $employee->email ?? old('email'),'title'=>'Email'])
              @include('forms.dynamic-input',['required'=>true,'name'=>'password','value'=> "",'type'=>'password','title'=>'Password'])
              @include('forms.dynamic-input',['required'=>true,'name'=>'phone','value'=> $employee->phone ?? old('phone'),'title'=>'Phone'])
              @include('forms.dynamic-input',['required'=>true,'name'=>'work_phone','value'=> $employee->work_phone ?? old('work_phone'),'title'=>'Work Phone'])
              @include('forms.dynamic-input',['type'=>'date','required'=>true,'name'=>'join_date','value'=> $employee->join_date ?? old('join_date'),'title'=>'Joined Date'])

        
            {{-- <input type="text" name="department_id" placeholder="department"
           > --}}
        
            {{-- <input type="text" name="role_id"  placeholder="role" value="" > --}}
          
            
            @include('forms.dynamic-input',['name'=>'role_id','title'=>'Role','value'=>$employee->role_id ?? old('role_id')])
            
            <div class="form-group row">
                <label class="col-form-label col-md-2">Can login</label>
                <div class="col-md-10">
                    <div class="checkbox">
                        <label for="can_login">
                            <input type="checkbox" name="can_login" id="can_login" value="{{$employee->can_login ?? 0}}"> 
                            
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

