<ul>
    <li class="submenu">
        <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}" style="text-decoration: none">
                    Dashboard</a></li>
            <li class="submenu">
                <a href="#"> <span> Report</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a class="{{ Request::is('reports') ? 'active' : '' }}"
                           href="{{ route('reports') }}" style="text-decoration: none">Daily Report</a></li>

                </ul>
            </li>
        </ul>
    </li>
    <!--- Dashboard menu -->
    <li class="submenu">
        <a href="#"><i class="la la-th-list" style="font-size: 18px;"></i><span> Contact</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">

            <li><a class="{{ Request::is('customers') ? 'active' : '' }}"
                   href="{{ route('customers.index') }}" style="text-decoration: none;">Contacts</a></li>

            <li><a class="{{ Request::is('customers/create') ? 'active' : '' }}"
                   href="{{ route('customers.create') }}" style="text-decoration: none">Create Contact</a></li>
        </ul>
    </li><!--Contact -->
    <li class="submenu">
        <a href="#"><i class="la la-group"></i> <span>Operation</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li><a class="{{ Request::is('expense_record') ? 'active' : '' }}"
                   href="{{ route('expense_record.index') }}" style="text-decoration: none">Expense Record</a></li>
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
        </ul>


    </li><!-- Operation -->

    <li class="submenu">
        <a href="#"><i class="la la-ticket"></i> <span>Complain System</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">

                <li><a class="{{ Request::is('tickets') ? 'active' : '' }}"
                       href="{{ route('tickets.index') }}"> style="text-decoration: none" My Created Ticket</a></li>
                <li><a class="{{ Request::is('followed') ? 'active' : '' }}"
                       href="{{ route('followed.tickets') }}" style="text-decoration: none">My Follow Ticket</a></li>

        </ul>
    </li><!--Complaint-->

    <li class="submenu">
        <a href="#"><i class="la la-puzzle-piece"></i> <span> Stock Managements</span> <span
                    class="menu-arrow"></span></a>

        <ul style="display: none;">
            <li class="submenu">
                <a href="#"><i class="la la-users mr-2" style="font-size: 18px"></i><span>Supplier</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a class="{{ Request::is('suppliers') ? 'active' : '' }}" href="{{route('suppliers')}}"
                           style="text-decoration: none">All Suppliers</a></li>
                    <li><a class="{{ Request::is('customers/create') ? 'active' : '' }}"
                           href="{{route('customers.create')}}" style="text-decoration: none">
                            Supplier Create</a></li>

                </ul>
            </li>

            <li><a class="{{ Request::is('inventory') ? 'active' : '' }}"
                   href="{{ route('inventory.index') }}" style="text-decoration: none"><i class="la la-bar-chart mr-2"
                                                                                          style="font-size: 18px"></i>Inventory</a>
            </li>
            <li><a class="{{ Request::is('warehouses') ? 'active' : '' }}"
                   href="{{ route('warehouses.index') }}" style="text-decoration: none"><i class="la la-building mr-2"
                                                                                           style="font-size: 18px"></i>Warehouse</a>
            </li>
            <li><a class="{{ Request::is('stocks') ? 'active' : '' }}"
                   href="{{ route('stocks') }}" style="text-decoration: none"><i class="la la-cube mr-2"
                                                                                 style="font-size: 18px"></i>Stocks</a>
            </li>
            <li><a class="{{ Request::is('ecommerce/stock/index') ? 'active' : '' }}"
                   href="{{ route('ecommerce_stock') }}" style="text-decoration: none"><i class="la la-cube mr-2"
                                                                                          style="font-size: 18px"></i>E-commerce
                    Stocks</a></li>
            <li><a class="{{ Request::is('transfer/index') ? 'active' : '' }}"
                   href="{{ route('transfer.index') }}" style="text-decoration: none"><i class="la la-exchange mr-2"
                                                                                         style="font-size: 18px"></i>Stock
                    Transfer</a></li>
            <li><a class="{{ Request::is('stocks/index') ? 'active' : '' }}" href="{{route('stocks.index')}}"
                   style="text-decoration: none"><i class="la la-cube mr-2" style="font-size: 18px"></i>Stock
                    Transaction</a></li>
            <li class="submenu">
                <a href="#"><i class="la la-cube mr-2" style="font-size: 18px"></i><span> Product</span> <span
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
                    <li><a class="{{ Request::is('products/create') ? 'active' : '' }}"
                           href="{{url('/products/create')}}" style="text-decoration: none">
                            Product Create</a></li>
                    <li><a class="{{ Request::is('product/variant/create') ? 'active' : '' }}"
                           href="{{route('create.variant')}}" style="text-decoration: none">
                            Product Variant Add</a></li>
                </ul>
            </li>
            <li><a class="{{ Request::is('foc/index') ? 'active' : '' }}" href="{{route('foc.index')}}"
                   style="text-decoration: none">
                    <i class="la la-cube mr-2" style="font-size: 18px"></i> FOC Product</a></li>
            <li><a class="{{ Request::is('damage/index') ? 'active' : '' }}"
                   href="{{ route('damage.index') }}" style="text-decoration: none"><i class="la la- mr-2"
                                                                                       style="font-size: 18px"></i>Damage
                    Product</a></li>
            <li class="submenu">
                <a href="#"><i class="la la-cube mr-2" style="font-size: 18px"></i><span> Selling Unit</span> <span
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
    <li class="submenu">
        <a href="#"><i class="la la-shopping-cart"></i> <span>Purchase</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li class="submenu">
                <a href="#"><i class="la la-cube mr-2" style="font-size: 18px;"></i><span> Purchase Request</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">

                    <li><a class="{{ Request::is('purchase_request') ? 'active' : '' }}"
                           href="{{ route('purchase_request.index') }}" style="text-decoration: none">Purchase
                            Request</a></li>

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
                           href="{{ route('purchaseorders.index') }}" style="text-decoration: none">All Purchase
                            Order</a></li>

                    <li><a class="{{ Request::is('purchaseorders/create') ? 'active' : '' }}"
                           href="{{ route('purchaseorders.create') }}" style="text-decoration: none">Create</a></li>

                </ul>
            </li>
        </ul>

    </li><!--Purchase-->
</ul>