@extends('layout.mainlayout')
@section('content')

    <x-partials.modal id="assignment_tasks-create" title="Create Assignment Tasks">
        <form action="{{ route('assignment_tasks.store') }}" method="POST">
            @csrf
            <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
            <x-forms.basic.input name="name" type="text" value="" title="Task Title" required></x-forms.basic.input>

            <div class="d-flex justify-content-center">
                <button class="btn btn-primary">Create</button>
            </div>
        </form>
    </x-partials.modal>


    <div class="chat-main-row">
        <div class="chat-main-wrapper">
            <div class="col-lg-7 message-view task-view task-left-sidebar">
                <div class="chat-window">
                    <div class="fixed-header">
                        <div class="navbar">
                            <div class="float-left mr-auto">
                                <div class="add-task-btn-wrapper">
                                    <span class="add-task-btn btn btn-white btn-sm" data-toggle="modal"
                                          data-target="#assignment_tasks-create"> Add Task </span>
                                </div>
                            </div>
                            <a class="task-chat profile-rightbar float-right" id="task_chat" href="#task_window"><i
                                    class="fa fa fa-comment"></i></a>
                        </div>
                    </div>

                    <div class="chat-contents">
                        <div class="chat-content-wrap">
                            <div class="chat-wrap-inner">
                                <div class="chat-box">
                                    <div class="task-wrapper">
                                        <div class="task-list-container">
                                            <div class="task-list-body mb-5">
                                                @php
                                                    $percentage = round(($assignment->task_done / $assignment->total_tasks) * 100);
                                                @endphp
                                                <h4>Progress</h4>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: {{$percentage}}%" aria-valuenow="{{$percentage}}" aria-valuemin="0" aria-valuemax="100">
                                                        {{$percentage}}%</div>
                                                </div>
                                            </div>
                                            <div class="task-list-body">
                                                <h4>Tasks</h4>
                                                <ul id="task-list">
                                                    {{--                                                                                                         {{ dd($assignment->assignment_tasks) }}--}}
                                                    @forelse ($assignment->assignment_tasks as $task)
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
                                                                        value="{{ $assignment->id }}">
                                                                </form>

                                                                <form
                                                                    action="{{route('assignment_tasks.toggle',$task->id)}}"
                                                                    id="assignment_task_toggle{{ $task->id }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input
                                                                        type="hidden"
                                                                        name="assignment_id"
                                                                        value="{{ $assignment->id }}">
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
                                                                <span class="task-label" contenteditable="false">There is no task for this Assignment yet.</span>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 message-view task-chat-view task-right-sidebar" id="task_window">
                <div class="chat-window">
                    <div class="fixed-header">
                        <div class="navbar">
                            <div class="task-assign">

                                {{--Acknowledge button here--}}
                                <a class="task-complete-btn" id="task_complete" href="javascript:void(0);">
                                    <i class="material-icons">check</i> Acknowledge
                                </a>
                            </div>
                            <ul class="nav float-right custom-menu">
                                <li class="dropdown dropdown-action">
                                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                                            class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)">Delete Task</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Settings</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="chat-contents task-chat-contents">
                        <div class="chat-content-wrap">
                            <div class="chat-wrap-inner">
                                <div class="chat-box">
                                    <div class="chats">
                                        <h4>{{ $assignment->title }}</h4>
                                        <div class="task-header">
                                            <div class="assignee-info">
                                                <a href="#" data-toggle="modal" data-target="#assignee">
                                                    <div class="avatar">
                                                        <img alt="" src="">
                                                    </div>
                                                    <div class="assigned-info">

                                                        <div class="task-head-title">Task Owner</div>
                                                        <div
                                                            class="task-assignee">{{$assignment->assignedBy->name}}</div>
                                                    </div>
                                                </a>
                                            </div>
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
                                                            class="{{$assignment->due_date >= today() ? 'black' : 'due-date'}}">{{$assignment->due_date}}</div>
                                                    </div>
                                                </a>
                                                {{--                                                <span class="remove-icon">--}}
                                                {{--																<i class="fa fa-close"></i>--}}
                                                {{--                                                </span>--}}
                                            </div>
                                        </div>

                                        <hr class="task-line">
                                        {{--{{dd($assignment->assigned_employees->pluck('name'))}}--}}
                                        <h4>Assigned Employees</h4>
                                        <ol>

                                            @foreach($assignment->assigned_employees as $employee)
                                                <li>
                                                    {{$employee->name}}
                                                </li>
                                            @endforeach
                                        </ol>
                                        <hr class="task-line">
                                        @foreach ($messages as $data)
                                            @include('assignment.partial.message',[
                                              'msg'=>$data->message,
                                              'file'=> $data->file,
                                              'name'=>$data->user->name,
                                              'date'=>$data->created_at,
                                          ])
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-footer">
                        @include('assignment.partial.message_input_box')
                    </div>
                </div>
            </div>`
        </div>
    </div>

    <!-- /Page Wrapper -->
    <!-- /Main Wrapper -->
@endsection
@section('styles')
    @livewireStyles
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            //scroll to chat-box bottom to view latest message;
            const chat_box = $('.chat-wrap-inner');
            chat_box.animate({scrollTop: 10000}, 1000);


            let success_alert = "{{ Session::get('success') }}"
            console.log(success_alert);
            if (success_alert) {
                updateNotification('Success!!', success_alert, 'success')
            }

        })

        function deleteAssignment(task_id) {
            $('#assignment_task' + task_id).submit();
        }

        function toggleTask(task_id) {
            $('#assignment_task_toggle' + task_id).submit();
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
