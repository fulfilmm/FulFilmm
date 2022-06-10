
    <form action="{{route('customers.index')}}" method="GET">
        @csrf
        <div class="row my-2">
            <div class="col">
               <div class="form-group">
                   <label for="name">Customer Name</label>
                   <input type="text" class="form-control" name="name" placeholder="Customer Name" value="{{$name??''}}">
               </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="min">Minimum Amount</label>
                    <input type="number" class="form-control" name="min_amount" placeholder="Enter Minimum Amount" value="{{$min??''}}">
                </div>
            </div>
            <div class="col">
               <div class="form-group">
                   <label for="">Maximum Amount</label>
                   <input type="number" class="form-control" name="max_amount" placeholder="Enter Maximum Amount" value="{{$max??''}}">
               </div>
            </div>
            <div class="col mt-4">
                <button type="submit" class="btn btn-white col-12 mt-2"><i class="la la-search"></i></button>
            </div>
        </div>
    </form>
<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title mb-0 d-inline">Contacts</h4>
        <div class="float-right">
            <input type="text" wire:model="search_key" class="form-control-sm form-control rounded-pill" placeholder="Search">
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-nowrap  mb-0 table-hover dataTable">
                <thead>
                    <tr><th></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone No</th>
                        <th>Email</th>
                        <th>Branch</th>
                        <th>Region</th>
                        <th>Zone</th>
                        <th>Credit Limit</th>
                        <th>Credit Amount</th>
                        <th>Advance Balance</th>
                        <th>Payment Terms</th>
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
                            <td style="min-width: 200px;"><a href="{{route('customers.show',$customer->id)}}"><img src="{{$customer->profile!=null? url(asset('img/profiles/'.$customer->profile)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar chat-avatar-sm">{{$customer->name}}</a></td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{$customer->branch->name??'N/A'}}</td>
                            <td>{{$customer->region->name??'N/A'}}</td>
                            <td>{{$customer->zone->name??'N/A'}}</td>
                            <td>{{$customer->credit_limit??0}}</td>
                            <td><span class="text-{{$customer->current_credit>$customer->credit_limit?'danger':''}}">{{$customer->current_credit??0}}</span></td>
                            <td>{{$customer->advance_balance??0}}</td>
                            <td>{{$customer->payment_term?$customer->payment_term.' Days':''}}</td>
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
</div>

