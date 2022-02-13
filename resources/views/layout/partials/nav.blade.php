
<div class="main-wrapper">
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                    <ul>
                        <li class="menu-title">
                            <span>Main</span>
                        </li>
                        <li class="submenu"><a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span
                                        class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li ><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}" style="text-decoration: none">
                                        Dashboard</a></li>
                                <li ><a class="{{ Request::is('sale/dashboard') ? 'active' : '' }}" href="{{ route('sale.dashboard') }}" style="text-decoration: none">
                                        Sale Dashboard</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="la la-cogs"></i> <span> Settings</span> <span
                                        class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a class="{{ Request::is('theme/color') ? 'active' : '' }}"
                                       href="{{ route('theme.setting') }}" style="text-decoration: none">Theme Color</a></li>
                                <li><a class="{{ Request::is('companysettings/create') ? 'active' : '' }}"
                                       href="{{ route('companysettings.create') }}" style="text-decoration: none">Company Settings</a></li>
                                <li><a class="{{ Request::is('setting/prefix') ? 'active' : '' }}"
                                       href="{{ route('companysettings.prefix') }}" style="text-decoration: none">Prefix Settings</a></li>
                                <li><a class="{{ Request::is('setting/email') ? 'active' : '' }}"
                                       href="{{ route('emailsetting') }}" style="text-decoration: none">Email Settings</a></li>
                                <li><a class="{{ Request::is('add/permission') ? 'active' : '' }}"
                                       href="{{ route('permission.create') }}" style="text-decoration: none">Add Permission</a></li>
                                <li class="submenu">
                                    <a href="#"> <span> Roles</span> <span class="menu-arrow"></span></a>
                                    <ul style="display: none;">

                                        <li><a class="{{ Request::is('roles') ? 'active' : '' }}" href="{{ route('roles.index') }}" style="text-decoration: none">All
                                                Roles</a></li>

                                        <li><a class="{{ Request::is('roles/create') ? 'active' : '' }}"
                                               href="{{ route('roles.create') }}" style="text-decoration: none">Create Role</a></li>

                                    </ul>
                                </li>
                                <li><a class="{{ Request::is('product/tax') ? 'active' : '' }}"
                                       href="{{ route('taxes') }}" style="text-decoration: none">Tax Setting</a></li>
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
                        <li class="submenu">
                            <a href="#"><i class="la la-calendar" style="font-size: 18px;"></i><span> Activity</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">



                            </ul>
                        </li>

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
                                    <a href="#"><i class="la la-check-square-o mr-2"></i><span>Requestation</span> <span
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
                                <li class="submenu">
                                    <a href="#"><i class="la la-th mr-2" style="font-size: 18px"></i><span> Room</span> <span class="menu-arrow"></span></a>
                                    <ul style="display: none;">

                                        <li><a class="{{ Request::is('rooms') ? 'active' : '' }}" href="{{route('rooms.index')}}" style="text-decoration: none">Rooms</a></li>
                                        <li><a class="{{ Request::is('booking') ? 'active' : '' }}" href="{{route('booking')}}" style="text-decoration: none">Room Booking</a></li>
                                        {{--                            <li><a class="{{ Request::is('cases') ? 'active' : '' }}" href="{{ route('cases.index') }}">All Cases</a></li>--}}
                                        {{--                            <li><a class="{{ Request::is('priority') ? 'active' : '' }}" href="{{ route('priorities.index') }}">All Priority</a></li>--}}

                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="#"><i class="la la-calendar mr-2" style="font-size: 18px"></i> <span> Meeting</span> <span
                                                class="menu-arrow"></span></a>
                                    <ul style="display: none;">

                                        <li><a class="{{ Request::is('meetings') ? 'active' : '' }}"
                                               href="{{ route('meetings.index') }}" style="text-decoration: none">Meeting</a></li>
                                        <li><a class="{{ Request::is('meetings/create') ? 'active' : '' }}"
                                               href="{{ route('meetings.create') }}" style="text-decoration: none">Meeting Create</a></li>

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
                                           href="{{ route('tickets.index') }}"> style="text-decoration: none" My Created Ticket</a></li>
                                    <li><a class="{{ Request::is('followed') ? 'active' : '' }}"
                                           href="{{ route('followed.tickets') }}" style="text-decoration: none">My Follow Ticket</a></li>
                                @else
                                    <li><a class="{{ Request::is('tickets') ? 'active' : '' }}"
                                           href="{{ route('tickets.index') }}" style="text-decoration: none">Tickets</a></li>
                                    <li><a class="{{ Request::is('request_tickets') ? 'active' : '' }}"
                                           href="{{ route('request_tickets.index') }}" style="text-decoration: none">Complaints</a></li>
                                    <li><a class="{{ Request::is('followed/ticket') ? 'active' : '' }}"
                                           href="{{ route('followed.tickets') }}" style="text-decoration: none">My Follow Ticket</a></li>
                                    <li><a class="{{ Request::is('cases') ? 'active' : '' }}"
                                           href="{{ route('cases.index') }}" style="text-decoration: none">All Cases</a></li>
                                    <li><a class="{{ Request::is('priorities') ? 'active' : '' }}"
                                           href="{{ route('priorities.index') }}" style="text-decoration: none">All Priority</a></li>
                                    <li><a class="{{ Request::is('piechart/report') ? 'active' : '' }}"
                                           href="{{ url('piechart/report') }}" style="text-decoration: none">Pie Chart Report</a></li>
                                    <li><a class="{{ Request::is('senders') ? 'active' : '' }}"
                                           href="{{route('senders.index')}}" style="text-decoration: none">Sender Information</a></li>
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
                                <li class="submenu">
                                    <a href="#"><i class="la la-building mr-2" style="font-size: 18px;"></i> <span> Expense Claim</span> <span
                                                class="menu-arrow"></span></a>
                                    <ul style="display: none;">

                                        <li><a class="{{ Request::is('expenseclaims') ? 'active' : '' }}"
                                               href="{{ route('expenseclaims.index') }}" style="text-decoration: none">All Expense Claim</a></li>

                                        <li><a class="{{ Request::is('expenseclaims/create') ? 'active' : '' }}"
                                               href="{{ route('expenseclaims.create') }}" style="text-decoration: none">Submit Expense Claim</a></li>

                                    </ul>
                                </li>
                                <li><a class="{{ Request::is('advancepayments') ? 'active' : '' }}"
                                       href="{{ route('advancepayments.index') }}" style="text-decoration: none"><i class="la la-money mr-2" style="font-size: 18px"></i>Advance Payment</a></li>
                                <li >
                                    <a class="{{ Request::is('transaction/category') ? 'active' : '' }}" href="{{route('transaction.category')}}" style="text-decoration: none"><i class="la la-cube mr-2" style="font-size: 18px"></i><span> Category</span> </a>
                                    <a class="{{ Request::is('accounts') ? 'active' : '' }}" href="{{route('accounts.index')}}" style="text-decoration: none"><i class="la la-bank mr-2" style="font-size: 18px"></i><span> Account</span> </a>
                                    <a class="{{ Request::is('transactions') ? 'active' : '' }}" href="{{route('transactions.index')}}" style="text-decoration: none"><i class="la la-cube mr-2" style="font-size: 18px"></i><span> Transaction</span> </a>
                                    <a class="{{ Request::is('revenue') ? 'active' : '' }}" href="{{route('revenue')}}" style="text-decoration: none"><i class="la la-cube mr-2" style="font-size: 18px"></i><span> Revenue</span> </a>
                                    <a class="{{ Request::is('expense') ? 'active' : '' }}" href="{{route('expense')}}" style="text-decoration: none"><i class="la la-cube mr-2" style="font-size: 18px"></i><span> Expense</span> </a>
                                </li>
                            </ul>

                        </li>
                        <li class="submenu">
                            <a href="#"><i class="la la-puzzle-piece"></i> <span> Stock Managements</span> <span
                                        class="menu-arrow"></span></a>

                            <ul style="display: none;">

                                <li><a class="{{ Request::is('inventory') ? 'active' : '' }}"
                                       href="{{ route('inventory.index') }}" style="text-decoration: none"><i class="la la-bar-chart mr-2" style="font-size: 18px"></i>Inventory</a></li>
                                <li><a class="{{ Request::is('warehouses') ? 'active' : '' }}"
                                       href="{{ route('warehouses.index') }}" style="text-decoration: none"><i class="la la-building mr-2" style="font-size: 18px"></i>Warehouse</a></li>
                                <li class="submenu">
                                    <a href="#"><i class="la la-cube mr-2" style="font-size: 18px"></i><span> Product</span> <span class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a class="{{ Request::is('product/category') ? 'active' : '' }}" href="{{route('category')}}" style="text-decoration: none">Products Category</a></li>
                                        <li><a class="{{ Request::is('product_brand') ? 'active' : '' }}" href="{{url('product_brand')}}" style="text-decoration: none">
                                                Product Brand</a></li>
                                        <li><a class="{{ Request::is('products') ? 'active' : '' }}" href="{{url('/products')}}" style="text-decoration: none">All
                                                Products</a></li>
                                        <li><a class="{{ Request::is('products/create') ? 'active' : '' }}" href="{{url('/products/create')}}" style="text-decoration: none">
                                                Product Create</a></li>
                                        <li><a class="{{ Request::is('product/variant/create') ? 'active' : '' }}" href="{{route('create.variant')}}" style="text-decoration: none">
                                                Product Variant Add</a></li>
                                        <li><a class="{{ Request::is('foc/index') ? 'active' : '' }}" href="{{route('foc.index')}}" style="text-decoration: none">
                                               FOC Product</a></li>
                                    </ul>
                                </li>

                                <li class="submenu">
                                    <a href="#"><i class="la la-cube mr-2" style="font-size: 18px"></i><span> Selling Unit</span> <span class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a class="{{ Request::is('sellingunits') ? 'active' : '' }}" href="{{route('sellingunits.index')}}" style="text-decoration: none">All Unit</a></li>
                                        <li><a class="{{ Request::is('sellingunits/create') ? 'active' : '' }}" href="{{route('sellingunits.create')}}" style="text-decoration: none">
                                                Add Unit</a></li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="#"><i class="la la-cube mr-2" style="font-size: 18px"></i><span> Selling Price</span> <span class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a class="{{ Request::is('product/price/index') ? 'active' : '' }}" href="{{route('add.index')}}" style="text-decoration: none">All Price List</a></li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="#"><i class="la la-cube mr-2" style="font-size: 18px"></i><span>Supplier</span> <span class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a class="{{ Request::is('suppliers') ? 'active' : '' }}" href="{{route('suppliers')}}" style="text-decoration: none">All Suppliers</a></li>
                                        <li><a class="{{ Request::is('customers/create') ? 'active' : '' }}" href="{{route('customers.create')}}" style="text-decoration: none">
                                                Supplier Create</a></li>

                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="#"><i class="la la-cube mr-2" style="font-size: 18px"></i><span>Stock Transaction</span> <span class="menu-arrow"></span></a>
                                    <ul style="display: none;">

                                        <li><a class="{{ Request::is('stocks') ? 'active' : '' }}"
                                               href="{{ route('stocks') }}" style="text-decoration: none">Stocks</a></li>

                                        <li><a class="{{ Request::is('stocks/index') ? 'active' : '' }}" href="{{route('stocks.index')}}" style="text-decoration: none">Stock Transaction</a></li>
                                        <li><a class="{{ Request::is('stockin') ? 'active' : '' }}" href="{{route('showstockin')}}" style="text-decoration: none">
                                                Stock In</a></li>
                                        <li><a class="{{ Request::is('stockout/index') ? 'active' : '' }}"
                                               href="{{ route('stock.out.index') }}" style="text-decoration: none">Stocks Out</a></li>
                                        <li><a class="{{ Request::is('stockout') ? 'active' : '' }}" href="{{route('showstockout')}}" style="text-decoration: none">
                                                Create Stockout</a></li>

                                    </ul>
                                </li>
                                <li><a class="{{ Request::is('transfer/index') ? 'active' : '' }}"
                                       href="{{ route('transfer.index') }}" style="text-decoration: none"><i class="la la-exchange mr-2" style="font-size: 18px"></i>Stock Transfer</a></li>
                                <li><a class="{{ Request::is('damage/index') ? 'active' : '' }}"
                                       href="{{ route('damage.index') }}" style="text-decoration: none"><i class="la la-cube mr-2" style="font-size: 18px"></i>Damage Product</a></li>
                            </ul>

                        </li>
                        <li class="submenu">
                            <a href="#"><i class="la la-shopping-cart"></i> <span>Purchase</span> <span
                                        class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li class="submenu">
                                    <a href="#" ><i class="la la-cube mr-2" style="font-size: 18px;"></i><span> Purchase Request</span> <span class="menu-arrow"></span></a>
                                    <ul style="display: none;">

                                        <li><a class="{{ Request::is('purchase_request') ? 'active' : '' }}"
                                               href="{{ route('purchase_request.index') }}" style="text-decoration: none">Purchase Request</a></li>

                                        <li><a class="{{ Request::is('purchase_request/create') ? 'active' : '' }}"
                                               href="{{ route('purchase_request.create') }}" style="text-decoration: none">Create </a></li>

                                    </ul>
                                </li>

                                <li class="submenu">
                                    <a href="#"><i class="la la-cube mr-2" style="font-size: 18px;"></i> <span>RFQs</span> <span
                                                class="menu-arrow"></span></a>
                                    <ul style="display: none;">

                                        <li><a class="{{ Request::is('rfqs') ? 'active' : '' }}"
                                               href="{{ route('rfqs.index') }}" style="text-decoration: none">All RFQs</a></li>

                                        <li><a class="{{ Request::is('rfqs/create') ? 'active' : '' }}"
                                               href="{{ route('rfqs.create') }}" style="text-decoration: none">Create</a></li>

                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="#"><i class="la la-cube mr-2" style="font-size: 18px;"></i> <span>Purchase Order</span> <span
                                                class="menu-arrow"></span></a>
                                    <ul style="display: none;">

                                        <li><a class="{{ Request::is('purchaseorders') ? 'active' : '' }}"
                                               href="{{ route('purchaseorders.index') }}" style="text-decoration: none">All Purchase Order</a></li>

                                        <li><a class="{{ Request::is('purchaseorders/create') ? 'active' : '' }}"
                                               href="{{ route('purchaseorders.create') }}" style="text-decoration: none">Create</a></li>

                                    </ul>
                                </li>
                            </ul>

                        </li>
                        <li class="submenu">
                            <a href="#"><i class="la la-money " style="font-size: 18px"></i><span>Logistics Bill</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a class="{{ Request::is('bills') ? 'active' : '' }}" href="{{route('bills.index')}}" style="text-decoration: none">All Bill</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="la la-truck" style="font-size: 18px;"></i> <span>Delivery</span> <span
                                        class="menu-arrow"></span></a>
                            <ul style="display: none;">

                                <li><a class="{{ Request::is('deliveries') ? 'active' : '' }}"
                                       href="{{ route('deliveries.index') }}" style="text-decoration: none">All Delivery</a></li>

                                <li><a class="{{ Request::is('deliveries/create') ? 'active' : '' }}"
                                       href="{{ route('deliveries.create') }}" style="text-decoration: none">Delivery Create</a></li>

                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="la la-cube"></i> <span>Sale</span> <span
                                        class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a class="{{ Request::is('selling/report') ? 'active' : '' }}"
                                       href="{{ route('sale.report') }}" style="text-decoration: none"><i class="la la-calendar mr-1" style="font-size: 18px;"></i>Sale Report</a></li>
                                <li><a class="{{ Request::is('sale/activity') ? 'active' : '' }}"
                                       href="{{ route('activity.index') }}" style="text-decoration: none"><i class="la la-calendar mr-1" style="font-size: 18px;"></i>Sale Activity</a></li>
                                <li><a class="{{ Request::is('saletargets/create') ? 'active' : '' }}" href="{{ route('saletargets.create') }}" style="text-decoration: none"><i class="la la-bullseye mr-1" style="font-size: 18px;"></i> Add Sale Target</a></li>
                                <li><a class="{{ Request::is('contact/qualified') ? 'active' : '' }}" href="{{ route('qualified_contact') }}" style="text-decoration: none"><i class="la la-users mr-1" style="font-size: 18px;"></i> Customer</a></li>
                                <li class="submenu">
                                    <a href="#"><img src="{{url(asset('img/icon_image/invoice.png'))}}"  alt="" width="18px" height="18px" class="mr-1" ><span> Invoice</span> <span
                                                class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a class="{{ Request::is('invoices') ? 'active' : '' }}"
                                               href="{{ route('invoices.index') }}" style="text-decoration: none">All Invoice</a></li>
                                        <li><a class="{{ Request::is('invoices/create') ? 'active' : '' }}"
                                               href="{{ route('invoices.create') }}" style="text-decoration: none">Whole Sale</a></li>
                                        <li><a class="{{ Request::is('rental/invoice/crate') ? 'active' : '' }}"
                                               href="{{ route('invoice.rental') }}" style="text-decoration: none">Retail Sale</a></li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="#"><img src="{{url(asset('img/icon_image/order24.png'))}}"  alt="" class="mr-1" width="18px" height="18px;"><span> Order</span> <span
                                                class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a class="{{ Request::is('saleorders') ? 'active' : '' }}"
                                               href="{{ route('saleorders.index') }}" style="text-decoration: none">All Orders</a></li>
                                        <li><a class="{{ Request::is('saleorders/create') ? 'active' : '' }}"
                                               href="{{ route('saleorders.create') }}" style="text-decoration: none">Orders Create</a></li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="#"><i class="la la-cube mr-2" style="font-size: 18px"></i><span>Promotion and Discount</span> <span class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a class="{{ Request::is('discount_promotions') ? 'active' : '' }}" href="{{route('discount_promotions.index')}}" style="text-decoration: none">All Promotion and Discount</a></li>
                                        <li><a class="{{ Request::is('discount_promotions/create') ? 'active' : '' }}" href="{{route('discount_promotions.create')}}" style="text-decoration: none">
                                                Add Promotion and Discount</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="la la-cube"></i> <span>CRM</span> <span
                                        class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a class="{{ Request::is('leads') ? 'active' : '' }}" href="{{route('leads.index')}}" style="text-decoration: none"><i class="la la-question-circle mr-2"></i> <span>All Leads</span></a></li>
                                <li class="submenu">
                                    <a href="#"><i class="fa fa-handshake-o mr-2" style="font-size: 18px"></i><span> Deal</span> <span class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a class="{{ Request::is('deals') ? 'active' : '' }}" href="{{ route('deals.index') }}" style="text-decoration: none">All
                                                Deals</a></li>
                                        <li><a class="{{ Request::is('deals/create') ? 'active' : '' }}" href="{{ route('deals.create') }}" style="text-decoration: none">
                                                Deal Create</a></li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="#"><img src="{{url(asset('img/icon_image/quotation.png'))}}"  alt="" class="mr-1" width="18px" height="18px"><span> Quotation</span> <span
                                                class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a class="{{ Request::is('quotations') ? 'active' : '' }}"
                                               href="{{ route('quotations.index') }}" style="text-decoration: none">All Quotations</a></li>
                                        <li><a class="{{ Request::is('quotations/create') ? 'active' : '' }}"
                                               href="{{ route('quotations.create') }}" style="text-decoration: none">Whole Sale Quotation</a></li>
                                        <li><a class="{{ Request::is('retail/sale/quotation') ? 'active' : '' }}"
                                               href="{{ route('quotations.retail') }}" style="text-decoration: none">Retail Sale Quotation</a></li>
                                    </ul>
                                </li>

                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="la la-pie-chart" style="font-size: 18px"></i> <span> Report</span> <span
                                        class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a class="{{ Request::is('reports') ? 'active' : '' }}"
                                       href="{{ route('reports') }}" style="text-decoration: none">Daily Report</a></li>
                                <li><a class="{{ Request::is('sale/performance') ? 'active' : '' }}"
                                       href="{{ route('report.saleprformance') }}" style="text-decoration: none">Sale Performance Report</a></li>

                            </ul>
                        </li>
                    </ul>
                    @else
                    <ul>
                        <li>
                            <a href="{{url('customer/home')}}"><i class="la la-home mr-2"></i> Home</a>
                        </li>
                        <li>
                            <a href="{{url('customer/invoice')}}"><i class="la la-file mr-2"></i>Invoice</a>
                        </li>
                        <li>
                            <a href="{{route('customer.ticket')}}"><i class="la la-ticket mr-2"></i>Ticket</a>
                        </li>
                        <li><a class="{{ Request::is('advancepayments') ? 'active' : '' }}"
                               href="{{ route('advancepayments.index') }}" style="text-decoration: none"><i class="la la-money mr-2" style="font-size: 18px"></i>Advance Payment</a></li>
                        <li><a class="{{ Request::is('saleorders') ? 'active' : '' }}"
                               href="{{ route('orders.index') }}" style="text-decoration: none"><i class="la la-cube mr-2" style="font-size: 18px"></i>All Orders</a></li>
                        <li class="submenu">
                            <a href="{{ route('deliveries.index') }}"><i class="la la-truck mr-2" style="font-size: 18px;"></i>Delivery<span class="menu-arrow"></span></a>
                            <ul style="display: none;">

                                <li><a class="{{ Request::is('deliveries') ? 'active' : '' }}"
                                       href="{{ route('deliveries.index') }}" style="text-decoration: none">All Delivery</a></li>

                            </ul>
                        <li class="submenu">
                            <a href="{{ route('deliveries.index') }}"><i class="la la-cog mr-2" style="font-size: 18px;"></i> Setting <span
                                        class="menu-arrow"></span></a>
                            <ul style="display: none;">

                                <li><a class="{{ Request::is('customer/password/change/') ? 'active' : '' }}"
                                       href="{{ route('customers.changepassword') }}" style="text-decoration: none">Password Change</a></li>

                            </ul>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>


