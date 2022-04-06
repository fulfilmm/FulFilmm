<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title mb-0 d-inline">Contacts</h4>
        <div class="float-right">
            <input type="text" wire:model="search_key" class="form-control-sm form-control rounded-pill" placeholder="Search">
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-nowrap datatable mb-0 table-hover">
                <thead>
                    <tr><th></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone No</th>
                        <th>Email</th>
                        <th>Credit Limit</th>
                        <th>Credit Amount</th>
                        <th>Company</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td><input type="checkbox" data-toggle="tooltip" title="Change Customer Type" class="checkbox" name="checked_customer[]" value="{{$customer->id}}"></td>
                            <td>{{$customer->customer_id}}</td>
                            <td><a href="{{route('customers.show',$customer->id)}}"><img src="{{$customer->profile!=null? url(asset('img/profiles/'.$customer->profile)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar chat-avatar-sm">{{$customer->name}}</a></td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{$customer->credit_limit??0}}</td>
                            <td><span class="text-{{$customer->current_credit>$customer->credit_limit?'danger':''}}">{{$customer->current_credit??0}}</span></td>
                            <td>{{ $customer->company->name }}</td>
                            <td>{{$customer->customer_type}}</td>
                            <td style="display: flex">
                                <a class="btn btn-success btn-sm" data-toggle="tooltip" title="View Detail" href="{{route('customers.show',$customer->id)}}"><span class='fa fa-eye'></span></a>&nbsp;
                                <a class="btn btn-success btn-sm" data-toggle="tooltip" title="Edit" href="{{route('customers.edit',$customer->id)}}"><span class='fa fa-edit'></span></a>&nbsp;
                                <form action="{{route('customers.destroy',$customer->id)}}" id="del-customer{{$customer->id}}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete" type="submit" onclick="deleteRecord({{$customer->id}})"><span class='fa fa-trash'></span></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            {{$customers->links()}}
        </div>
    </div>
    <div class="card-footer">
        <div class="form-group col-md-4 col-12 float-left" id="action">
            <div class="input-group">
               <div class="row">
                   <select name="type" id="type" class="form-control">
                       <option value="">Select Customer Type</option>
                       <option value="Customer">Customer</option>
                       <option value="Lead">Lead</option>
                       <option value="In Query">In Query</option>
                       <option value="Partner">Partner</option>
                       <option value="Competitor">Competitor</option>
                       <option value="Supplier">Supplier</option>
                       <option value="Courier">Courier</option>
                   </select>
                   <div class="input-group-prepend">
                       <button type="button" data-toggle="tooltip" title="Change type of Customer" id="type_change" class="btn btn-white"><i class="fa fa-save"></i></button>
                   </div>
               </div>
            </div>
        </div>
    </div>
</div>

