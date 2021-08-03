<div class="main-wrapper">
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title">
                        <span>Main</span>
                    </li>
                    <li class="submenu"><a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li class="{{ Request::is('index') ? 'active' : '' }}"><a href="{{ url('/') }}">
                                    Dashboard</a></li>
                            <li><a class="{{ Request::is('settings') ? 'active' : '' }}"
                                   href="{{ route('settings.settings') }}">Settings</a></li>
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-group"></i> <span> Customers</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('customers') ? 'active' : '' }}"
                                   href="{{ route('customers.index') }}">All Customers</a></li>

                            <li><a class="{{ Request::is('customers/create') ? 'active' : '' }}"
                                   href="{{ route('customers.create') }}">Create Customer</a></li>

                        </ul>
                    </li>


                    <li class="submenu">
                        <a href="#"><i class="la la-building"></i> <span> Company</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('companies') ? 'active' : '' }}"
                                   href="{{ route('companies.index') }}">All Companies</a></li>

                            <li><a class="{{ Request::is('companies/create') ? 'active' : '' }}"
                                   href="{{ route('companies.create') }}">Create Company</a></li>

                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-group"></i> <span> Employees</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('employees') ? 'active' : '' }}"
                                   href="{{ route('employees.index') }}">All Employees</a></li>

                            <li><a class="{{ Request::is('employees/create') ? 'active' : '' }}"
                                   href="{{ route('employees.create') }}">Create Employee</a></li>

                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-calculator"></i> <span> Departments</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('departments') ? 'active' : '' }}"
                                   href="{{ route('departments.index') }}">All Departments</a></li>

                            <li><a class="{{ Request::is('departments/create') ? 'active' : '' }}"
                                   href="{{ route('departments.create') }}">Create Department</a></li>

                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-user"></i> <span> Roles</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('roles') ? 'active' : '' }}" href="{{ route('roles.index') }}">All
                                    Roles</a></li>

                            <li><a class="{{ Request::is('roles/create') ? 'active' : '' }}"
                                   href="{{ route('roles.create') }}">Create Role</a></li>

                        </ul>
                    </li>

                    <li class="menu">
                        <a href="{{route('activities.index')}}"><i class="la la-file"></i> <span>Activities</span></a>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-group"></i> <span> Groups</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('groups') ? 'active' : '' }}"
                                   href="{{ route('groups.index') }}">All Groups</a></li>

                            @if(\Auth::guard('employee')->user()->role->name === 'Manager' ||  \Auth::guard('employee')->user()->role->name === 'CEO')
                                <li><a class="{{ Request::is('groups/create') ? 'active' : '' }}"
                                       href="{{ route('groups.create') }}">Create Groups</a></li>
                            @endif
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-calendar-check-o"></i> <span> Meeting</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('meetings') ? 'active' : '' }}"
                                   href="{{ route('meetings.index') }}">Meeting</a></li>
                            <li><a class="{{ Request::is('meetings.create') ? 'active' : '' }}"
                                   href="{{ route('meetings.create') }}">Meeting Create</a></li>

                        </ul>
                    </li>
                    <li class="menu">
                        <a href="{{route('assignments.index')}}"><i class="la la-tasks"></i> <span>Assignments</span></a>
                    </li>

                    <li class="menu">
                        <a class="{{ Request::is('projects') ? 'active' : '' }}"
                           href="{{ route('projects.index') }}"><i class="la la-cube"></i> <span>Projects</span></a>
                    </li>
<<<<<<< HEAD
                    <li class="menu-title">
                        <span>CRM</span>
                    </li>
                    <li class="submenu">
                                <a href="#"><i class="la la-ticket"></i> <span> Ticket</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">

                                    <li><a class="{{ Request::is('tickets') ? 'active' : '' }}" href="{{ route('tickets.index') }}">All Ticket</a></li>
                                    <li><a class="{{ Request::is('followed') ? 'active' : '' }}" href="{{ route('followed.tickets') }}">My Follow Ticket</a></li>
                                    <li><a class="{{ Request::is('cases.index') ? 'active' : '' }}" href="{{ route('cases.index') }}">All Cases</a></li>
                                    <li><a class="{{ Request::is('priorities') ? 'active' : '' }}" href="{{ route('priorities.index') }}">All Priority</a></li>
                                    <li><a class="{{ Request::is('piechart/report') ? 'active' : '' }}" href="{{ url('piechart/report') }}">Pie Chart Report</a></li>
                                    <li><a class="{{ Request::is('senders') ? 'active' : '' }}" href="{{route('senders.index')}}">Sender Information</a></li>

                                    {{--                            @if(\Auth::guard('employee')->user()->role->name === 'Manager' ||  \Auth::guard('employee')->user()->role->name === 'CEO')--}}
                                    {{--                                <li><a class="{{ Request::is('tickets/create') ? 'active' : '' }}" href="{{ route('tickets.create') }}">Create Ticket</a></li>--}}
                                    {{--                            @endif--}}
                                </ul>
                            </li>
                    <li class="submenu">
                                <a href="#"><i class="la la-cube"></i><span> Product</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">

                                    <li><a class="{{ Request::is('products') ? 'active' : '' }}" href="{{url('/products')}}">All Products</a></li>
                                    {{--                            <li><a class="{{ Request::is('cases') ? 'active' : '' }}" href="{{ route('cases.index') }}">All Cases</a></li>--}}
                                    {{--                            <li><a class="{{ Request::is('priority') ? 'active' : '' }}" href="{{ route('priorities.index') }}">All Priority</a></li>--}}

                                </ul>
                            </li>
                    <li class="submenu">
                                <a href="#"><i class="la la-question-circle"></i> <span> InQuery</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="{{ Request::is('inqueries.index') ? 'active' : '' }}" href="{{ route('inqueries.index') }}">All InQuery</a></li>
                                    <li><a class="{{ Request::is('inqueries.create') ? 'active' : '' }}" href="{{ route('inqueries.create') }}">InQuery Create</a></li>
                                </ul>
                            </li>
                    <li class="submenu">
                                <a href="#"><i class="la la-dollar"></i><span> Lead</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="{{ Request::is('leads') ? 'active' : '' }}" href="{{ route('leads.index') }}">All Leads</a></li>
                                    <li><a class="{{ Request::is('leads.myfollowed') ? 'active' : '' }}" href="{{ route('leads.myfollowed') }}">Followed Lead</a></li>
                                </ul>
                            </li>
                    <li class="submenu">
                                <a href="#"><i class="fa fa-handshake-o"></i><span> Deal</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="{{ Request::is('deals') ? 'active' : '' }}" href="{{ route('deals.index') }}">All Deals</a></li>
                                </ul>
                            </li>
                    <li class="submenu">
                                <a href="#"><i class="la la-file-text-o"></i><span> Quotation</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="{{ Request::is('quotations') ? 'active' : '' }}" href="{{ route('quotations.index') }}">All Quotation</a></li>
                                </ul>
                            </li>
                    <li class="submenu">
                                <a href="#"><i class="la la-file-text"></i><span> Invoice</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="{{ Request::is('invoices') ? 'active' : '' }}" href="{{ route('invoices.index') }}">All Invoice</a></li>
                                </ul>
                            </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-check-square-o"></i><span> Approval Request</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ Request::is('approvals') ? 'active' : '' }}" href="{{ route('approvals.index') }}">My Approval </a></li>
                            <li><a class="{{ Request::is('request.me') ? 'active' : '' }}" href="{{ route('request.me') }}">Requests Me </a></li>
                        </ul>
                    </li>
=======
>>>>>>> origin/develop
                </ul>
            </div>
        </div>
    </div>
</div>


