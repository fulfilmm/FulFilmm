<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0 d-inline">Assignments</h4>
        <div class="float-right">
            <input type="text" wire:model="search_key">
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-nowrap datatable mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Assigned by</th>
                        <th>Percentage</th>
                        <th>Creator Department</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($assignments as $assignment)
                    
                    @php
                    if($assignment->total_tasks === 0){
                        $percentage = 0;
                    }else{
                        $percentage = round(($assignment->task_done / $assignment->total_tasks) * 100);
                    }
                    
                    if($percentage > 0 && $percentage < 50.0){
                        $color = 'bg-danger';
                    }elseif($percentage > 49.0 && $percentage < 99.0){
                        $color = 'bg-warning';
                    }elseif($percentage === 100.0){
                        $color = 'bg-success';
                    }   
                    @endphp

                    <tr>
                        <td>{{$assignment->title}}</td>
                        <td class="{{$assignment->due_date >= today() ? 'text-dark' : 'text-danger'}}">{{$assignment->due_date}}</td>
                        <td>{{$assignment->status}}</td>
                        <td>{{$assignment->assignedBy->name}}</td>
                        <td> <div class="progress">
                            <div class="progress-bar {{$color ?? ''}}" role="progressbar"
                            style="width: {{$percentage}}%" aria-valuenow="{{$percentage}}"
                            aria-valuemin="0" aria-valuemax="100">
                            {{$percentage}}%
                        </div></td>
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

