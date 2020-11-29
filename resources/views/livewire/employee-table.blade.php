<div>
{{--  --}}

<div class="flex row mb-2">
    <input type="text" class="form-control col-3 ml-auto" placeholder="Search Name" wire:model="search_key">
    <a href={{url('/employees/export')}}><button  class="btn btn-primary ml-2">Export</button></a>

</div>
    <div class="table-responsive">   
        <table class="table ">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Work Phone</th>
                <th>Join Date</th>
                <th>can login</th>
                <th>Department</th>
                <th>Position</th>
                <th>Action</th>
            </tr>
        </thead>
        @foreach ($employees as $em)
            <tr>
                <td>{{$em->name}}</td>
            <td>{{ $em->email }}</td>
            <td>{{ $em->phone }}</td>
            <td>{{ $em->work_phone }}</td>
            <td>{{ $em->join_date }}</td>
            <td>{{ $em->can_login }}</td>
            <td>{{ $em->department->name }}</td>
            <td>{{ $em->role_id }}</td>
            <td class="row">
            <a class="pr-2 my-auto" href="{{route('employees.edit',$em->id)}}">Edit</a>
        
            <form  id="employee-del-{{$em->id}}" action="{{route('employees.destroy',$em->id)}}" method="POST">
                @method('delete')
                @csrf
                <button class="btn btn-danger" onclick="deleteRecord({{$em->id}})" type="submit">delete</button>
               </form>
            </td>
            </tr>
        @endforeach
    </table></div>
 
    {{ $employees->links()}}
</div>
