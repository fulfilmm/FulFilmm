<x-partials.modal id="project_task-create" title="Create Project Tasks">
    <form action="{{ route('project_tasks.store') }}" method="POST">
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <input type="hidden" name="keyword" value="normal">
        <x-forms.basic.input name="name" type="text" value="" title="Task Title" required></x-forms.basic.input>
        <x-forms.basic.input name="duration" type="text" value="" title="Duration" required></x-forms.basic.input>
        <x-forms.basic.date name="due_date" title="Due Date" required value=""></x-forms.basic.date>
        <div class="form-group row">
            <label class="col-form-label col-md-2">Task Members</label>
            <div class="col-md-10 w-100" id="co_owners">
                <select class="form-control" id="employees_multiple_select" style="width: 100%" name="project_task_employee[]"
                    multiple="multiple">
                    @foreach ($employees as $key => $employee)
                    
                    <option value={{$key}} @if($key === \Auth::id()) selected @endif>{{$employee}} </option>
                    @endforeach
                    
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-md-2">Assign Group</label>
            <div class="col-md-10 w-100" id="co_owners">
                <select class="form-control" id="groups_multiple_select" style="width: 100%" name="assigned_group[]"
                    multiple="multiple">
                    @foreach ($groups as $key => $group_name)
                    <option value={{$key}}  
                        @isset($assignment)
                            @if( in_array($key, $assignment->group_ids->toArray())) 
                                selected 
                            @endif
                        @endisset
                    >{{$group_name}} </option>
                    @endforeach
                    
                </select>
            </div>
        </div>
    
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
                    if($percentage > 0 && $percentage < 50.0){
                        $color = 'bg-danger';
                    }elseif($percentage > 49.0 && $percentage < 99.0){
                        $color = 'bg-warning';
                    }elseif($percentage === 100.0){
                        $color = 'bg-success';
                    }
                    @endphp
                    <h4>Progress</h4>
                    <div class="progress">
                        <div class="progress-bar {{$color ?? ''}}" role="progressbar"
                        style="width: {{$percentage}}%" aria-valuenow="{{$percentage}}"
                        aria-valuemin="0" aria-valuemax="100">
                        {{$percentage}}%
                    </div>
                </div>
            </div>
            <div class="task-list-body">
                <h4>Tasks</h4>
                <ul id="task-list">
                    
                    {{-- {{ dd($assignment->assignment_tasks) }}--}}
                    @forelse ($project->task as $task)
                    <li class="task">
                        {{-- <a href="{{route('projects.show', [$project->id, $task->id])}}"> --}}
                            <div class="task-container {{ $task_id === (string)$task->id ? 'bg-primary' : '' }}" onclick="gotoTask({{ $project->id }},{{$task->id}})">
                                <span class="task-label"   style="{{$task->status === 1 ? 'text-decoration: line-through' : '' }}"  contenteditable="false">{{ $task->name }}</span>
                                
                                {{--Delete form added here for cosmetic purposes--}}
                                <form  action="{{ route('project_tasks.destroy', $task->id) }}"
                                    id="project_task{{ $task->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                                </form>
                                
                                
                                <form action="{{route('project_tasks.toggle',$task->id)}}" id="project_task_toggle{{ $task->id }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                                    <input type="hidden" name="task_id" value="{{ $task->id}}">
                                </form>
                                
                                <span class="task-action-btn task-btn-right">
                                    {{-- <a class="action-circle large" href="{{route('projects.show', [$project->id, $task->id])}}">
                                        <i class="material-icons">visibility</i>
                                    </a> --}}
                                    <span class="action-circle large" onclick="toggleTask({{$task->id}}, event)"
                                        title="{{$task->status === 1 ? 'Uncheck' : 'Check'}}">
                                        <i class="material-icons">{{$task->status === 1 ? 'close' : 'check'}}</i>
                                    </span>
                                    {{-- <span class="action-circle large bg-danger"  title="Delete Task">
                                        <i class="material-icons" onclick="deleteProject({{$task->id}})">delete</i>
                                    </span> --}}
                                </span>
                            </div>
                            {{-- </a> --}}
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
    
    
    @push('scripts')
    <script>
        $(document).ready(function () {
            $('#employees_multiple_select').select2();
            $('#groups_multiple_select').select2();
            //scroll to chat-box bottom to view latest message;
            const chat_box = $('.chat-wrap-inner');
            chat_box.animate({scrollTop: 10000}, 1000);
            
            
            let success_alert = "{{ Session::get('success') }}"
            console.log(success_alert);
            if (success_alert) {
                updateNotification('Success!!', success_alert, 'success')
            }
            
            $('#project_status_toggle').change(() => {
                $('#project_status_toggle').submit()
            });
            
        })
        
        function gotoTask(project_id,task_id){
            window.location.href = '/projects/' + project_id + '/tasks/' + task_id   
        }
        
        function deleteProject(task_id) {
            $('#project_task' + task_id).submit();
        }
        
        function toggleTask(task_id, e) {
            e.stopImmediatePropagation()
            $('#project_task_toggle' + task_id).submit();
        }
        
        
        //trigger file Open when click on paper-clip icon
        function triggerFile(e) {
            $('#file').trigger('click');
            ;
        }
        
        var updateNotification = function (task, notificationText, newClass) {
            var notificationPopup = $('.notification-popup ');
            let notificationTimeout;
            notificationPopup.find('.task').text(task);
            notificationPopup.find('.notification-text').text(notificationText);
            notificationPopup.removeClass('hide success');
            // If a custom class is provided for the popup, add It
            if (newClass)
            notificationPopup.addClass(newClass);
            // If there is already a timeout running for hiding current popup, clear it.
            if (notificationTimeout)
            clearTimeout(notificationTimeout);
            // Init timeout for hiding popup after 3 seconds
            notificationTimeout = setTimeout(function () {
                notificationPopup.addClass('hide');
            }, 3000);
        };
    </script>
    @endpush
    