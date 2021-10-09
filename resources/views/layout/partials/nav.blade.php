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
                            <li class="{{ Request::is('index') ? 'active' : '' }}"><a href="{{ url('/') }}">
                                    Sale Dashboard</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-cogs"></i> <span> Settings</span> <span
                                    class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ Request::is('companysettings') ? 'active' : '' }}"
                                   href="{{ route('companysettings.create') }}">Company Settings</a></li>
                            <li><a class="{{ Request::is('companysettings') ? 'active' : '' }}"
                                   href="{{ route('companysettings.prefix') }}">Prefix Settings</a></li>
                            <li><a class="{{ Request::is('emailsetting') ? 'active' : '' }}"
                                   href="{{ route('emailsetting') }}">Email Settings</a></li>
                            <li class="submenu">
                                <a href="#"> <span> Roles</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">

                                    <li><a class="{{ Request::is('roles') ? 'active' : '' }}" href="{{ route('roles.index') }}">All
                                            Roles</a></li>

                                    <li><a class="{{ Request::is('roles/create') ? 'active' : '' }}"
                                           href="{{ route('roles.create') }}">Create Role</a></li>

                                </ul>
                            </li>
                            <li><a class="{{ Request::is('taxes') ? 'active' : '' }}"
                                   href="{{ route('taxes') }}">Tax Setting</a></li>
                        </ul>
                    </li>


                    <li class="submenu">

                    <li class="submenu">
                        <a href="#"><i class="la la-group"></i> <span>Client</span> <span
                                    class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li>
                                <a href="#"><span> Contact</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">

                                    <li><a class="{{ Request::is('customers') ? 'active' : '' }}"
                                           href="{{ route('customers.index') }}">Contacts</a></li>

                                    <li><a class="{{ Request::is('customers/create') ? 'active' : '' }}"
                                           href="{{ route('customers.create') }}">Create Contact</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><span> Company</span> <span
                                            class="menu-arrow"></span></a>
                                <ul style="display: none;">

                                    <li><a class="{{ Request::is('companies') ? 'active' : '' }}"
                                           href="{{ route('companies.index') }}">All Companies</a></li>

                                    <li><a class="{{ Request::is('companies/create') ? 'active' : '' }}"
                                           href="{{ route('companies.create') }}">Create Company</a></li>

                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-group"></i> <span> HRM</span> <span
                                    class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li class="submenu">
                                <a href="#"><i class="la la-users mr-2" style="font-size: 18px;"></i><span> Employees</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">

                                    <li><a class="{{ Request::is('employees') ? 'active' : '' }}"
                                           href="{{ route('employees.index') }}">All Employees</a></li>

                                    <li><a class="{{ Request::is('employees/create') ? 'active' : '' }}"
                                           href="{{ route('employees.create') }}">Create Employee</a></li>

                                </ul>
                            </li>

                            <li class="submenu">
                                <a href="#"><i class="la la-building mr-2" style="font-size: 18px;"></i> <span> Departments</span> <span
                                            class="menu-arrow"></span></a>
                                <ul style="display: none;">

                                    <li><a class="{{ Request::is('departments') ? 'active' : '' }}"
                                           href="{{ route('departments.index') }}">All Departments</a></li>

                                    <li><a class="{{ Request::is('departments/create') ? 'active' : '' }}"
                                           href="{{ route('departments.create') }}">Create Department</a></li>

                                </ul>
                            </li>

                            {{--<li class="menu">--}}
                                {{--<a href="{{route('activities.index')}}"><i class="la la-list-alt mr-2" style="font-size: 18px"></i><span>Activities</span></a>--}}
                            {{--</li>--}}
                            <li class="submenu">
                                <a href="#"><i class="la la-check-square-o mr-2"></i><span> Approval Request</span> <span
                                            class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="{{ Request::is('approvals') ? 'active' : '' }}"
                                           href="{{ route('approvals.index') }}">My Approval </a></li>
                                    <li><a class="{{ Request::is('request.me') ? 'active' : '' }}"
                                           href="{{ route('request.me') }}">Requests Me </a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><i class="la la-users mr-2"></i><span> Groups</span> <span
                                            class="menu-arrow"></span></a>
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
                                <a href="#"><i class="la la-th mr-2" style="font-size: 18px"></i><span> Room</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">

                                    <li><a class="{{ Request::is('rooms') ? 'active' : '' }}" href="{{route('rooms.index')}}">Rooms</a></li>
                                    <li><a class="{{ Request::is('booking') ? 'active' : '' }}" href="{{route('booking')}}">Room Booking</a></li>
                                    {{--                            <li><a class="{{ Request::is('cases') ? 'active' : '' }}" href="{{ route('cases.index') }}">All Cases</a></li>--}}
                                    {{--                            <li><a class="{{ Request::is('priority') ? 'active' : '' }}" href="{{ route('priorities.index') }}">All Priority</a></li>--}}

                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><i class="la la-calendar mr-2" style="font-size: 18px"></i> <span> Meeting</span> <span
                                            class="menu-arrow"></span></a>
                                <ul style="display: none;">

                                    <li><a class="{{ Request::is('meetings') ? 'active' : '' }}"
                                           href="{{ route('meetings.index') }}">Meeting</a></li>
                                    <li><a class="{{ Request::is('meetings.create') ? 'active' : '' }}"
                                           href="{{ route('meetings.create') }}">Meeting Create</a></li>

                                </ul>
                            </li>
                                                    </ul>

                    </li>


                    <li class="submenu">
                        <a href="#"><i class="la la-ticket"></i> <span>Complain System</span> <span
                                    class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            @if(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Employee')
                                <li><a class="{{ Request::is('tickets') ? 'active' : '' }}"
                                       href="{{ route('tickets.index') }}">My Created Ticket</a></li>
                                <li><a class="{{ Request::is('followed') ? 'active' : '' }}"
                                       href="{{ route('followed.tickets') }}">My Follow Ticket</a></li>
                            @else
                                <li><a class="{{ Request::is('tickets') ? 'active' : '' }}"
                                       href="{{ route('tickets.index') }}">Tickets</a></li>
                                <li><a class="{{ Request::is('followed') ? 'active' : '' }}"
                                       href="{{ route('request_tickets.index') }}">Complaints</a></li>
                                <li><a class="{{ Request::is('followed') ? 'active' : '' }}"
                                       href="{{ route('followed.tickets') }}">My Follow Ticket</a></li>
                                <li><a class="{{ Request::is('cases.index') ? 'active' : '' }}"
                                       href="{{ route('cases.index') }}">All Cases</a></li>
                                <li><a class="{{ Request::is('priorities') ? 'active' : '' }}"
                                       href="{{ route('priorities.index') }}">All Priority</a></li>
                                <li><a class="{{ Request::is('piechart/report') ? 'active' : '' }}"
                                       href="{{ url('piechart/report') }}">Pie Chart Report</a></li>
                                <li><a class="{{ Request::is('senders') ? 'active' : '' }}"
                                       href="{{route('senders.index')}}">Sender Information</a></li>
                            @endif

                            {{--                            @if(\Auth::guard('employee')->user()->role->name === 'Manager' ||  \Auth::guard('employee')->user()->role->name === 'CEO')--}}
                            {{--                                <li><a class="{{ Request::is('tickets/create') ? 'active' : '' }}" href="{{ route('tickets.create') }}">Create Ticket</a></li>--}}
                            {{--                            @endif--}}
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span>Banking</span> <span
                                    class="menu-arrow"></span></a>
                        <ul style="display: none;">

                            <li >
                                <a href="{{route('transaction.category')}}"><i class="la la-cube mr-2" style="font-size: 18px"></i><span> Category</span> </a>
                                <a href="{{route('accounts.index')}}"><i class="la la-bank mr-2" style="font-size: 18px"></i><span> Account</span> </a>
                                <a href="{{route('transactions.index')}}"><i class="la la-cube mr-2" style="font-size: 18px"></i><span> Transaction</span> </a>
                                <a href="{{route('revenue')}}"><i class="la la-cube mr-2" style="font-size: 18px"></i><span> Revenue</span> </a>
                                <a href="{{route('expense')}}"><i class="la la-cube mr-2" style="font-size: 18px"></i><span> Expense</span> </a>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span>Sale</span> <span
                                    class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li class="submenu">
                                <a href="#"><i class="la la-cube mr-2" style="font-size: 18px"></i><span> Product</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="{{ Request::is('category') ? 'active' : '' }}" href="{{route('category')}}">Products Category</a></li>
                                    <li><a class="{{ Request::is('products') ? 'active' : '' }}" href="{{url('/products')}}">All
                                            Products</a></li>
                                    <li><a class="{{ Request::is('products') ? 'active' : '' }}" href="{{url('/products/create')}}">
                                            Product Create</a></li>

                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><img src="{{url(asset('img/icon_image/invoice.png'))}}"  alt="" width="18px" height="18px" class="mr-1" ><span> Invoice</span> <span
                                            class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="{{ Request::is('invoices') ? 'active' : '' }}"
                                           href="{{ route('invoices.index') }}">All Invoice</a></li>
                                    <li><a class="{{ Request::is('invoices') ? 'active' : '' }}"
                                           href="{{ route('invoices.create') }}">Invoice Create</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><img src="{{url(asset('img/icon_image/order24.png'))}}"  alt="" class="mr-1" width="18px" height="18px;"><span> Order</span> <span
                                            class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a class="{{ Request::is('invoices') ? 'active' : '' }}"
                                           href="{{ route('saleorders.index') }}">All Orders</a></li>
                                    <li><a class="{{ Request::is('invoices') ? 'active' : '' }}"
                                           href="{{ route('saleorders.create') }}">Orders Create</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span>CRM</span> <span
                                    class="menu-arrow"></span></a>
                        <ul style="display: none;">
                        <a href="{{route('leads.index')}}"><i class="la la-question-circle mr-2"></i> <span>All Leads</span></a>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-handshake-o mr-2" style="font-size: 18px"></i><span> Deal</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ Request::is('deals') ? 'active' : '' }}" href="{{ route('deals.index') }}">All
                                    Deals</a></li>
                            <li><a class="{{ Request::is('deals') ? 'active' : '' }}" href="{{ route('deals.create') }}">
                                    Deal Create</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><img src="{{url(asset('img/icon_image/quotation.png'))}}"  alt="" class="mr-1" width="18px" height="18px"><span> Quotation</span> <span
                                    class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ Request::is('quotations') ? 'active' : '' }}"
                                   href="{{ route('quotations.index') }}">All Quotations</a></li>
                            <li><a class="{{ Request::is('quotations') ? 'active' : '' }}"
                                   href="{{ route('quotations.create') }}">Quotation Create</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>


