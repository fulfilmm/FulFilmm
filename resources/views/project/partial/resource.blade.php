<x-partials.modal id="project_resource-create" title="Create Project Budget">
    <form action="{{ route('project_tasks.store') }}" method="POST">
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <input type="hidden" name="keyword" value="proposed_resource">
        <x-forms.basic.input name="name" type="text" value="" title="Resource Name" required></x-forms.basic.input>

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
                      data-target="#project_resource-create"> Add Resource </span>
            </div>
        </div>
        <a class="task-chat profile-rightbar float-right" id="task_chat" href="#task_window"><i
                class="fa fa fa-comment"></i></a>
    </div>

    <div class="task-wrapper">
        <div class="task-list-container">
            <div class="task-list-body">
                <h4>Resource</h4>
                <ul id="task-list">
                    {{--                                                                                                         {{ dd($assignment->assignment_tasks) }}--}}
                    @forelse ($project->proposed_resource as $task)
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
                                    <span class="action-circle large bg-danger"
                                          title="Delete Task">
                                        <i class="material-icons" onclick="deleteAssignment({{$task->id}})">delete</i>
                                    </span>
                                </span>
                            </div>
                        </li>
                    @empty
                        <li class="task">
                            <div class="task-container">
                            <span class="task-label"
                                  contenteditable="false">There is no resource</span>
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

