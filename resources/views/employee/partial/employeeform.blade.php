

<form action="{{$route}}" method="POST" >
    @csrf

    
    @if ($route!== route('employees.store'))
        {{dd($route,route('employees.create'))}}
      @method('put')
    @endif
    
<input type="text" placeholder="name" name="name" value="{{$employee->name ?? old('name')}}">
    <input type="text" name="department_id" placeholder="department" value="{{ $employee->department_id?? old('department_id')}}" >
    <input type="text" name="role_id"  placeholder="role" value="{{$employee->role_id??old('role_id')}}" >
<input type="text" name="email" placeholder="Email"  value="{{$employee->email??old('email')}}" >
<input type="text" name="password"  placeholder="Pasword" value="{{$employee->password??old('password')}}">
<input type="text" name="phone"  placeholder="phone" value="{{$employee->phone??old('phone')}}">
<input type="text" name="work_phone"  placeholder="Work Phone" value="{{$employee->work_phone??old('work_phone')}}">
    <input type="text" name="join_date" placeholder="start working date" value="{{$employee->join_date??old('join_date')}}">
    <label for="can_login">
        can login
    </label>
<input type="checkbox" name="can_login" checked="{{$employee->can_login?? 0}}" value="1" >
    <button
    type="submit">
    submit
    </button>
</form>
{{dd($errors->all())}}
