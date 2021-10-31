<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0 d-inline">Contacts</h4>
        <div class="float-right">
            <input type="text" wire:model="search_key">
        </div>
    </div>
    <div class="card-body">
        <div class="form-group col-md-4 col-12 float-right" id="action">
            <label for="">Action</label>
            <div class="input-group">
                <select name="type" id="type" class="form-control">
                    <option value="Customer">Customer</option>
                    <option value="Lead">Lead</option>
                    <option value="In Query">In Query</option>
                    <option value="Partner">Partner</option>
                    <option value="Competitor">Competitor</option>
                    <option value="Supplier">Supplier</option>
                    <option value="Courier">Courier</option>
                </select>
                <button type="button" id="type_change" class="btn btn-primary"><i class="fa fa-save"></i></button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-nowrap datatable mb-0">
                <thead>
                    <tr><th></th>
                        <th>Name</th>
                        <th>Phone No</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td><input type="checkbox" class="checkbox" name="checked_customer[]" value="{{$customer->id}}"></td>
                            <td><img src="{{$customer->profile!=null? url(asset('img/profiles/'.$customer->profile)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar chat-avatar-sm">{{$customer->name}}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->company->name }}</td>
                            <td>{{$customer->customer_type}}</td>
                            <td style="display: flex">
                                <a class="btn btn-success" href="{{route('customers.show',$customer->id)}}"><span class='fa fa-eye'></span></a>&nbsp;
                                <a class="btn btn-success" href="{{route('customers.edit',$customer->id)}}"><span class='fa fa-edit'></span></a>&nbsp;
                                <form action="{{route('customers.destroy',$customer->id)}}" id="del-customer{{$customer->id}}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger" type="submit" onclick="deleteRecord({{$customer->id}})"><span class='fa fa-trash'></span></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            {{$customers->links()}}
        </div>
    </div>
</div>

