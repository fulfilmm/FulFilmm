<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-nowrap  mb-0 table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Parent Department</th>
                        <th>Department Head</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $department)
                        <tr>
                            <td>{{$department->name}}</td>
                            <td>{{ $department->parent_dept->name ?? '-' }}</td>
                            <td>{{ $department->departmentHeads[0]->employee->name ?? 'Null' }}</td>
                            <td style="display: flex">
                                <a class="btn btn-success btn-sm" href="{{route('departments.edit',$department->id)}}"><span class='fa fa-edit'></span></a>&nbsp;
                                <form action="{{route('departments.destroy',$department->id)}}" id="del-dept{{$department->id}}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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
