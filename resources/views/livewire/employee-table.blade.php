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
        <table class="table table-nowrap mb-0 ">
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
            <td style="display: flex">
            <a class="pr-2 my-auto btn btn-success" href="{{route('employees.edit',$em->id)}}">
                <span class='fa fa-edit'></span>
            </a>
        
            <form  id="employee-del-{{$em->id}}" action="{{route('employees.destroy',$em->id)}}" method="POST">
                @method('delete')
                @csrf
                <button class="btn btn-danger" onclick="deleteRecord({{$em->id}})" type="submit"><span class='fa fa-trash'></span></button>
               </form>
            </td>
            </tr>
        @endforeach
    </table>
    {{ $employees->links()}}
</div>
</div>
 
</div>
