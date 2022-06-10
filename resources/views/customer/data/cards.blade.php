@extends('customer.index')
@section('data')
    <form action="{{url('customers-card')}}" method="GET">
        @csrf
        <div class="row my-2">
            <div class="col">
                <input type="text" class="form-control" name="name" placeholder="Customer Name" value="{{$name??''}}">
            </div>
            <div class="col">
                <input type="number" class="form-control" name="min_amount" placeholder="Enter Minimum Amount" value="{{$min!=0?$min:''}}">
            </div>
            <div class="col">
                <input type="number" class="form-control" name="max_amount" placeholder="Enter Maximum Amount" value="{{$max!=0?$max:''}}">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-white col-12"><i class="la la-search"></i></button>
            </div>
        </div>
    </form>
<div class="row staff-grid-row">
    @forelse($customers as $customer)
        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
            <div class="profile-widget shadow">
                <div class="profile-img">
                    <a href="{{route('customers.show', $customer->id)}}" class="avatar text-center">
                        <img src="{{$customer->profile!=null? url(asset('img/profiles/'.$customer->profile)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="Add profile" data-toggle="tooltip" title="Profile" width="80px" height="80px" style="font-size: 8px;">
                    </a>
                </div>
                <div class="dropdown profile-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" title="Action"
                       aria-expanded="false" ><i class="material-icons">more_vert</i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" data-toggle="tooltip" title="Edit" href="{{route('customers.edit',$customer->id)}}"><i
                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                        <form action="{{route('customers.destroy',$customer->id)}}"
                              id="del-{{$customer->id}}" method="POST">
                            @method('delete')
                            @csrf
                            <a class="dropdown-item" href="#" data-toggle="tooltip" title="Delete" onclick="deleteRecord({{$customer->id}})"><i
                                        class="fa fa-trash-o m-r-5"></i> Delete</a>
                        </form>

                    </div>
                </div>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="profile" data-toggle="tooltip" title="Name">{{$customer->name}}</a></h4>
                <div class="small text-muted" data-toggle="tooltip" title="Email"><i class="la la-envelope"></i> {{$customer->email}}</div>
                <div class="small text-muted" data-toggle="tooltip" title="Email"><i class="la la-phone"></i> {{$customer->phone}}</div>
            </div>
        </div>
    @empty
    <div class="col-12 text-center">
        <span class="text-center">@lang('messages.no-item-pls-add', ['name' => 'Contact'])</span>
    </div>
    @endforelse
</div>
{{$customers->links()}}

@endsection
