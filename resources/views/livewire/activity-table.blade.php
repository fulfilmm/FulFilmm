<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0 d-inline">Activities</h4>
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
                    <th>Report To</th>
<<<<<<< HEAD
                    <th>Customer Name</th>
=======
>>>>>>> feature/activities
                    <th>Acknowledged By</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($activities as $activity)
                    <tr>
                        <td>{{$activity->title}}</td>
<<<<<<< HEAD
                        <td>{{$activity->report_to_employee_id->name}}</td>
                        <td>{{$activity->customer->name}}</td>
                        <td>{{$activity->is_acknowledged}}</td>
                        <td style="display: flex">
                            <a class="btn btn-primary" href="{{route('$activities.detail', $activities->id)}}">Details</a>&nbsp;
                            <form action="{{route('activities.destroy', $activities->id)}}" id="del-activities{{$activity->id}}" method="POST">
=======
                        <td>{{$activity->report_to_employee->name}}</td>
                        <td>{{$activity->is_acknowledged == 0 ? 'No' : 'Yes'}}</td>
                        <td style="display: flex">
                            <a class="btn btn-primary" href="{{route('activities.show', $activity->id)}}"><span class="fa fa-eye"></span></a>&nbsp;
                            <form action="{{route('activities.destroy', $activity->id)}}" id="del-activities{{$activity->id}}" method="POST">
>>>>>>> feature/activities
                                @method('delete')
                                @csrf
                                <a class="btn btn-danger" href="#" onclick="deleteRecord({{$activity->id}})"><span class='fa fa-trash'></span></a>
                            </form>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            {{$activities->links()}}
        </div>
    </div>
</div>

