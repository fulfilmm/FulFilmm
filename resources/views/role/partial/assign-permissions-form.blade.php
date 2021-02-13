


<form action="{{route('roles.assignPermission',['id'=>$role->id])}}" method="POST" >
    @csrf
    @if (isset($role))
    @method('put')
    @endif
    @include('forms.checkbox',[
    'title'=>'Permissions',
    'name'=>'permissions',
    'insertedData' => $hasPermissions,
    'options'=> $permissions])
    <button
        class="btn btn-primary "
        type="submit">
        submit
    </button>
</form>
    {{-- {{dd($errors->all())}} --}}

