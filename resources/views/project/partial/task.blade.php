<x-partials.modal id="project_task-create" title="Create Project Tasks">
    <form action="{{ route('project_tasks.store') }}" method="POST">
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <x-forms.basic.input name="name" type="text" value="" title="Task Title" required></x-forms.basic.input>

        <div class="d-flex justify-content-center">
            <button class="btn btn-primary">Create</button>
        </div>
    </form>
</x-partials.modal>

<div class="pt-3">
    <div class="navbar">
        <div class="float-left mr-auto">
            <div class="add-task-btn-wrapper">
                                    <span class="add-task-btn btn btn-white btn-sm" data-toggle="modal"
                                          data-target="#project_task-create"> Add Task </span>
            </div>
        </div>
        <a class="task-chat profile-rightbar float-right" id="task_chat" href="#task_window"><i
                class="fa fa fa-comment"></i></a>
    </div>

    <div class="task-wrapper">
        <div class="task-list-container">
            <div class="task-list-body mb-5">
                @php
                    if($project->total_tasks === 0){
                        $percentage = 0;
                    }else{
                          $percentage = round(($project->task_done / $project->total_tasks) * 100);
                    }

                @endphp
                <h4>Progress</h4>
                <div class="progress">
                    <div class="progress-bar" role="progressbar"
                         style="width: {{$percentage}}%" aria-valuenow="{{$percentage}}"
                         aria-valuemin="0" aria-valuemax="100">
                        {{$percentage}}%
                    </div>
                </div>
            </div>
            <div class="task-list-body">
                <h4>Tasks</h4>
                <ul id="task-list">
                    {{--                                                                                                         {{ dd($assignment->assignment_tasks) }}--}}
                    @forelse ($project->task as $task)
                        <li class="task">
                            <div class="task-container">

                                                                <span class="task-label"
                                                                      style="{{$task->status === 1 ? 'text-decoration: line-through' : '' }}"
                                                                      contenteditable="false">{{ $task->name }}</span>

                                {{--Delete form added here for cosmetic purposes--}}
                                <form
                                    action="{{ route('assignment_tasks.destroy', $task->id) }}"
                                    id="assignment_task{{ $task->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input
                                        type="hidden"
                                        name="assignment_id"
                                        value="{{ $project->id }}">
                                </form>


                                <span class="task-action-btn task-btn-right">
                                                                        <span class="action-circle large"
                                                                              onclick="toggleTask({{$task->id}})"
                                                                              title="{{$task->status === 1 ? 'Uncheck' : 'Check'}}">
                                                                            <i class="material-icons">{{$task->status === 1 ? 'close' : 'check'}}</i>
                                                                        </span>

                                                                        &nbsp;  &nbsp;

                                                                        <span class="action-circle large bg-danger"
                                                                              title="Delete Task">
                                                                            <i class="material-icons"
                                                                               onclick="deleteAssignment({{$task->id}})">delete</i>
                                                                        </span>

															    </span>
                            </div>
                        </li>
                    @empty
                        <li class="task">
                            <div class="task-container">
                            <span class="task-label"
                                  contenteditable="false">There is no task for this Project yet.</span>
                            </div>
                        </li>
                    @endforelse

                </ul>
            </div>
        </div>
    </div>
    <div class="notification-popup hide">
        <p>
            <span class="task"></span>
            <span class="notification-text"></span>
        </p>
    </div>

</div>

