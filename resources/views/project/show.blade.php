@extends('layout.mainlayout')
@section('content')
    <div class="chat-main-row">
        <div class="chat-main-wrapper">
            <div class="col-lg-7 message-view task-view task-left-sidebar">
                <div>
                    <ul class="nav nav-tabs nav-tabs-solid nav-justified mb-0">
                        <li class="nav-item"><a class="nav-link active" href="#tasks"
                                                data-toggle="tab">Tasks</a></li>
                        <li class="nav-item"><a class="nav-link" href="#team_members"
                                                data-toggle="tab">Members</a></li>
                        <li class="nav-item"><a class="nav-link" href="#proposed_resource" data-toggle="tab">Proposed
                                Resource</a></li>
                    </ul>
                    <div class="tab-content p-0">
                        <div class="tab-pane show active" id="tasks">
                            @include('project.partial.task')
                        </div>
                        <div class="tab-pane" id="team_members">
                            These are team members
                        </div>
                        <div class="tab-pane" id="proposed_resource">
                            These are resources
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
                                {{--                                <a class="task-complete-btn" id="task_complete" href="javascript:void(0);">--}}
                                {{--                                    <i class="material-icons">check</i> Acknowledge--}}
                                {{--                                </a>--}}
                                {{--                                <div>--}}
                                {{--                                    <h3>Status</h3>--}}
                                {{--                                    <form id="assignment_status_toggle" action="{{route('assignments.changeStatus', ['id' => $assignment->id])}}" method="POST">--}}
                                {{--                                        @csrf--}}
                                {{--                                        @method('PUT')--}}
                                {{--                                        <select class="form-control" name="status"--}}
                                {{--                                                required>--}}
                                {{--                                            <option disabled class="">Change Status to : </option>--}}
                                {{--                                            <option value='created' @if($assignment->status === 'created') selected @endif> Created  </option>--}}
                                {{--                                            <option value='working' @if($assignment->status === 'working') selected @endif> Working  </option>--}}
                                {{--                                            <option value='done' @if($assignment->status === 'done') selected @endif> Done  </option>--}}
                                {{--                                        </select>--}}
                                {{--                                    </form>--}}
                                {{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                    <div class="chat-contents task-chat-contents">
                        <div class="chat-content-wrap">
                            <div class="chat-wrap-inner">
                                <div class="chat-box">
                                    <div class="chats">
                                        @include('project.partial.project_header')
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
                        @include('project.partial.message_input_box')
                    </div>
                </div>
            </div>
            `
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

            $('#assignment_status_toggle').change(() => {
                $('#assignment_status_toggle').submit()
            });

        })

        function deleteAssignment(task_id) {
            $('#assignment_task' + task_id).submit();
        }

        function toggleTask(task_id) {
            $('#assignment_task_toggle' + task_id).submit();
        }

        function toggleAssignmentStatus() {

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
