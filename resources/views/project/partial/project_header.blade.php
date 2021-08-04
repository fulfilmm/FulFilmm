<h4>{{ $project->title }}</h4>
<div class="task-header">
    <div class="assignee-info">
        <a href="#" data-toggle="modal" data-target="#owner">
            <div class="avatar">
                <img alt="" src="">
            </div>
            <div class="assigned-info">

                <div class="task-head-title">Owner</div>
                <div
                    class="task-assignee">{{$project->ownedBy->name}}</div>
            </div>
        </a>
    </div>

    <div class="assignee-info">
        <a href="#" data-toggle="modal" data-target="#proposed_to">
            <div class="avatar">
                <img alt="" src="">
            </div>
            <div class="assigned-info">

                <div class="task-head-title">Proposed To</div>
                <div
                    class="task-assignee">{{$project->proposedTo->name}}</div>
            </div>
        </a>
    </div>
    <div class="assignee-info">
        <a href="#" data-toggle="modal" data-target="#leader">
            <div class="avatar">
                <img alt="" src="">
            </div>
            <div class="assigned-info">

                <div class="task-head-title">Leader</div>
                <div
                    class="task-assignee">{{$project->leadedBy->name}}</div>
            </div>
        </a>
    </div>
</div>
<div class="task-header">
    <div class="task-due-date">
        <a href="#" data-toggle="modal" data-target="#assignee">
            <div class="due-icon">
                <span>
                    <i class="material-icons">date_range</i>
                </span>
            </div>
            <div class="due-info">
                <div class="task-head-title">Due Date</div>
                <div
                    class="{{$project->end_date >= today() ? 'black' : 'due-date'}}">{{$project->end_date}}</div>
            </div>
        </a>
        {{--                                                <span class="remove-icon">--}}
        {{--																<i class="fa fa-close"></i>--}}
        {{--                                                </span>--}}
    </div>
</div>
