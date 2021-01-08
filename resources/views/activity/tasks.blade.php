@extends('layout.mainlayout')
@section('content')
    <!-- Main Wrapper -->
    <div class="chat-main-row" style="margin-top: 30px">
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
                                                            <span class="task-label" contenteditable="false">{{ $task->title }}</span>
                                                            <span class="task-action-btn task-btn-right">
																<span class="action-circle large delete-btn"
                                                                title="Delete Task">
																	<i class="material-icons">delete</i>
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
                                                        <input type="hidden" name="activity_id" value="{{ $activity->id }}">
                                                         <textarea name="title"
                                                                   placeholder="Enter new task here. . ."></textarea>
                                                        <span
                                                            class="error-message hidden">You need to enter a task first</span>
                                                        <button type="submit"  class="add-new-task-btn btn" id="add-new-task">Add Task</button>
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
                                <a class="task-complete-btn" id="task_complete" href="javascript:void(0);">
                                    <i class="material-icons">check</i> Mark Complete
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
                                        <h4>{{ $activity->title }}</h4>
                                        <div class="task-header">
                                            <div class="assignee-info">
                                                <a href="#" data-toggle="modal" data-target="#assignee">
                                                    <div class="avatar">
                                                        <img alt="" src="img/profiles/avatar-02.jpg">
                                                    </div>
                                                    <div class="assigned-info">
                                                        <div class="task-head-title">Task Owner</div>
                                                        <div class="task-assignee">{{ Auth::user()->name ?? 'Guest' }}</div>
                                                    </div>
                                                </a>
                                            </div>
                                            {{-- <div class="task-due-date">
                                                <a href="#" data-toggle="modal" data-target="#assignee">
                                                    <div class="due-icon">
																	<span>
																		<i class="material-icons">date_range</i>
																	</span>
                                                    </div>
                                                    <div class="due-info">
                                                        <div class="task-head-title">Due Date</div>
                                                        <div class="due-date">Mar 26, 2019</div>
                                                    </div>
                                                </a>
                                                <span class="remove-icon">
																<i class="fa fa-close"></i>
															</span>
                                            </div> --}}
                                        </div>
                                        <hr class="task-line">
                                        <div class="task-desc">
                                            <div class="task-desc-icon">
                                                <i class="material-icons">subject</i>
                                            </div>
                                            <div class="task-textarea">
                                                <textarea class="form-control" placeholder="Description"></textarea>
                                            </div>
                                        </div>
                                        <hr class="task-line">
                                        <div class="task-information">
                                            <span class="task-info-line"><a class="task-user" href="#">Lesley Grauer</a> <span
                                                    class="task-info-subject">created task</span></span>
                                            <div class="task-time">Jan 20, 2019</div>
                                        </div>
                                        <div class="task-information">
                                            <span class="task-info-line"><a class="task-user" href="#">Lesley Grauer</a> <span
                                                    class="task-info-subject">added to Hospital Administration</span></span>
                                            <div class="task-time">Jan 20, 2019</div>
                                        </div>
                                        <div class="task-information">
                                            <span class="task-info-line"><a class="task-user" href="#">Lesley Grauer</a> <span
                                                    class="task-info-subject">assigned to John Doe</span></span>
                                            <div class="task-time">Jan 20, 2019</div>
                                        </div>
                                        <hr class="task-line">
                                        <div class="task-information">
                                            <span class="task-info-line"><a class="task-user"
                                                                            href="#">John Doe</a> <span
                                                    class="task-info-subject">changed the due date to Sep 28</span> </span>
                                            <div class="task-time">9:09pm</div>
                                        </div>
                                        <div class="task-information">
                                            <span class="task-info-line"><a class="task-user"
                                                                            href="#">John Doe</a> <span
                                                    class="task-info-subject">assigned to you</span></span>
                                            <div class="task-time">9:10pm</div>
                                        </div>
                                        <div class="chat chat-left">
                                            <div class="chat-avatar">
                                                <a href="profile" class="avatar">
                                                    <img alt="" src="img/profiles/avatar-02.jpg">
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-bubble">
                                                    <div class="chat-content">
                                                        <span class="task-chat-user">John Doe</span> <span
                                                            class="chat-time">8:35 am</span>
                                                        <p>I'm just looking around.</p>
                                                        <p>Will you tell me something about yourself? </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="completed-task-msg"><span class="task-success"><a
                                                    href="#">John Doe</a> completed this task.</span> <span
                                                class="task-time">Today at 9:27am</span></div>
                                        <div class="chat chat-left">
                                            <div class="chat-avatar">
                                                <a href="profile" class="avatar">
                                                    <img alt="" src="img/profiles/avatar-02.jpg">
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-bubble">
                                                    <div class="chat-content">
                                                        <span class="task-chat-user">John Doe</span> <span
                                                            class="file-attached">attached 3 files <i
                                                                class="fa fa-paperclip"></i></span> <span
                                                            class="chat-time">Feb 17, 2019 at 4:32am</span>
                                                        <ul class="attach-list">
                                                            <li><i class="fa fa-file"></i> <a href="#">project_document.avi</a>
                                                            </li>
                                                            <li><i class="fa fa-file"></i> <a href="#">video_conferencing.psd</a>
                                                            </li>
                                                            <li><i class="fa fa-file"></i> <a
                                                                    href="#">landing_page.psd</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat chat-left">
                                            <div class="chat-avatar">
                                                <a href="profile" class="avatar">
                                                    <img alt="" src="img/profiles/avatar-16.jpg">
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-bubble">
                                                    <div class="chat-content">
                                                        <span class="task-chat-user">Jeffery Lalor</span> <span
                                                            class="file-attached">attached file <i
                                                                class="fa fa-paperclip"></i></span> <span
                                                            class="chat-time">Yesterday at 9:16pm</span>
                                                        <ul class="attach-list">
                                                            <li class="pdf-file"><i class="fa fa-file-pdf-o"></i> <a
                                                                    href="#">Document_2016.pdf</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat chat-left">
                                            <div class="chat-avatar">
                                                <a href="profile" class="avatar">
                                                    <img alt="" src="img/profiles/avatar-16.jpg">
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-bubble">
                                                    <div class="chat-content">
                                                        <span class="task-chat-user">Jeffery Lalor</span> <span
                                                            class="file-attached">attached file <i
                                                                class="fa fa-paperclip"></i></span> <span
                                                            class="chat-time">Today at 12:42pm</span>
                                                        <ul class="attach-list">
                                                            <li class="img-file">
                                                                <div class="attach-img-download"><a href="#">avatar-1.jpg</a>
                                                                </div>
                                                                <div class="task-attach-img"><img src="img/user.jpg"
                                                                                                  alt=""></div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="task-information">
														<span class="task-info-line">
															<a class="task-user" href="#">John Doe</a>
															<span
                                                                class="task-info-subject">marked task as incomplete</span>
														</span>
                                            <div class="task-time">1:16pm</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-footer">
                        <div class="message-bar">
                            <div class="message-inner">
                                <a class="link attach-icon" href="#"><img src="img/attachment.png" alt=""></a>
                                <div class="message-area">
                                    <div class="input-group">
                                        <textarea class="form-control" placeholder="Type message..."></textarea>
                                        <span class="input-group-append">
														<button class="btn btn-primary" type="button"><i
                                                                class="fa fa-send"></i></button>
													</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="project-members task-followers">
                            <span class="followers-title">Followers</span>
                            <a class="avatar" href="#" data-toggle="tooltip" title="Jeffery Lalor">
                                <img alt="" src="img/profiles/avatar-16.jpg">
                            </a>
                            <a class="avatar" href="#" data-toggle="tooltip" title="Richard Miles">
                                <img alt="" src="img/profiles/avatar-09.jpg">
                            </a>
                            <a class="avatar" href="#" data-toggle="tooltip" title="John Smith">
                                <img alt="" src="img/profiles/avatar-10.jpg">
                            </a>
                            <a class="avatar" href="#" data-toggle="tooltip" title="Mike Litorus">
                                <img alt="" src="img/profiles/avatar-05.jpg">
                            </a>
                            <a href="#" class="followers-add" data-toggle="modal" data-target="#task_followers"><i
                                    class="material-icons">add</i></a>
                        </div>
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
    @livewireScripts
@endpush
