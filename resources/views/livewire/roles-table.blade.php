<div class="card">
    {{--  --}}
    <div class="card-header">
        <h4 class="card-title mb-0 d-inline">Roles</h4>
        <div class="float-right">
            <input type="text" wire:model="search_key" class="form-control form-control-sm rounded-pill" placeholder="Enter keyword">
        </div>
    </div>
        {{-- <a href={{url('/employees/export')}}><button  class="btn btn-primary ml-2">Export</button></a> --}}
        <div class="card-body">
        <div class="table-responsive">
            <table class="table table-nowrap mb-0 ">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Created Date</th>
                    <th>Action</th>

                </tr>
            </thead>
            @foreach ($roles as $em)
                <tr>
                    <td>{{$em->id}}</td>
                    <td>{{$em->name}}</td>
                    <td>{{ $em->created_at }}</td>
                    <td style="display: flex">
                    <a class="mr-2 my-auto btn btn-success" href="{{route('roles.show',$em->id)}}">Assign</a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $roles->links()}}
    </div>
    </div>

    </div>
