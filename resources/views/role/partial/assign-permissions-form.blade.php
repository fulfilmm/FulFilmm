


<form action="{{route('roles.assignPermission',['id'=>$role->id])}}" method="POST" >
    @csrf
    @if (isset($role))
    @method('put')
    @endif
   <div class="row">
    <h4 class="col-12 ">Activity</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='activity')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12">Approval</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='approvals')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
    <hr>
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12">Customer</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='customers'||$permission->type=='companies')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12">Deal</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='deals')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12">Employee</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='employees'||$permission->type=='departments'||$permission->type=='groups')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12">Invoice</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='invoices')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12">Meeting</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='meetings'||$permission->type=='minutes')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12">Permission</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='permissions')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12">Quotation</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='quotations'||$permission->type=='quotation_items')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12">Role</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='roles')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12 border-top">Setting</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='setting')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12 border-top">Ticket</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='tickets'||$permission->type=='cases'||$permission->type=='priorities'||$permission->type=='senders')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12 border-top">Transaction</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='transaction'||$permission->type=='accounts'||$permission->type=='expenseclaims')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
       <h4 class="col-12 border-top">Stock</h4>
       @foreach ($permissions as $permission)
           @if($permission->type=='Stocks')
               <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                   <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
               </label>
           @endif
       @endforeach
       <div class="col-12 border-bottom mb-3"></div>
       <h4 class="col-12 border-top">Dashboard and Report</h4>
       @foreach ($permissions as $permission)
           @if($permission->type=='Sale')
               <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                   <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
               </label>
           @endif
       @endforeach
       <div class="col-12 border-bottom mb-3"></div>

   </div>
    <button
        class="btn btn-primary "
        type="submit">
        submit
    </button>
</form>
    {{-- {{dd($errors->all())}} --}}

