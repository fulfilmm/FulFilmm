<div class="card">
{{--  --}}
<div class="card-header">
    <h4 class="card-title mb-0 d-inline">Employees</h4>
    <div class="float-right">
        <input type="text" wire:model="search_key">
    </div>
</div>
    {{-- <a href={{url('/employees/export')}}><button  class="btn btn-primary ml-2">Export</button></a> --}}
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-nowrap datatable mb-0 " id="emp">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>

                <th>Email</th>
                <th>Phone</th>
                <th>Work Phone</th>
                <th>Department</th>
                <th>Join Date</th>
                <th>Can login</th>
                {{--<th>Can post assignments</th>--}}

                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        @foreach ($employees as $em)
            <tr>
                <td>{{$em->empid}}</td>
                <td style="min-width: 200px"><img src="{{$em->profile_img!=null? url(asset('img/profiles/'.$em->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar chat-avatar-sm">{{$em->name}}</td>

                <td style="min-width:200px;">{{ $em->email }}</td>
                <td>{{ $em->phone }}</td>
                <td>{{ $em->work_phone }}</td>
                <td>{{ $em->department->name }}</td>
                <td>{{ $em->join_date }}</td>
                <td>{{ $em->can_login ? 'Yes' : 'No' }}</td>
                {{--<td>{{ $em->can_post_assignments ? 'Yes' : 'No' }}</td>--}}

                <td>{{$em->getRoleNames()[0] ?? ''}}</td>
                <td style="display: flex">
                <a class="pr-2 my-auto btn btn-success" title="Edit"  href="{{route('employees.edit',$em->id)}}">
                    <span class='fa fa-edit'></span>
                </a>&nbsp;
                <form  id="employee-del-{{$em->id}}" action="{{route('employees.destroy',$em->id)}}" method="POST">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger" data-toggle="tooltip" title="Delete" onclick="deleteRecord({{$em->id}})" type="submit"><span class='fa fa-trash'></span></button>
                </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $employees->links()}}
</div>
</div>

</div>

