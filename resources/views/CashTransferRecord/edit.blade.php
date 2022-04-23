<div id="edit{{$item->id}}" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Edit Cash Transfer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('moneytransfer.update',$item->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <input type="hidden" name="emp_id" value="{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->id}}">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="receiver">Cashier Name</label><br>
                                <select name="receiver_id" id="receiver" class="form-control" style="width: 100%">
                                    @foreach($employee as $cashier)
                                        @if($cashier->role->name=='Cashier')
                                            <option value="{{$cashier->id}}" {{$cashier->id==$item->receiver_id?'selected':''}}>{{$cashier->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('receiver_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" name="amount" value="{{$item->amount}}">
                                @error('amount')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="salemanager">Sale Manager</label><br>
                                <select name="sale_manager" id="salemanager" class="form-control" style="width: 100%;">
                                    @foreach($employee as $cashier)
                                        @if($cashier->role->name=='Sale Manager')
                                            <option value="{{$cashier->id}}" {{$cashier->id==$item->sale_manager?'selected':''}}>{{$cashier->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('sale_manager')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="finance">Finance Manager</label><br>
                                <select name="finance_manager" id="finance" class="form-control" style="width: 100%">
                                    @foreach($employee as $cashier)
                                        @if($cashier->role->name=='Cashier')
                                            <option value="{{$cashier->id}}" {{$cashier->id==$item->finance_manager?'selected':''}}>{{$cashier->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('receiver_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="desc">Description</label>
                                <textarea name="description" id="desc" cols="30" rows="10" class="form-control">
                               {{$item->description}}
                           </textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="attach">Attach</label>
                                <input type="file" name="attach" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-danger" data-dimiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('select').select2();
    });
</script>