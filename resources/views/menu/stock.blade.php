<ul>
    <li class="submenu">
        <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}" style="text-decoration: none">
                    Dashboard</a></li>

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
                           {{--href="{{ route('petty_cash.index') }}" style="text-decoration: none">All Advance Cash</a>--}}
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
                <a href="#"><i class="la la-th-list" style="font-size: 18px;"></i><span> Office Branch</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">

                    <li><a class="{{ Request::is('officebranch') ? 'active' : '' }}"
                           href="{{ route('officebranch.index') }}" style="text-decoration: none;">Branch</a></li>

                    <li><a class="{{ Request::is('officebranch/create') ? 'active' : '' }}"
                           href="{{ route('officebranch.create') }}" style="text-decoration: none">Create Branch</a>
                    </li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-users mr-2" style="font-size: 18px;"></i><span> Employees</span> <span
                            class="menu-arrow"></span></a>
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
                           href="{{ route('departments.index') }}" style="text-decoration: none">All Departments</a>
                    </li>

                    <li><a class="{{ Request::is('departments/create') ? 'active' : '' }}"
                           href="{{ route('departments.create') }}" style="text-decoration: none">Create Department</a>
                    </li>

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
    <li class="submenu">
        <a href="#"><i class="la la-puzzle-piece"></i> <span> Stock Managements</span> <span
                    class="menu-arrow"></span></a>

        <ul style="display: none;">
            {{--<li><a class="{{ Request::is('stockout/index') ? 'active' : '' }}"--}}
                   {{--href="{{ route('stock.out.index') }}" style="text-decoration: none">Stocks--}}
                    {{--Out</a></li>--}}
            {{--<li><a class="{{ Request::is('barcode/create') ? 'active' : '' }}"--}}
                   {{--href="{{ route('barcode.create') }}" style="text-decoration: none">Barcode Generate</a></li>--}}
            {{--<li class="submenu">--}}
                {{--<a href="#"><span>Supplier</span> <span--}}
                            {{--class="menu-arrow"></span></a>--}}
                {{--<ul style="display: none;">--}}
                    {{--<li><a class="{{ Request::is('suppliers') ? 'active' : '' }}" href="{{route('suppliers')}}"--}}
                           {{--style="text-decoration: none">All Suppliers</a></li>--}}
                    {{--<li><a class="{{ Request::is('customers/create') ? 'active' : '' }}"--}}
                           {{--href="{{route('customers.create')}}" style="text-decoration: none">--}}
                            {{--Supplier Create</a></li>--}}

                {{--</ul>--}}
            {{--</li>--}}

            {{--<li><a class="{{ Request::is('inventory') ? 'active' : '' }}"--}}
                   {{--href="{{ route('inventory.index') }}" style="text-decoration: none">Inventory</a>--}}
            {{--</li>--}}
            {{--<li><a class="{{ Request::is('warehouses') ? 'active' : '' }}"--}}
                   {{--href="{{ route('warehouses.index') }}" style="text-decoration: none">Warehouse</a>--}}
            {{--</li>--}}
            {{--<li class="submenu">--}}
                {{--<a href="#"><span>Bin Look Up</span> <span--}}
                            {{--class="menu-arrow"></span></a>--}}
                {{--<ul style="display: none;">--}}
                    {{--<li><a class="{{ Request::is('binlookup') ? 'active' : '' }}" href="{{route('binlookup.index')}}"--}}
                           {{--style="text-decoration: none">All Bin Look Up</a></li>--}}
                    {{--<li><a class="{{ Request::is('binlookup/create') ? 'active' : '' }}"--}}
                           {{--href="{{route('binlookup.create')}}" style="text-decoration: none">--}}
                            {{--Bin Look Up Create</a></li>--}}

                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="submenu">--}}
                {{--<a href="#"><span>Stock Return</span> <span--}}
                            {{--class="menu-arrow"></span></a>--}}
                {{--<ul style="display: none;">--}}
                    {{--<li><a class="{{ Request::is('stockreturn') ? 'active' : '' }}" href="{{route('stockreturn.index')}}"--}}
                           {{--style="text-decoration: none">Stock Return</a></li>--}}
                    {{--<li><a class="{{ Request::is('stockreturn/create') ? 'active' : '' }}"--}}
                           {{--href="{{route('stockreturn.create')}}" style="text-decoration: none">--}}
                            {{--Stock Return Create</a></li>--}}
                    {{--<li><a class="{{ Request::is('mobile/warehouse/return') ? 'active' : '' }}"--}}
                           {{--href="{{ route('stockreturn.mobile') }}" style="text-decoration: none">Mobile Stock Return</a></li>--}}

                {{--</ul>--}}
            {{--</li>--}}
            <li><a class="{{ Request::is('stocks') ? 'active' : '' }}"
                   href="{{ route('stocks') }}" style="text-decoration: none">Stocks</a>
            </li>
            {{--<li><a class="{{ Request::is('ecommerce/stock/index') ? 'active' : '' }}"--}}
                   {{--href="{{ route('ecommerce_stock') }}" style="text-decoration: none">E-commerce--}}
                    {{--Stocks</a></li>--}}
            <li><a class="{{ Request::is('stockin') ? 'active' : '' }}" href="{{route('showstockin')}}"
                   style="text-decoration: none">Stock In</a></li>
            <li><a class="{{ Request::is('stockout/index') ? 'active' : '' }}"
                   href="{{ route('stock.out.index') }}" style="text-decoration: none">Stocks
                    Out</a></li>
            {{--<li><a class="{{ Request::is('transfer/index') ? 'active' : '' }}"--}}
                   {{--href="{{ route('transfer.index') }}" style="text-decoration: none">Stock Transfer</a></li>--}}
            {{--<li><a class="{{ Request::is('stocks/index') ? 'active' : '' }}" href="{{route('stocks.index')}}"--}}
                   {{--style="text-decoration: none">Stock--}}
                    {{--Transaction</a></li>--}}
            <li class="submenu">
                <a href="#"><span> Product</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a class="{{ Request::is('product/category') ? 'active' : '' }}" href="{{route('category')}}"
                           style="text-decoration: none">Products Category</a></li>
                    <li><a class="{{ Request::is('product_brand') ? 'active' : '' }}" href="{{url('product_brand')}}"
                           style="text-decoration: none">
                            Product Brand</a></li>
                    <li><a class="{{ Request::is('products') ? 'active' : '' }}" href="{{url('/products')}}"
                           style="text-decoration: none">All
                            Products</a></li>
                    <li><a class="{{ Request::is('variant/list') ? 'active' : '' }}" href="{{route('item.list')}}"
                           style="text-decoration: none">Products Items</a></li>
                    <li><a class="{{ Request::is('products/create') ? 'active' : '' }}"
                           href="{{url('/products/create')}}" style="text-decoration: none">
                            Product Create</a></li>
                </ul>
            </li>
            {{--<li><a class="{{ Request::is('foc/index') ? 'active' : '' }}" href="{{route('foc.index')}}"--}}
                   {{--style="text-decoration: none">FOC Product</a></li>--}}
            {{--<li><a class="{{ Request::is('damage/index') ? 'active' : '' }}"--}}
                   {{--href="{{ route('damage.index') }}" style="text-decoration: none">Damage Product</a></li>--}}
            {{--<li><a class="{{ Request::is('expired/product') ? 'active' : '' }}"--}}
                   {{--href="{{ route('expired.products') }}" style="text-decoration: none">Expired Product</a></li>--}}
            {{--<li><a class="{{ Request::is('expired/alert/product') ? 'active' : '' }}"--}}
                   {{--href="{{ route('alert.products') }}" style="text-decoration: none">Expired Alert Product</a></li>--}}
            <li class="submenu">
                <a href="#"><span> Selling Unit</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a class="{{ Request::is('sellingunits') ? 'active' : '' }}"
                           href="{{route('sellingunits.index')}}" style="text-decoration: none">All Unit</a></li>
                    <li><a class="{{ Request::is('sellingunits/create') ? 'active' : '' }}"
                           href="{{route('sellingunits.create')}}" style="text-decoration: none">
                            Add Unit</a></li>
                </ul>
            </li>
        </ul>

    </li><!--Stock -->
    {{--<li class="submenu">--}}
        {{--<a href="#"><i class="la la-shopping-cart"></i> <span>Purchase</span> <span--}}
                    {{--class="menu-arrow"></span></a>--}}
        {{--<ul style="display: none;">--}}
            {{--<li class="submenu">--}}
                {{--<a href="#"><i class="la la-cube mr-2" style="font-size: 18px;"></i><span> Purchase Request</span> <span--}}
                            {{--class="menu-arrow"></span></a>--}}
                {{--<ul style="display: none;">--}}

                    {{--<li><a class="{{ Request::is('purchase_request') ? 'active' : '' }}"--}}
                           {{--href="{{ route('purchase_request.index') }}" style="text-decoration: none">Purchase--}}
                            {{--Request</a></li>--}}

                    {{--<li><a class="{{ Request::is('purchase_request/create') ? 'active' : '' }}"--}}
                           {{--href="{{ route('purchase_request.create') }}" style="text-decoration: none">Create </a></li>--}}

                {{--</ul>--}}
            {{--</li>--}}

            {{--<li class="submenu">--}}
                {{--<a href="#"><i class="la la-cube mr-2" style="font-size: 18px;"></i> <span>RFQs</span> <span--}}
                            {{--class="menu-arrow"></span></a>--}}
                {{--<ul style="display: none;">--}}

                    {{--<li><a class="{{ Request::is('rfqs') ? 'active' : '' }}"--}}
                           {{--href="{{ route('rfqs.index') }}" style="text-decoration: none">All RFQs</a></li>--}}

                    {{--<li><a class="{{ Request::is('rfqs/create') ? 'active' : '' }}"--}}
                           {{--href="{{ route('rfqs.create') }}" style="text-decoration: none">Create</a></li>--}}

                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="submenu">--}}
                {{--<a href="#"><i class="la la-cube mr-2" style="font-size: 18px;"></i> <span>Purchase Order</span> <span--}}
                            {{--class="menu-arrow"></span></a>--}}
                {{--<ul style="display: none;">--}}

                    {{--<li><a class="{{ Request::is('purchaseorders') ? 'active' : '' }}"--}}
                           {{--href="{{ route('purchaseorders.index') }}" style="text-decoration: none">All Purchase--}}
                            {{--Order</a></li>--}}

                    {{--<li><a class="{{ Request::is('purchaseorders/create') ? 'active' : '' }}"--}}
                           {{--href="{{ route('purchaseorders.create') }}" style="text-decoration: none">Create</a></li>--}}

                {{--</ul>--}}
            {{--</li>--}}
        {{--</ul>--}}

    {{--</li>--}}
    {{--<li class="submenu">--}}
        {{--<a href="#"><i class="la la-truck" style="font-size: 18px;"></i> <span>Delivery</span> <span--}}
                    {{--class="menu-arrow"></span></a>--}}
        {{--<ul style="display: none;">--}}

            {{--<li><a class="{{ Request::is('deliveries') ? 'active' : '' }}"--}}
                   {{--href="{{ route('deliveries.index') }}" style="text-decoration: none">All Delivery</a></li>--}}

            {{--<li><a class="{{ Request::is('deliveries/create') ? 'active' : '' }}"--}}
                   {{--href="{{ route('deliveries.create') }}" style="text-decoration: none">Delivery Create</a></li>--}}
            {{--<li><a class="{{ Request::is('delivery/transaction') ? 'active' : '' }}"--}}
                   {{--href="{{ route('delivery.transaction') }}" style="text-decoration: none">Delivery Transaction</a>--}}
            {{--</li>--}}

        {{--</ul>--}}
    {{--</li>--}}
    <li class="submenu">
        <a href="#"><i class="la la-pie-chart" style="font-size: 18px"></i> <span> Report</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li><a class="{{ Request::is('reports') ? 'active' : '' }}"
                   href="{{ route('reports') }}" style="text-decoration: none">Daily Report</a></li>

        </ul>
    </li>
</ul>