<ul>
    <li class="menu-title">
        <span>Main</span>
    </li>
    <li class="submenu"><a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li ><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}" style="text-decoration: none">
                    Dashboard</a></li>
        </ul>
    </li>
    <li class="submenu">
        <a href="#"><i class="la la-th-list" style="font-size: 18px;"></i><span> Contact</span> <span class="menu-arrow"></span></a>
        <ul style="display: none;">

            <li><a class="{{ Request::is('customers') ? 'active' : '' }}"
                   href="{{ route('customers.index') }}" style="text-decoration: none;">Contacts</a></li>

            <li><a class="{{ Request::is('customers/create') ? 'active' : '' }}"
                   href="{{ route('customers.create') }}" style="text-decoration: none">Create Contact</a></li>
        </ul>
    </li>
    <li class="submenu">
        <a href="#"><i class="la la-building" style="font-size: 18px;"></i><span> Company</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">

            <li><a class="{{ Request::is('companies') ? 'active' : '' }}"
                   href="{{ route('companies.index') }}" style="text-decoration: none">All Companies</a></li>

            <li><a class="{{ Request::is('companies/create') ? 'active' : '' }}"
                   href="{{ route('companies.create') }}" style="text-decoration: none">Create Company</a></li>

        </ul>
    </li>
    {{--<li class="submenu">--}}
        {{--<a href="#"><i class="la la-group"></i> <span>Operation</span> <span--}}
                    {{--class="menu-arrow"></span></a>--}}
        {{--<ul style="display: none;">--}}
            {{--<li><a class="{{ Request::is('expense_record') ? 'active' : '' }}"--}}
                   {{--href="{{ route('expense_record.index') }}" style="text-decoration: none">My Expense</a></li>--}}
            {{--<li>--}}
            {{--<li class="submenu">--}}
                {{--<a href="#"><span>Advance Cash</span>--}}
                    {{--<span--}}
                            {{--class="menu-arrow"></span></a>--}}
                {{--<ul style="display: none;">--}}

                    {{--<li><a class="{{ Request::is('petty_cash') ? 'active' : '' }}"--}}
                           {{--href="{{ route('petty_cash.index') }}" style="text-decoration: none">All Petty Cash</a>--}}
                    {{--</li>--}}
                    {{--<li><a class="{{ Request::is('petty_cash/create') ? 'active' : '' }}"--}}
                           {{--href="{{ route('petty_cash.create') }}" style="text-decoration: none">Create</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="submenu">--}}
                {{--<a href="#"><span> Expense Claim</span>--}}
                    {{--<span--}}
                            {{--class="menu-arrow"></span></a>--}}
                {{--<ul style="display: none;">--}}

                    {{--<li><a class="{{ Request::is('expenseclaims') ? 'active' : '' }}"--}}
                           {{--href="{{ route('expenseclaims.index') }}" style="text-decoration: none">All Expense Claim</a>--}}
                    {{--</li>--}}

                    {{--<li><a class="{{ Request::is('expenseclaims/create') ? 'active' : '' }}"--}}
                           {{--href="{{ route('expenseclaims.create') }}" style="text-decoration: none">Submit Expense--}}
                            {{--Claim</a></li>--}}

                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="submenu">--}}
                {{--<a href="#"><span>Requestation</span> <span--}}
                            {{--class="menu-arrow"></span></a>--}}
                {{--<ul style="display: none;">--}}
                    {{--<li><a class="{{ Request::is('approvals') ? 'active' : '' }}"--}}
                           {{--href="{{ route('approvals.index') }}" style="text-decoration: none">Requestation </a></li>--}}
                    {{--<li><a class="{{ Request::is('requestation/cc') ? 'active' : '' }}"--}}
                           {{--href="{{ route('requestation.cc') }}" style="text-decoration: none">Requestation Cc</a></li>--}}
                    {{--<li><a class="{{ Request::is('approvals/request/me') ? 'active' : '' }}"--}}
                           {{--href="{{ route('request.me') }}" style="text-decoration: none">Approval</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="submenu">--}}
                {{--<a href="#"><span> Room</span> <span--}}
                            {{--class="menu-arrow"></span></a>--}}
                {{--<ul style="display: none;">--}}

                    {{--<li><a class="{{ Request::is('rooms') ? 'active' : '' }}" href="{{route('rooms.index')}}"--}}
                           {{--style="text-decoration: none">Rooms</a></li>--}}
                    {{--<li><a class="{{ Request::is('booking') ? 'active' : '' }}" href="{{route('booking')}}"--}}
                           {{--style="text-decoration: none">Room Booking</a></li>--}}
                    {{--                            <li><a class="{{ Request::is('cases') ? 'active' : '' }}" href="{{ route('cases.index') }}">All Cases</a></li>--}}
                    {{--                            <li><a class="{{ Request::is('priority') ? 'active' : '' }}" href="{{ route('priorities.index') }}">All Priority</a></li>--}}

                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="submenu">--}}
                {{--<a href="#"><span> Meeting</span> <span--}}
                            {{--class="menu-arrow"></span></a>--}}
                {{--<ul style="display: none;">--}}

                    {{--<li><a class="{{ Request::is('meetings') ? 'active' : '' }}"--}}
                           {{--href="{{ route('meetings.index') }}" style="text-decoration: none">Meeting</a></li>--}}
                    {{--<li><a class="{{ Request::is('meetings/create') ? 'active' : '' }}"--}}
                           {{--href="{{ route('meetings.create') }}" style="text-decoration: none">Meeting Create</a></li>--}}

                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="submenu">--}}
                {{--<a href="#"><span> Assignment</span>--}}
                    {{--<span--}}
                            {{--class="menu-arrow"></span></a>--}}
                {{--<ul style="display: none;">--}}

                    {{--<li><a class="{{ Request::is('assignments') ? 'active' : '' }}"--}}
                           {{--href="{{ route('assignments.index') }}" style="text-decoration: none">Task</a>--}}
                    {{--</li>--}}

                    {{--<li><a class="{{ Request::is('schedule') ? 'active' : '' }}"--}}
                           {{--href="{{ route('schedule.index') }}" style="text-decoration: none">Schedules--}}
                        {{--</a></li>--}}

                {{--</ul>--}}
            {{--</li>--}}
        {{--</ul>--}}


    {{--</li><!-- Operation -->--}}
    <li class="submenu">
        <a href="#"><i class="la la-group"></i> <span>People</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li class="submenu">
                <a href="#"><i class="la la-th-list" style="font-size: 18px;"></i><span> Office Branch</span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">

                    <li><a class="{{ Request::is('officebranch') ? 'active' : '' }}"
                           href="{{ route('officebranch.index') }}" style="text-decoration: none;">Branch</a></li>

                    <li><a class="{{ Request::is('officebranch/create') ? 'active' : '' }}"
                           href="{{ route('officebranch.create') }}" style="text-decoration: none">Create Branch</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#" ><i class="la la-users mr-2" style="font-size: 18px;"></i><span> Employees</span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">

                    <li><a class="{{ Request::is('employees') ? 'active' : '' }}"
                           href="{{ route('employees.index') }}" style="text-decoration: none">All Employees</a></li>

                    <li><a class="{{ Request::is('employees/create') ? 'active' : '' }}"
                           href="{{ route('employees.create') }}" style="text-decoration: none">Create Employee</a></li>

                </ul>
            </li>

            <li class="submenu">
                <a href="#"><i class="la la-building mr-2" style="font-size: 18px;"></i> <span> Departments</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">

                    <li><a class="{{ Request::is('departments') ? 'active' : '' }}"
                           href="{{ route('departments.index') }}" style="text-decoration: none">All Departments</a></li>

                    <li><a class="{{ Request::is('departments/create') ? 'active' : '' }}"
                           href="{{ route('departments.create') }}" style="text-decoration: none">Create Department</a></li>

                </ul>
            </li>



            <li class="submenu">
                <a href="#"><i class="la la-users mr-2"></i><span> Groups</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">

                    <li><a class="{{ Request::is('groups') ? 'active' : '' }}"
                           href="{{ route('groups.index') }}" style="text-decoration: none">All Groups</a></li>

                    @if(\Auth::guard('employee')->user()->role->name === 'Manager' ||  \Auth::guard('employee')->user()->role->name === 'CEO')
                        <li><a class="{{ Request::is('groups/create') ? 'active' : '' }}"
                               href="{{ route('groups.create') }}" style="text-decoration: none">Create Groups</a></li>
                    @endif
                </ul>
            </li>
        </ul>

    </li>
    {{--<li class="submenu">--}}
        {{--<a href="#"><i class="la la-ticket"></i> <span>Complain System</span> <span--}}
                    {{--class="menu-arrow"></span></a>--}}
        {{--<ul style="display: none;">--}}
            {{--<li><a class="{{ Request::is('tickets') ? 'active' : '' }}"--}}
                   {{--href="{{ route('tickets.index') }}" style="text-decoration: none">Tickets</a></li>--}}
            {{--<li><a class="{{ Request::is('request_tickets') ? 'active' : '' }}"--}}
                   {{--href="{{ route('request_tickets.index') }}" style="text-decoration: none">Complaints</a></li>--}}
            {{--<li><a class="{{ Request::is('followed/ticket') ? 'active' : '' }}"--}}
                   {{--href="{{ route('followed.tickets') }}" style="text-decoration: none">My Follow Ticket</a></li>--}}
            {{--<li><a class="{{ Request::is('cases') ? 'active' : '' }}"--}}
                   {{--href="{{ route('cases.index') }}" style="text-decoration: none">All Cases</a></li>--}}
            {{--<li><a class="{{ Request::is('priorities') ? 'active' : '' }}"--}}
                   {{--href="{{ route('priorities.index') }}" style="text-decoration: none">All Priority</a></li>--}}
            {{--<li><a class="{{ Request::is('piechart/report') ? 'active' : '' }}"--}}
                   {{--href="{{ url('piechart/report') }}" style="text-decoration: none">Pie Chart Report</a></li>--}}
            {{--<li><a class="{{ Request::is('senders') ? 'active' : '' }}"--}}
                   {{--href="{{route('senders.index')}}" style="text-decoration: none">Sender Information</a></li>--}}
        {{--</ul>--}}
    {{--</li>--}}
</ul>