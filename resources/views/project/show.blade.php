@extends('layout.mainlayout')

@section('title', $project->title)

@section('content')
    <div class="chat-main-row">
        <div class="chat-main-wrapper">
            <div class="col-lg-7 message-view task-view task-left-sidebar">
                <div class="">
                    <ul class="nav nav-tabs nav-tabs-solid nav-justified mb-0">
                        <li class="nav-item"><a class="nav-link active" href="#tasks"
                                                data-toggle="tab">Tasks</a></li>
                        <li class="nav-item"><a class="nav-link" href="#proposed_budget"
                                                data-toggle="tab">Proposed Budget</a></li>
                        <li class="nav-item"><a class="nav-link" href="#proposed_resource" data-toggle="tab">Proposed
                                Resource</a></li>
                    </ul>
                    <div class="tab-content p-0">
                        <div class="tab-pane show active" id="tasks">
                            @include('project.partial.task')
                        </div>
                        <div class="tab-pane" id="proposed_budget">
                            @include('project.partial.budget')
                        </div>
                        <div class="tab-pane" id="proposed_resource">
                            @include('project.partial.resource')
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
                                        {{--{{dd($assignment->assigned_employees->pluck('name'))}}--}}
                                        <h4> {{ $task_id === null ? 'Please select a task to view detail' : 'Assigned Employees for '. $project->task->find($task_id)->name}}</h4>
                                        <ol>
                                            @if($task_id !== null)
                                                @foreach($project->task->find($task_id)->assigned_employees as $employee)
                                                    <li>
                                                        {{$employee->name}}
                                                    </li>
                                                @endforeach

                                                @if (isset($assignment->assigned_groups))
                                                    @foreach ($assignment->assigned_groups as $group)
                                                        @foreach ($group->employees as $employee)
                                                            <li>{{ $employee->name }}</li>
                                                        @endforeach
                                                    @endforeach
                                                @endif

                                                @endif
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

@endpush
