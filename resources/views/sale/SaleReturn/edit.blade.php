
<div class="form-group">
    <label for="inv{{$record->id}}">Invoice</label><br>
    <select name="invoice_id" id="inv{{$record->id}}" class="form-control" style="width: 100%;" required>
        <option value="">Select Invoice</option>
        @foreach($invoices as $inv)
            <option value="{{$inv->id}}" {{$inv->id==$record->invoice_id?'selected':''}}>{{$inv->invoice_id}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="customer_name">Customer</label>
    <input type="text" class="form-control" name="customer_name" id="customer_name{{$record->id}}" value="" readonly>
    <input type="hidden" class="form-control" name="customer_id" id="customer_id{{$record->id}}" value="">
</div>
<div class="form-group">
    <label for="branch">Branch</label>
    <input type="text" class="form-control" name="branch" id="branch{{$record->id}}" value="" readonly>
    <input type="hidden" name="branch_id" id="branch_id{{$record->id}}" value="">
</div>
<div class="form-group">
    <label for="saleman">Sale Man</label>
    <input type="text" class="form-control" id="saleman{{$record->id}}" name="saleman" value="" readonly>
    <input type="hidden" name="sale_man_id" id="sale_man_id{{$record->id}}" value="">
</div>
<div class="form-group">
    <label for="amount">Amount</label>
    <input type="text" class="form-control" id="amount{{$record->id}}" name="amount" value="" readonly>
</div>
<div class="form-group">
    <label for="account">Account</label>
    <select name="account_id" id="account" class="form-control" style="width: 100%;">
        @foreach($account as $acc)
            <option value="{{$acc->id}}" {{$acc->id==$record->account_id?'selected':''}}>{{$acc->account_no}}-{{$acc->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="cashier">Cashier</label>
    <select name="cashier_id" id="cashier" class="form-control" style="width: 100%;">
        @foreach($employee as $emp)
            @if($emp->department->name=='Finance Department')
                <option value="{{$emp->id}}" {{$record->cashier_id==$emp->id?'selected':''}}>{{$emp->empid}}-{{$emp->name}}</option>
            @endif
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="reason">Reason</label>
    <textarea name="reason" id="" cols="30" rows="10" class="form-control">{{$record->reason}}</textarea>
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
        var ready_id=$('#inv{{$record->id}} option:selected').val();
            @foreach($invoices as $invoice)
            if(ready_id==parseInt('{{$invoice->id}}')){
                $('#customer_name{{$record->id}}').val('{{$invoice->customer->name}}');
                $('#customer_id{{$record->id}}').val('{{$invoice->customer->id}}');
                $('#branch{{$record->id}}').val('{{$invoice->branch->name}}');
                $('#branch_id{{$record->id}}').val('{{$invoice->branch->id}}');
                $('#saleman{{$record->id}}').val('{{$invoice->employee->name}}');
                $('#sale_man_id{{$record->id}}').val('{{$invoice->employee->id}}');
                $('#amount{{$record->id}}').val('{{$invoice->grand_total}}');
            }
            @endforeach
        $('#inv{{$record->id}}').change(function () {
            var inv_id=$(this).val();
            @foreach($invoices as $invoice)
            if(inv_id==parseInt('{{$invoice->id}}')){
                $('#customer_name{{$record->id}}').val('{{$invoice->customer->name}}');
                $('#customer_id{{$record->id}}').val('{{$invoice->customer->id}}');
                $('#branch{{$record->id}}').val('{{$invoice->branch->name}}');
                $('#branch_id{{$record->id}}').val('{{$invoice->branch->id}}');
                $('#saleman{{$record->id}}').val('{{$invoice->employee->name}}');
                $('#sale_man_id{{$record->id}}').val('{{$invoice->employee->id}}');
                $('#amount{{$record->id}}').val('{{$invoice->grand_total}}');
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
