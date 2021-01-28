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
                        <a href="#"><i class="la la-cube"></i> <span> Customers</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('customers') ? 'active' : '' }}" href="{{ route('customers.index') }}">All Customers</a></li>

                            <li><a class="{{ Request::is('customers/create') ? 'active' : '' }}" href="{{ route('customers.create') }}">Create Customer</a></li>

                        </ul>
                    </li>



                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span> Company</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('companies') ? 'active' : '' }}" href="{{ route('companies.index') }}">All Companies</a></li>

                            <li><a class="{{ Request::is('companies/create') ? 'active' : '' }}" href="{{ route('companies.create') }}">Create Company</a></li>

                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span> Employees</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('employees') ? 'active' : '' }}" href="{{ route('employees.index') }}">All Employees</a></li>

                            <li><a class="{{ Request::is('employees/create') ? 'active' : '' }}" href="{{ route('employees.create') }}">Create Employee</a></li>

                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span> Departments</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('departments') ? 'active' : '' }}" href="{{ route('departments.index') }}">All Departments</a></li>

                            <li><a class="{{ Request::is('departments/create') ? 'active' : '' }}" href="{{ route('departments.create') }}">Create Department</a></li>

                        </ul>
                    </li>

                    <li class="menu">
                    <a href="{{route('activities.index')}}"><i class="la la-cube"></i> <span>Activities</span></a>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span> Groups</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li><a class="{{ Request::is('groups') ? 'active' : '' }}" href="{{ route('groups.index') }}">All Groups</a></li>

                            <li><a class="{{ Request::is('groups/create') ? 'active' : '' }}" href="{{ route('groups.create') }}">Create Groups</a></li>

                        </ul>
                    </li>


                </ul>
            </div>
        </div>
    </div>
</div>


