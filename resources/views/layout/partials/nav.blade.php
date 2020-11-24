<div class="main-wrapper">
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title">
                        <span>Main</span>
                    </li>
                    <li class="submenu"> <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li class="{{ Request::is('index') ? 'active' : '' }}"> <a  href="{{ url('index') }}">Admin Dashboard</a></li>
                            <li> <a class="{{ Request::is('employee-dashboard') ? 'active' : '' }}" href="{{ url('employee-dashboard') }}">Employee Dashboard</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span> Apps</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li class="{{ Request::is('chat') ? 'active' : '' }}">
                                <a  href="{{ url('chat') }}">Chat</a></li>

                                <li class="submenu">
                                    <a href="#"><span> Calls</span> <span class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li class="{{ Request::is('voice-call') ? 'active' : '' }}"><a  href="{{ url('voice-call') }}">Voice Call</a></li>

                                        <li class="{{ Request::is('video-call') ? 'active' : '' }}"> <a  href="{{ url('video-call') }}">Video Call</a></li>

                                        <li class="{{ Request::is('outgoing-call') ? 'active' : '' }}"> <a  href="{{ url('outgoing-call') }}">Outgoing Call</a></li>

                                        <li class="{{ Request::is('incoming-call') ? 'active' : '' }}"> <a  href="{{ url('incoming-call') }}">Incoming Call</a></li>


                                    </ul>
                                </li>

                                <li><a class="{{ Request::is('events') ? 'active' : '' }}" href="{{ url('events') }}">Calendar</a></li>

                                <li><a class="{{ Request::is('contacts') ? 'active' : '' }}" href="{{ url('contacts') }}">Contacts</a></li>

                                <li><a class="{{ Request::is('inbox') ? 'active' : '' }}" href="{{ url('inbox') }}">Email</a></li>

                                <li><a class="{{ Request::is('file-manager') ? 'active' : '' }}"  href="{{ url('file-manager') }}">File Manager</a></li>


                            </ul>
                        </li>
                        <li class="menu-title">
                            <span>Employees</span>
                        </li>
                        <li class="submenu">
                            <a href="#" class="noti-dot"><i class="la la-user"></i> <span> Employees</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">

                                <li><a class="{{ Request::is('employees') ? 'active' : '' }}" href="{{ url('employees') }}">All Employees</a></li>

                                <li><a class="{{ Request::is('holidays') ? 'active' : '' }}" href="{{ url('holidays') }}">Holidays</a></li>

                                <li><a class="{{ Request::is('leaves') ? 'active' : '' }}" href="{{ url('leaves') }}">Leaves (Admin) <span class="badge badge-pill bg-primary float-right">1</span></a></li>

                                <li><a class="{{ Request::is('leaves-employee') ? 'active' : '' }}" href="{{ url('leaves-employee') }}">Leaves (employee)</a></li>

                                <li><a class="{{ Request::is('leave-settings') ? 'active' : '' }}" href="{{ url('leave-settings') }}">Leave Settings</a></li>

                                <li><a class="{{ Request::is('attendance') ? 'active' : '' }}" href="{{ url('attendance') }}">Attendance (Admin)</a></li>

                                <li><a class="{{ Request::is('attendance-employee') ? 'active' : '' }}" href="{{ url('attendance-employee') }}">Attendance (Employee)</a></li>

                                <li><a class="{{ Request::is('departments') ? 'active' : '' }}" href="{{ url('departments') }}">Departments</a></li>

                                <li><a class="{{ Request::is('designations') ? 'active' : '' }}" href="{{ url('designations') }}">Designations</a></li>

                                <li><a class="{{ Request::is('timesheet') ? 'active' : '' }}" href="{{ url('timesheet') }}">Timesheet</a></li>

                                <li><a class="{{ Request::is('overtime') ? 'active' : '' }}" href="{{ url('overtime') }}">Overtime</a></li>

                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="#"><i class="la la-company"></i> <span> Company</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">

                                <li><a class="{{ Request::is('companies') ? 'active' : '' }}" href="{{ route('companies.index') }}">All Companies</a></li>

                                <li><a class="{{ Request::is('holidays') ? 'active' : '' }}" href="{{ route('companies.create') }}">Create Company</a></li>

                            </ul>
                        </li>

                        <li class="{{ Request::is('clients') ? 'active' : '' }}">
                            <a  href="{{ url('clients') }}"><i class="la la-users"></i> <span>Clients</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


