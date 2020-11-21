<div>

    <input type="text" wire:model="search_key">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Parent Department</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        @foreach ($departments as $department)
            <tr>
            <td>{{$department->name}}</td>
            <td>{{ $department->parent_department }}</td>
            <td>{{ $department->address }}</td>
            <td>
            <a href="{{route('departments.edit',$department->id)}}">Edit</a>
            <form action="{{route('departments.destroy',$department->id)}}" method="POST">
                @method('delete')
                @csrf
                <button type="submit">delete</button>
               </form>
            </td>
            </tr>
        @endforeach
    </table>
</div>
