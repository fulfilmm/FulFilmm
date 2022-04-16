
<div class="form-group">
    <label for="inv">Invoice</label>
    <select name="invoice_id" id="inv" class="form-control" style="width: 100%;" required>
        <option value="">Select Invoice</option>
        @foreach($invoices as $inv)
            <option value="{{$inv->id}}" {{$inv->id==old('invoice_id')?'selected':''}}>{{$inv->invoice_id}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="customer_name">Customer</label>
    <input type="text" class="form-control" name="customer_name" id="customer_name" value="{{old('customer_name')}}" readonly>
    <input type="hidden" class="form-control" name="customer_id" id="customer_id" value="{{old('customer_id')}}">
</div>
<div class="form-group">
    <label for="branch">Branch</label>
    <input type="text" class="form-control" name="branch" id="branch" value="{{old('branch')}}" readonly>
    <input type="hidden" name="branch_id" id="branch_id" value="{{old('branch_id')}}">
</div>
<div class="form-group">
    <label for="saleman">Sale Man</label>
    <input type="text" class="form-control" id="saleman" name="saleman" value="{{old('saleman')}}" readonly>
    <input type="hidden" name="sale_man_id" id="sale_man_id" value="{{old('sale_man_id')}}">
</div>
<div class="form-group">
    <label for="amount">Amount</label>
    <input type="text" class="form-control" id="amount" name="amount" value="{{old('amount')}}" readonly>
</div>
<div class="form-group">
    <label for="account">Account</label>
    <select name="account_id" id="account" class="form-control" style="width: 100%;">
        @foreach($account as $acc)
            <option value="{{$acc->id}}">{{$acc->account_no}}-{{$acc->name}}</option>
            @endforeach
    </select>
</div>
<div class="form-group">
    <label for="cashier">Cashier</label>
    <select name="cashier_id" id="cashier" class="form-control" style="width: 100%;">
        @foreach($employee as $emp)
            @if($emp->department->name=='Finance Department')
            <option value="{{$emp->id}}">{{$emp->empid}}-{{$emp->name}}</option>
            @endif
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="reason">Reason</label>
    <textarea name="reason" id="" cols="30" rows="10" class="form-control">{{old('reason')}}</textarea>
</div>
<div class="form-group">
    <label for="file">Attach</label>
    <input type="file" name="attachment" id="file" class="form-control">
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
<script>
    $(document).ready(function () {
        $('#inv').change(function () {
            var inv_id=$(this).val();
            @foreach($invoices as $invoice)
            if(inv_id==parseInt('{{$invoice->id}}')){
                $('#customer_name').val('{{$invoice->customer->name}}');
                $('#customer_id').val('{{$invoice->customer->id}}');
                $('#branch').val('{{$invoice->branch->name}}');
                $('#branch_id').val('{{$invoice->branch->id}}');
                $('#saleman').val('{{$invoice->employee->name}}');
                $('#sale_man_id').val('{{$invoice->employee->id}}');
                $('#amount').val('{{$invoice->grand_total}}');
            }
            if(inv_id==''){
                $('#customer_name').val('');
                $('#customer_id').val('');
                $('#branch').val('');
                $('#branch_id').val('');
                $('#saleman').val('');
                $('#sale_man_id').val('');
                $('#amount').val('');
            }
            @endforeach
        });
    });
</script>
