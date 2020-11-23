<div>

    <input type="text" wire:model="search_key">
    <table>
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
            <td>{{ $em->department_id }}</td>
            <td>{{ $em->role_id }}</td>
            <td>
            <a href="{{route('employees.edit',$em->id)}}">Edit</a>
            <form action="{{route('employees.destroy',$em->id)}}" method="POST">
                @method('delete')
                @csrf
                <button type="submit">delete</button>
               </form>
            </td>
            </tr>
        @endforeach
    </table>
    {{ $employees->links()}}
</div>
