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
                            <li class="{{ Request::is('index') ? 'active' : '' }}"><a href="{{ url('index') }}">Admin
                                    Dashboard</a></li>
                            <li><a class="{{ Request::is('employee-dashboard') ? 'active' : '' }}"
                                   href="{{ url('employee-dashboard') }}">Employee Dashboard</a></li>
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span> Customers</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('customers') ? 'active' : '' }}"
                                   href="{{ route('customers.index') }}">All Customers</a></li>

                            <li><a class="{{ Request::is('customers/create') ? 'active' : '' }}"
                                   href="{{ route('customers.create') }}">Create Customer</a></li>

                        </ul>
                    </li>


                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span> Company</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('companies') ? 'active' : '' }}"
                                   href="{{ route('companies.index') }}">All Companies</a></li>

                            <li><a class="{{ Request::is('companies/create') ? 'active' : '' }}"
                                   href="{{ route('companies.create') }}">Create Company</a></li>

                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span> Employees</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('employees') ? 'active' : '' }}"
                                   href="{{ route('employees.index') }}">All Employees</a></li>

                            <li><a class="{{ Request::is('employees/create') ? 'active' : '' }}"
                                   href="{{ route('employees.create') }}">Create Employee</a></li>

                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span> Departments</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('departments') ? 'active' : '' }}"
                                   href="{{ route('departments.index') }}">All Departments</a></li>

                            <li><a class="{{ Request::is('departments/create') ? 'active' : '' }}"
                                   href="{{ route('departments.create') }}">Create Department</a></li>

                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span> Roles</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('roles') ? 'active' : '' }}" href="{{ route('roles.index') }}">All
                                    Roles</a></li>

                            <li><a class="{{ Request::is('roles/create') ? 'active' : '' }}"
                                   href="{{ route('roles.create') }}">Create Role</a></li>

                        </ul>
                    </li>

                    <li class="menu">
                        <a href="{{route('activities.index')}}"><i class="la la-cube"></i> <span>Activities</span></a>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span> Groups</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('groups') ? 'active' : '' }}"
                                   href="{{ route('groups.index') }}">All Groups</a></li>

                            @if(\Auth::guard('employee')->user()->role->name === 'Manager' ||  \Auth::guard('employee')->user()->role->name === 'CEO')
                                <li><a class="{{ Request::is('groups/create') ? 'active' : '' }}"
                                       href="{{ route('groups.create') }}">Create Groups</a></li>
                            @endif
                        </ul>
                    </li>

                    <li class="menu">
                        <a href="{{route('assignments.index')}}"><i class="la la-cube"></i> <span>Assignments</span></a>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span> Projects</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('projects') ? 'active' : '' }}"
                                   href="{{ route('projects.index') }}">All Projects</a></li>

                            <li><a class="{{ Request::is('project/create') ? 'active' : '' }}"
                                   href="{{ route('projects.create') }}">Create Project</a></li>
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span> CRM</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li class="submenu">
                                <a href="#"><i class="la la-ticket"></i> <span> Ticket</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">

                                    <li><a class="{{ Request::is('tickets') ? 'active' : '' }}" href="{{ route('tickets.index') }}">All Ticket</a></li>
                                    <li><a class="{{ Request::is('cases') ? 'active' : '' }}" href="{{ route('cases.index') }}">All Cases</a></li>
                                    <li><a class="{{ Request::is('priority') ? 'active' : '' }}" href="{{ route('priorities.index') }}">All Priority</a></li>
                                    <li><a class="{{ Request::is('piechart/report') ? 'active' : '' }}" href="{{ url('piechart/report') }}">Pie Chart Report</a></li>
                                    <li><a class="{{ Request::is('ticket/senders') ? 'active' : '' }}" href="{{ url('ticket/senders') }}">Sender Information</a></li>

                                    {{--                            @if(\Auth::guard('employee')->user()->role->name === 'Manager' ||  \Auth::guard('employee')->user()->role->name === 'CEO')--}}
                                    {{--                                <li><a class="{{ Request::is('tickets/create') ? 'active' : '' }}" href="{{ route('tickets.create') }}">Create Ticket</a></li>--}}
                                    {{--                            @endif--}}
                                </ul>
                            </li>

                            <li class="submenu">
                                <a href="#"><i class="la la-cube"></i> <span> Product</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">

                                    <li><a class="{{ Request::is('products') ? 'active' : '' }}" href="{{url('/products')}}">All Products</a></li>
                                    {{--                            <li><a class="{{ Request::is('cases') ? 'active' : '' }}" href="{{ route('cases.index') }}">All Cases</a></li>--}}
                                    {{--                            <li><a class="{{ Request::is('priority') ? 'active' : '' }}" href="{{ route('priorities.index') }}">All Priority</a></li>--}}

                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><i class="la la-cube"></i> <span> InQuery</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="{{ Request::is('inqueries.index') ? 'active' : '' }}" href="{{ route('inqueries.index') }}">All InQuery</a></li>
                                    <li><a class="{{ Request::is('inqueries.create') ? 'active' : '' }}" href="{{ route('inqueries.create') }}">InQuery Create</a></li>
                                </ul>
                            </li>

                            <li class="submenu">
                                <a href="#"><i class="la la-cube"></i> <span> Lead</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="{{ Request::is('leads') ? 'active' : '' }}" href="{{ route('leads.index') }}">All Leads</a></li>
                                    <li><a class="{{ Request::is('leads.myfollowed') ? 'active' : '' }}" href="{{ route('leads.myfollowed') }}">Followed Lead</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><i class="la la-cube"></i> <span> Deal</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="{{ Request::is('deals') ? 'active' : '' }}" href="{{ route('deals.index') }}">All Deals</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><i class="la la-cube"></i> <span> Quotation</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="{{ Request::is('quotations') ? 'active' : '' }}" href="{{ route('quotations.index') }}">All Quotation</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


