<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0 d-inline">Assignments</h4>
        <div class="float-right">
            <input type="text" wire:model="search_key">
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-nowrap mb-0">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Assigned by</th>
                    <th>Creator Department</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($assignments as $assignment)
                    <tr>
                        <td>{{$assignment->title}}</td>
                        <td>{{$assignment->date}}</td>
                        <td>{{$assignment->assignedBy->name}}</td>
                        <td>{{$assignment->assignedBy->department->name}}</td>
                        <td style="display: flex">
                            <a class="btn btn-primary" href="{{route('assignments.show',$assignment->id)}}"><span class='fa fa-eye'></span></a>&nbsp;
{{--                            <a class="btn btn-success" href="{{route('assignments.edit',$assignment->id)}}"><span class='fa fa-edit'></span></a>&nbsp;--}}
                            <form action="{{route('assignments.destroy',$assignment->id)}}" id="del-assignment{{$assignment->id}}" method="POST">
                                @method('delete')
                                @csrf
                                <a class="btn btn-danger" href="#" onclick="deleteRecord({{$assignment->id}})"><span class='fa fa-trash'></span></a>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
{{--            {{$activities->links()}}--}}
        </div>
    </div>
</div>

