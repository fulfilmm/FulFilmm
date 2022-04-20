


<form action="{{route('roles.assignPermission',['id'=>$role->id])}}" method="POST" >
    @csrf
    @if (isset($role))
    @method('put')
    @endif
   <div class="row">
    <h4 class="col-12 "><input type="checkbox" id="activity" onclick="check('activity')" class="mr-2">Activity</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='activity')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}" class="activity"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12"><input type="checkbox" id="approvals" onclick="check('approvals')" class="mr-2">Approval</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='approvals')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}" class="approvals"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
    <hr>
       <div class="col-12 border-bottom mb-3"></div>
       <h4 class="col-12"><input type="checkbox" id="bills" onclick="check('bills')" class="mr-2">Bill</h4>
       @foreach ($permissions as $permission)
           @if($permission->type=='bills')
               <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                   <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}" class="bills"> {{$permission->display_name}}
               </label>
           @endif
       @endforeach
       <hr>
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12"><input type="checkbox" id="customers" onclick="check('customers')" class="mr-2">Customer</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='customers'||$permission->type=='companies'||$permission->type=='lead')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}" class="customers"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12"><input type="checkbox" id="deals" onclick="check('deals')" class="mr-2">Deal</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='deals')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="deals"  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12"><input type="checkbox" id="employees" onclick="check('employees')">Employee</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='employees'||$permission->type=='departments'||$permission->type=='groups')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}}  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}" class="employees"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
       <h4 class="col-12"><input type="checkbox" id="exp_claim" onclick="check('exp_claim')" class="mr-2">Expense Claim</h4>
       @foreach ($permissions as $permission)
           @if($permission->type=='expenseclaims')
               <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                   <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="exp_claim"  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
               </label>
           @endif
       @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12"><input type="checkbox" id="invoices" onclick="check('invoices')" class="mr-2">Invoice</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='invoices')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="invoices"  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
       <h4 class="col-12"><input type="checkbox" id="inventory" onclick="check('inventory')" class="mr-2">Inventory</h4>
       @foreach ($permissions as $permission)
           @if($permission->type=='inventory')
               <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                   <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="inventory"  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
               </label>
           @endif
       @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12"><input type="checkbox" id="meetings" onclick="check('meetings')" class="mr-2">Meeting</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='meetings'||$permission->type=='minutes')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="meetings" name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
       <h4 class="col-12"><input type="checkbox" id="office" onclick="check('office')" class="mr-2">Office</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='officebranch')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="office"  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12"><input type="checkbox" id="permission" onclick="check('permission')" class="mr-2">Permission</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='permissions')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="permission"  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
       <h4 class="col-12"><input type="checkbox" id="products" onclick="check('products')" class="mr-2">Products</h4>
       @foreach ($permissions as $permission)
           @if($permission->type=='products')
               <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                   <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="products"  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
               </label>
           @endif
       @endforeach
       <div class="col-12 border-bottom mb-3"></div>
       <h4 class="col-12"><input type="checkbox" id="product_brand" onclick="check('product_brand')" class="mr-2">Products Brand</h4>
       @foreach ($permissions as $permission)
           @if($permission->type=='product_brand')
               <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                   <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="product_brand"  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
               </label>
           @endif
       @endforeach

       <div class="col-12 border-bottom mb-3"></div>
       <h4 class="col-12"><input type="checkbox" id="purchase" onclick="check('purchase')" class="mr-2">Purchase</h4>
       @foreach ($permissions as $permission)
           @if($permission->type=='rfqs'||$permission->type=='purchase_request'||$permission->type=='purchaseorders')
               <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                   <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="purchase"  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
               </label>
           @endif
       @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12"><input type="checkbox" id="quotation" onclick="check('quotation')" class="mr-2">Quotation</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='quotations'||$permission->type=='quotation_items')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="quotation"  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12"><input type="checkbox" id="role" onclick="check('role')" class="mr-2">Role</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='roles')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="role"  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
       <h4 class="col-12"><input type="checkbox" id="products" onclick="check('products')" class="mr-2">Promotion And Discount</h4>
       @foreach ($permissions as $permission)
           @if($permission->type=='discount'||$permission->type=='discount_promotions')
               <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                   <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="products"  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
               </label>
           @endif
       @endforeach

       <div class="col-12 border-bottom mb-3"></div>
       <div class="col-12 border-bottom mb-3"></div>
       <h4 class="col-12 border-top"><input type="checkbox" id="report" onclick="check('report')" class="mr-2">Sale Target</h4>
       @foreach ($permissions as $permission)
           @if($permission->type=='saletargets')
               <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                   <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="report" name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
               </label>
           @endif
       @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12 border-top"><input type="checkbox" id="setting" onclick="check('setting')" class="mr-2">Setting</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='setting')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="setting" name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12 border-top"><input type="checkbox" id="ticket" onclick="check('ticket')" class="mr-2">Ticket</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='tickets'||$permission->type=='cases'||$permission->type=='priorities'||$permission->type=='senders')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="ticket"  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
    <h4 class="col-12 border-top"><input type="checkbox" id="transaction" onclick="check('transaction')" class="mr-2">Transaction</h4>
    @foreach ($permissions as $permission)
        @if($permission->type=='transaction'||$permission->type=='accounts'||$permission->type=='advancepayments')
            <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="transaction"  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
            </label>
        @endif
    @endforeach
       <div class="col-12 border-bottom mb-3"></div>
       <h4 class="col-12 border-top"><input type="checkbox" id="stock" onclick="check('stock')" class="mr-2">Stock</h4>
       @foreach ($permissions as $permission)
           @if($permission->type=='Stocks'||$permission->type=='binlookup'||$permission->type=='warehouse')
               <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                   <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="stock"  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
               </label>
           @endif
       @endforeach
       <div class="col-12 border-bottom mb-3"></div>
       <h4 class="col-12 border-top"><input type="checkbox" id="unit" onclick="check('unit')" class="mr-2">Sell Unit</h4>
       @foreach ($permissions as $permission)
           @if($permission->type=='sellingunits')
               <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                   <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="unit"  name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
               </label>
           @endif
       @endforeach
       <div class="col-12 border-bottom mb-3"></div>
       <h4 class="col-12 border-top"><input type="checkbox" id="report" onclick="check('report')" class="mr-2">Dashboard and Report</h4>
       @foreach ($permissions as $permission)
           @if($permission->type=='Sale'||$permission->type=='Report')
               <label for="{{'permission' . $permission->display_name}}" class="col-md-3">
                   <input type="checkbox" {{$hasPermissions->contains($permission->id)? 'checked' : ''}} class="report" name="permissions[]" id="{{'permission' . $permission->display_name}}" value="{{$permission->id}}"> {{$permission->display_name}}
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
<script>
   function check(type) {
      var id='#'+type;
      var type='.'+type;
       $(id).change(function () {
           $(type).prop('checked',this.checked);
       });

       $('.type').change(function () {
           if ($(type+':checked').length == $(type).length){
               $('#checkall').prop('checked',true);
           }
           else {
               $('#checkall').prop('checked',false);
               // $(".action").remove();
           }
       });
   }
</script>
    {{-- {{dd($errors->all())}} --}}

