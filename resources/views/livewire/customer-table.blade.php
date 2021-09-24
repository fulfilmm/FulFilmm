<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0 d-inline">Customers</h4>
        <div class="float-right">
            <input type="text" wire:model="search_key">
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-nowrap datatable mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone No</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td><img src="{{$customer->profile!=null? url(asset('img/profiles/'.$customer->profile)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar chat-avatar-sm">{{$customer->name}}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->company->name }}</td>
                            <td style="display: flex">
                                <a class="btn btn-success" href="{{route('customers.show',$customer->id)}}"><span class='fa fa-eye'></span></a>&nbsp;
                                <a class="btn btn-success" href="{{route('customers.edit',$customer->id)}}"><span class='fa fa-edit'></span></a>&nbsp;
                                <form action="{{route('customers.destroy',$customer->id)}}" id="del-customer{{$customer->id}}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <a class="btn btn-danger" href="#" onclick="deleteRecord({{$customer->id}})"><span class='fa fa-trash'></span></a>
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

