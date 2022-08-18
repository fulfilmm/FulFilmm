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
        <a href="#"><i class="la la-group"></i> <span>Operation</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li><a class="{{ Request::is('expense_record') ? 'active' : '' }}"
                   href="{{ route('expense_record.index') }}" style="text-decoration: none">My Expense</a></li>
            <li>
            <li class="submenu">
                <a href="#"><span> Expense Claim</span>
                    <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">

                    <li><a class="{{ Request::is('expenseclaims') ? 'active' : '' }}"
                           href="{{ route('expenseclaims.index') }}" style="text-decoration: none">All Expense Claim</a>
                    </li>

                    <li><a class="{{ Request::is('expenseclaims/create') ? 'active' : '' }}"
                           href="{{ route('expenseclaims.create') }}" style="text-decoration: none">Submit Expense
                            Claim</a></li>

                </ul>
            </li>
            <li class="submenu">
                <a href="#"><span>Requestation</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a class="{{ Request::is('approvals') ? 'active' : '' }}"
                           href="{{ route('approvals.index') }}" style="text-decoration: none">Requestation </a></li>
                    <li><a class="{{ Request::is('requestation/cc') ? 'active' : '' }}"
                           href="{{ route('requestation.cc') }}" style="text-decoration: none">Requestation Cc</a></li>
                    <li><a class="{{ Request::is('approvals/request/me') ? 'active' : '' }}"
                           href="{{ route('request.me') }}" style="text-decoration: none">Approval</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><span> Room</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">

                    <li><a class="{{ Request::is('rooms') ? 'active' : '' }}" href="{{route('rooms.index')}}"
                           style="text-decoration: none">Rooms</a></li>
                    <li><a class="{{ Request::is('booking') ? 'active' : '' }}" href="{{route('booking')}}"
                           style="text-decoration: none">Room Booking</a></li>
                    {{--                            <li><a class="{{ Request::is('cases') ? 'active' : '' }}" href="{{ route('cases.index') }}">All Cases</a></li>--}}
                    {{--                            <li><a class="{{ Request::is('priority') ? 'active' : '' }}" href="{{ route('priorities.index') }}">All Priority</a></li>--}}

                </ul>
            </li>
            <li class="submenu">
                <a href="#"><span> Meeting</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">

                    <li><a class="{{ Request::is('meetings') ? 'active' : '' }}"
                           href="{{ route('meetings.index') }}" style="text-decoration: none">Meeting</a></li>
                    <li><a class="{{ Request::is('meetings/create') ? 'active' : '' }}"
                           href="{{ route('meetings.create') }}" style="text-decoration: none">Meeting Create</a></li>

                </ul>
            </li>
            <li class="submenu">
                <a href="#"><span> Assignment</span>
                    <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">

                    <li><a class="{{ Request::is('assignments') ? 'active' : '' }}"
                           href="{{ route('assignments.index') }}" style="text-decoration: none">Task</a>
                    </li>

                    <li><a class="{{ Request::is('schedule') ? 'active' : '' }}"
                           href="{{ route('schedule.index') }}" style="text-decoration: none">Schedules
                        </a></li>

                </ul>
            </li>
        </ul>


    </li><!-- Operation -->

    <!------------------------------------- car booking module   --------------------------------------->

    <li class="submenu">
        <a href="#"><i class="la la-automobile" style="font-size: 18px;"></i> <span> Cars</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">

            <li>
                <a class="{{ Request::is('/car-list') ? 'active' : '' }}"
                   href="{{ route('carList') }}" style="text-decoration: none">
                    Cars List
                </a>
            </li>

            <li>
                <a class="{{ Request::is('/maintainance') ? 'active' : '' }}"
                   href="{{ route('maintain') }}" style="text-decoration: none">
                    Maintainance
                </a>
            </li>

        </ul>
    </li>
    <li class="submenu">
        <a href="#"><i class="la la-ticket"></i> <span>Complain System</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">

                <li><a class="{{ Request::is('tickets') ? 'active' : '' }}"
                       href="{{ route('tickets.index') }}"> style="text-decoration: none" My Created Ticket</a></li>
                <li><a class="{{ Request::is('followed') ? 'active' : '' }}"
                       href="{{ route('followed.tickets') }}" style="text-decoration: none">My Follow Ticket</a></li>
        </ul>
    </li>

    <!------------------------------------------------  end  ------------------------------------------------------>
</ul>