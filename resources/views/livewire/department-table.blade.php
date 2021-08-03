<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0 d-inline">Departments</h4>
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
                        <th>Parent Department</th>
                        <th>Deparment Head</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $department)
                        <tr>
                            <td>{{$department->name}}</td>
                            <td>{{ $department->parent_dept->name ?? '-' }}</td>
                            <td>{{ $department->departmentHeads[0]->employee->name ?? 'Null' }}</td>
                            <td>{{ $department->address }}</td>
                            <td style="display: flex">
                                <a class="btn btn-success" href="{{route('departments.edit',$department->id)}}"><span class='fa fa-edit'></span></a>&nbsp;
                                <form action="{{route('departments.destroy',$department->id)}}" id="del-dept{{$department->id}}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <a class="btn btn-danger" href="#" onclick="deleteDept({{$department->id}})"><span class='fa fa-trash'></span></a>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            {{$departments->links()}}
        </div>
    </div>
</div>
