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
                                @if ($project->status == 'proposed')
                                    <a class="task-complete-btn" id="proposal_accepted" href="{{ route('projects.accept_proposal', $project->id) }}">
                                        <i class="material-icons">check</i> Accept Proposal
                                    </a>
                                @elseif ($project->status == 'In progress')
                                    <a class="task-complete-btn" id="proposal_accepted" href="{{ route('projects.status_update', $project->id) }}">
                                        <i class="material-icons">check</i> Project is done
                                    </a>
                                @endif                                
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
                                        @if (isset(request()->route()->parameters['task_id']))
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
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (isset(request()->route()->parameters['task_id']))
                        <div class="chat-footer">
                            @include('project.partial.message_input_box')
                        </div>
                    @endif 
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
