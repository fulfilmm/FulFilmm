@extends('layout.mainlayout')
@section('content')
<!-- Main Wrapper -->
<div class="chat-main-row">
    <div class="chat-main-wrapper">
        <div class="col-lg-7 message-view task-view task-left-sidebar">
            <div class="chat-window">
                <div class="fixed-header">
                    <div class="navbar">
                        <div class="float-left mr-auto">
                            <div class="add-task-btn-wrapper">
                                <span class="add-task-btn btn btn-white btn-sm">
                                    Add Task
                                </span>
                            </div>
                        </div>
                        <a class="task-chat profile-rightbar float-right" id="task_chat" href="#task_window"><i
                            class="fa fa fa-comment"></i></a>
                            
                            {{-- <ul class="nav float-right custom-menu">
                                
                                <li class="nav-item dropdown dropdown-action">
                                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                                        class="fa fa-cog"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="javascript:void(0)">Pending Tasks</a>
                                            <a class="dropdown-item" href="javascript:void(0)">Completed Tasks</a>
                                            <a class="dropdown-item" href="javascript:void(0)">All Tasks</a>
                                        </div>
                                    </li>
                                    
                                </ul> --}}
                            </div>
                        </div>
                        <div class="chat-contents">
                            <div class="chat-content-wrap">
                                <div class="chat-wrap-inner">
                                    <div class="chat-box">
                                        <div class="task-wrapper">
                                            <div class="task-list-container">
                                                <div class="task-list-body">
                                                    <ul id="task-list">
                                                        {{-- {{ dd($activity) }} --}}
                                                        @forelse ($activity->activity_tasks as $task)
                                                        <li class="task">
                                                            <div class="task-container">
                                                                <span class="task-label"
                                                                style="{{$task->status === 1 ? 'text-decoration: line-through' : '' }}"
                                                                contenteditable="false">{{ $task->title }}</span>
                                                                {{--Delete form added here for cosmetic purposes--}}
                                                                <form action="{{ route('activity_tasks.destroy', $task->id) }}"
                                                                    id="activity_task{{ $task->id }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input
                                                                    type="hidden"
                                                                    name="activity_id"
                                                                    value="{{ $activity->id }}">
                                                                </form>
                                                                
                                                                <form action="{{route('activity_tasks.toggle',$task->id)}}"
                                                                    id="activity_task_toggle{{ $task->id }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input
                                                                    type="hidden"
                                                                    name="activity_id"
                                                                    value="{{ $activity->id }}">
                                                                </form>
                                                                
                                                                <span class="task-action-btn task-btn-right">
                                                                    <span class="action-circle large" onclick="toggleTask({{$task->id}})"  title="{{$task->status === 1 ? 'Uncheck' : 'Check'}}">
                                                                        <i class="material-icons">{{$task->status === 1 ? 'close' : 'check'}}</i>
                                                                    </span>
                                                                    
                                                                    &nbsp;  &nbsp;
                                                                    
                                                                    <span class="action-circle large bg-danger"  title="Delete Task">
                                                                        <i class="material-icons" onclick="deleteActivity({{$task->id}})">delete</i>
                                                                    </span>
                                                                    
                                                                </span>
                                                            </div>
                                                        </li>
                                                        @empty
                                                        <li class="task">
                                                            <div class="task-container">
                                                                <span class="task-label" contenteditable="false">There is no task for this Activity yet.</span>
                                                            </div>
                                                        </li>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                                <div class="task-list-footer">
                                                    <div class="new-task-wrapper">
                                                        <form action="{{ route('activity_tasks.store') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="activity_id"
                                                            value="{{ $activity->id }}">
                                                            <textarea name="title"
                                                            placeholder="Enter new task here. . ."></textarea>
                                                            <span
                                                            class="error-message hidden">You need to enter a task first</span>
                                                            <button type="submit" class="add-new-task-btn btn"
                                                            id="add-new-task">Add Task
                                                        </button>
                                                        <span class="btn" id="close-task-panel">Close</span>
                                                    </form>
                                                    
                                                </div>
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
                                <form action="{{route('activities.acknowledge', ['id' => $activity->id])}}"
                                    method="post">
                                    @csrf
                                    @method('PUT')
                                    <button
                                    class="task-complete-btn {{$activity->is_acknowledged === 1 ? 'bg-success text-light' : ''}} "
                                    {{$activity->is_acknowledged === 1 ? 'disabled' : ''}} type="submit"
                                    id="acknowledege">
                                    <i class="material-icons">check</i>{{$activity->is_acknowledged === 1 ? 'acknowledged' : 'acknowledge'}}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="chat-contents task-chat-contents">
                    <div class="chat-content-wrap">
                        <div class="chat-wrap-inner">
                            <div class="chat-box">
                                <div class="chats">
                                    <h4>{{ $activity->title }}</h4>
                                    <div class="task-header">
                                        <div class="assignee-info">
                                            <a href="#" data-toggle="modal" data-target="#assignee">
                                                <div class="avatar">
                                                    <img alt="" src="img/profiles/avatar-02.jpg">
                                                </div>
                                                <div class="assigned-info">
                                                    
                                                    <div class="task-head-title">Task Owner</div>
                                                    <div
                                                    class="task-assignee">{{ Auth::guard('employee')->user()->name ?? 'Guest' }}</div>
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
                                                    <div class="task-head-title">Created Date</div>
                                                    <div class="">{{Carbon\Carbon::parse($activity->created_at)->toFormattedDateString()}}</div>
                                                </div>
                                            </a>
                                            <span class="remove-icon">
                                                <i class="fa fa-close"></i>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <hr class="task-line">
                                    
                                    @foreach ($messages as $data)
                                    {{-- {{dd($data->file)}} --}}
                                    @include('activity.partial.message',[
                                    'msg'=>$data->message,
                                    'file'=> $data->file,
                                    'name'=>$data->user->name,
                                    'date'=>$data->created_at,
                                    ])
                                    @endforeach
                                    
                                    
                                    {{-- <div class="task-information">
                                        <span class="task-info-line">
                                            <a class="task-user" href="#">John Doe</a>
                                            <span
                                            class="task-info-subject">marked task as incomplete</span>
                                        </span>
                                        <div class="task-time">1:16pm</div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chat-footer">
                    @include('layout.partials.commentbox', ['route' => 'activity'])
                </div>
            </div>
        </div>
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
        
        $('#activity_status_toggle').change(() => {
            $('#activity_status_toggle').submit()
        });
        
    })
    
    function deleteActivity(task_id) {
        $('#activity_task' + task_id).submit();
    }
    
    function toggleTask(task_id) {
        $('#activity_task_toggle' + task_id).submit();
    }
    
    function toggleAcitvityStatus(){
        
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