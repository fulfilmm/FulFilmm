

<form action="{{isset( $employee) ? route('employees.update',$employee->id): route('employees.store')}}" method="POST" >
    @csrf 
    @if (isset($employee))
    @method('put')
    @endif
    
    <input type="text" placeholder="name" name="name" value="{{$employee->name ?? old('name')}}">
    <select class="js-example-basic-single" name="department_id"   value="{{ $employee->department_id?? old('department_id')}}">
        @foreach ($departments as $department)
       <option value="{{$department->id}}">{{$department->name}}</option>
        @endforeach
      </select>


    {{-- <input type="text" name="department_id" placeholder="department"
   > --}}

    <input type="text" name="role_id"  placeholder="role" value="{{$employee->role_id??old('role_id')}}" >
    <input type="text" name="email" placeholder="Email"  value="{{$employee->email??old('email')}}" >
    <input type="password" name="password"  placeholder="Pasword"
    value="">
    <input type="text" name="phone"  placeholder="phone" value="{{$employee->phone??old('phone')}}">
    <input type="text" name="work_phone"  placeholder="Work Phone"
    value="{{$employee->work_phone??old('work_phone')}}">
    <input type="date" name="join_date" placeholder="start working date"
    value="{{$employee->join_date??old('join_date')}}">
    <label for="can_login">
        can login
    </label>
    <input type="checkbox" name="can_login" checked="{{$employee->can_login?? 0}}" value="1" >
    <button
    type="submit">
    submit
</button>
</form>
{{-- {{dd($errors->all())}} --}}
