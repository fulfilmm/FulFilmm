<ul>
    <li class="submenu">
        <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}" style="text-decoration: none">
                    Dashboard</a></li>
            <li><a class="{{ Request::is('sale/dashboard') ? 'active' : '' }}" href="{{ route('sale.dashboard') }}"
                   style="text-decoration: none">
                    Sale Dashboard</a></li>
            <li class="submenu">
                <a href="#"> <span> Report</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a class="{{ Request::is('reports') ? 'active' : '' }}"
                           href="{{ route('reports') }}" style="text-decoration: none">Daily Report</a></li>
                    <li><a class="{{ Request::is('sale/performance') ? 'active' : '' }}"
                           href="{{ route('report.saleprformance') }}" style="text-decoration: none">Sale Performance
                            Report</a></li>

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
        <a href="#"><i class="la la-building" style="font-size: 18px;"></i><span> Company</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">

            <li><a class="{{ Request::is('companies') ? 'active' : '' }}"
                   href="{{ route('companies.index') }}" style="text-decoration: none">All Companies</a></li>

            <li><a class="{{ Request::is('companies/create') ? 'active' : '' }}"
                   href="{{ route('companies.create') }}" style="text-decoration: none">Create Company</a></li>

        </ul>
    </li><!--Company -->
    <li class="submenu">
        <a href="#"><i class="la la-group"></i> <span>Operation</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
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
        <a href="#"><i class="la la-group"></i> <span>People</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li class="submenu">
                <a href="#"><span> Office Branch</span> <span
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
                <a href="#"><span> Employees</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">

                    <li><a class="{{ Request::is('employees') ? 'active' : '' }}"
                           href="{{ route('employees.index') }}" style="text-decoration: none">All Employees</a></li>

                    <li><a class="{{ Request::is('employees/create') ? 'active' : '' }}"
                           href="{{ route('employees.create') }}" style="text-decoration: none">Create Employee</a></li>

                </ul>
            </li>

            <li class="submenu">
                <a href="#"><span> Departments</span> <span
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
                <a href="#"><span> Groups</span> <span
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

    </li><!--People-->
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
    </li><!--Complaint-->
    <li class="submenu">
        <a href="#"><i class="la la-cube"></i> <span>Accounting</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li><a class="{{ Request::is('invoices') ? 'active' : '' }}"
                   href="{{ route('invoices.index') }}" style="text-decoration: none">All Invoice</a></li>
            <li><a class="{{ Request::is('invoice/view/due') ? 'active' : '' }}"
                   href="{{ url('invoice/view/'.'due') }}" style="text-decoration: none">Due Invoice</a></li>
            <li><a class="{{ Request::is('invoice/view/whole') ? 'active' : '' }}"
                   href="{{ url('invoice/view/whole') }}" style="text-decoration: none">Whole Sale</a></li>
            <li><a class="{{ Request::is('invoice/view/retail') ? 'active' : '' }}"
                   href="{{ url('invoice/view/retail') }}" style="text-decoration: none">Retail Sale</a></li>
            <li><a class="{{ Request::is('coatype') ? 'active' : '' }}" href="{{route('coatype.index')}}"
                   style="text-decoration: none"><span>Account Type</span>
                </a></li>
            <li><a class="{{ Request::is('chartofaccount') ? 'active' : '' }}" href="{{route('chartofaccount.index')}}"
                   style="text-decoration: none"><span>Chart Of Account</span>
                </a></li>
            <li><a class="{{ Request::is('accounts') ? 'active' : '' }}" href="{{route('accounts.index')}}"
                   style="text-decoration: none"><span> Account</span> </a></li>
            <li><a class="{{ Request::is('revenuebudget') ? 'active' : '' }}" href="{{route('revenuebudget.index')}}"
                   style="text-decoration: none"><span> Revenue Budget</span>
                </a></li>
            <li><a class="{{ Request::is('expensebudget') ? 'active' : '' }}" href="{{route('expensebudget.index')}}"
                   style="text-decoration: none"><span> Expense Budget</span>
                </a></li>
            <li>
                <a class="{{ Request::is('transaction/category') ? 'active' : '' }}"
                   href="{{route('transaction.category')}}" style="text-decoration: none"><span> Category</span>
                </a>
            </li>
        </ul>

    </li><!--Accounting -->
    <li class="submenu">
        <a href="#"><i class="la la-cube"></i> <span>Banking</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li><a class="{{ Request::is('advancepayments') ? 'active' : '' }}"
                   href="{{ route('advancepayments.index') }}" style="text-decoration: none">Advance
                    Payment</a></li>
            <li>
                <a class="{{ Request::is('transaction/category') ? 'active' : '' }}"
                   href="{{route('transaction.category')}}" style="text-decoration: none"><span> Category</span>
                </a>
                <a class="{{ Request::is('accounts') ? 'active' : '' }}" href="{{route('accounts.index')}}"
                   style="text-decoration: none"><span> Account</span> </a>
                <a class="{{ Request::is('transactions') ? 'active' : '' }}" href="{{route('transactions.index')}}"
                   style="text-decoration: none"><span> Transaction</span>
                </a>
                <a class="{{ Request::is('revenue') ? 'active' : '' }}" href="{{route('revenue')}}"
                   style="text-decoration: none"><span> Revenue</span> </a>
                <a class="{{ Request::is('expense') ? 'active' : '' }}" href="{{route('expense')}}"
                   style="text-decoration: none"><span> Expense</span> </a>
            </li>
        </ul>

    </li><!--Banking-->
    <li class="submenu">
        <a href="#"><i class="la la-puzzle-piece"></i> <span> Stock Managements</span> <span
                    class="menu-arrow"></span></a>

        <ul style="display: none;">
            <li class="submenu">
                <a href="#"><span>Supplier</span> <span
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
                   href="{{ route('inventory.index') }}" style="text-decoration: none">Inventory</a>
            </li>
            <li><a class="{{ Request::is('warehouses') ? 'active' : '' }}"
                   href="{{ route('warehouses.index') }}" style="text-decoration: none">Warehouse</a>
            </li>
            <li class="submenu">
                <a href="#"><span>Bin Look Up</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a class="{{ Request::is('binlookup') ? 'active' : '' }}" href="{{route('binlookup.index')}}"
                           style="text-decoration: none">All Bin Look Up</a></li>
                    <li><a class="{{ Request::is('binlookup/create') ? 'active' : '' }}"
                           href="{{route('binlookup.create')}}" style="text-decoration: none">
                            Bin Look Up Create</a></li>

                </ul>
            </li>
            <li class="submenu">
                <a href="#"><span>Stock Return</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a class="{{ Request::is('stockreturn') ? 'active' : '' }}" href="{{route('stockreturn.index')}}"
                           style="text-decoration: none">Stock Return</a></li>
                    <li><a class="{{ Request::is('stockreturn/create') ? 'active' : '' }}"
                           href="{{route('stockreturn.create')}}" style="text-decoration: none">
                            Stock Return Create</a></li>

                </ul>
            </li>
            <li><a class="{{ Request::is('stocks') ? 'active' : '' }}"
                   href="{{ route('stocks') }}" style="text-decoration: none">Stocks</a>
            </li>
            <li><a class="{{ Request::is('ecommerce/stock/index') ? 'active' : '' }}"
                   href="{{ route('ecommerce_stock') }}" style="text-decoration: none">E-commerce
                    Stocks</a></li>
            <li><a class="{{ Request::is('stockin') ? 'active' : '' }}" href="{{route('showstockin')}}"
                   style="text-decoration: none">Stock In</a></li>
            <li><a class="{{ Request::is('stockout/index') ? 'active' : '' }}"
                   href="{{ route('stock.out.index') }}" style="text-decoration: none">Stocks
                    Out</a></li>
            <li><a class="{{ Request::is('transfer/index') ? 'active' : '' }}"
                   href="{{ route('transfer.index') }}" style="text-decoration: none">Stock Transfer</a></li>
            <li><a class="{{ Request::is('stocks/index') ? 'active' : '' }}" href="{{route('stocks.index')}}"
                   style="text-decoration: none">Stock
                    Transaction</a></li>
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
                    <li><a class="{{ Request::is('products/create') ? 'active' : '' }}"
                           href="{{url('/products/create')}}" style="text-decoration: none">
                            Product Create</a></li>
                    <li><a class="{{ Request::is('product/variant/create') ? 'active' : '' }}"
                           href="{{route('create.variant')}}" style="text-decoration: none">
                            Product Variant Add</a></li>
                </ul>
            </li>
            <li><a class="{{ Request::is('foc/index') ? 'active' : '' }}" href="{{route('foc.index')}}"
                   style="text-decoration: none">FOC Product</a></li>
            <li><a class="{{ Request::is('damage/index') ? 'active' : '' }}"
                   href="{{ route('damage.index') }}" style="text-decoration: none">Damage Product</a></li>
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
    <li class="submenu">
        <a href="#"><i class="la la-shopping-cart"></i> <span>Purchase</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li class="submenu">
                <a href="#"><span> Purchase Request</span> <span
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
                <a href="#"> <span>RFQs</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">

                    <li><a class="{{ Request::is('rfqs') ? 'active' : '' }}"
                           href="{{ route('rfqs.index') }}" style="text-decoration: none">All RFQs</a></li>

                    <li><a class="{{ Request::is('rfqs/create') ? 'active' : '' }}"
                           href="{{ route('rfqs.create') }}" style="text-decoration: none">Create</a></li>

                </ul>
            </li>
            <li class="submenu">
                <a href="#"><span>Purchase Order</span> <span
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
    <li class="submenu">
        <a href="#"><i class="la la-money " ></i><span>Bills</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li><a class="{{ Request::is('bills') ? 'active' : '' }}" href="{{route('bills.index')}}"
                   style="text-decoration: none">All Bill</a></li>
            <li><a class="{{ Request::is('bills') ? 'active' : '' }}" href="{{route('bills.create')}}"
                   style="text-decoration: none">Create</a></li>
        </ul>
    </li><!--Bill -->
    <li class="submenu">
        <a href="#"><i class="la la-truck"></i> <span>Delivery</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">

            <li><a class="{{ Request::is('deliveries') ? 'active' : '' }}"
                   href="{{ route('deliveries.index') }}" style="text-decoration: none">All Delivery</a></li>

            <li><a class="{{ Request::is('deliveries/create') ? 'active' : '' }}"
                   href="{{ route('deliveries.create') }}" style="text-decoration: none">Delivery Create</a></li>
            <li><a class="{{ Request::is('delivery/transaction') ? 'active' : '' }}"
                   href="{{ route('delivery.transaction') }}" style="text-decoration: none">Delivery Transaction</a>
            </li>

        </ul>
    </li><!-- Delivery -->
    <li class="submenu">
        <a href="#"><i class="la la-automobile" ></i> <span> Cars</span> <span
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
    </li><!--Car -->
    <li class="submenu">
        <a href="#"><i class="la la-cube"></i> <span>Sale</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li><a class="{{ Request::is('invoice/view/whole') ? 'active' : '' }}"
                   href="{{ url('invoice/view/whole') }}" style="text-decoration: none">Whole Sale</a></li>
            <li><a class="{{ Request::is('invoice/view/retail') ? 'active' : '' }}"
                   href="{{ url('invoice/view/retail') }}" style="text-decoration: none">Retail Sale</a></li>
            <li><a class="{{ Request::is('barcode/create') ? 'active' : '' }}"
                   href="{{ route('barcode.create') }}" style="text-decoration: none">Barcode Generate</a></li>
            <li class="submenu">
                <a href="#"><span> Selling Price</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a class="{{ Request::is('product/price/index') ? 'active' : '' }}"
                           href="{{route('add.index')}}" style="text-decoration: none">All Price List</a></li>
                </ul>
            </li>
            <li><a class="{{ Request::is('main/customer') ? 'active' : '' }}"
                   href="{{ route('customer') }}" style="text-decoration: none">Customers</a>
            </li>
            <li><a class="{{ Request::is('selling/report') ? 'active' : '' }}"
                   href="{{ route('sale.report') }}" style="text-decoration: none">Sale Report</a></li>
            <li><a class="{{ Request::is('sale/activity') ? 'active' : '' }}"
                   href="{{ route('activity.index') }}" style="text-decoration: none">Sale Activity</a></li>
            <li><a class="{{ Request::is('saletargets/create') ? 'active' : '' }}"
                   href="{{ route('saletargets.create') }}" style="text-decoration: none">Sale Target</a></li>
            <li><a class="{{ Request::is('contact/qualified') ? 'active' : '' }}"
                   href="{{ route('qualified_contact') }}" style="text-decoration: none">Qualified Customer</a></li>
            <li class="submenu">
                <a href="#"><span> Order</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a class="{{ Request::is('saleorders') ? 'active' : '' }}"
                           href="{{ route('saleorders.index') }}" style="text-decoration: none">All Orders</a></li>
                    <li><a class="{{ Request::is('saleorders/create') ? 'active' : '' }}"
                           href="{{ route('saleorders.create') }}" style="text-decoration: none">Orders Create</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><span>Promotion and Discount</span>
                    <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a class="{{ Request::is('discount_promotions') ? 'active' : '' }}"
                           href="{{route('discount_promotions.index')}}" style="text-decoration: none">All Promotion and
                            Discount</a></li>
                    <li><a class="{{ Request::is('discount_promotions/create') ? 'active' : '' }}"
                           href="{{route('discount_promotions.create')}}" style="text-decoration: none">
                            Add Promotion and Discount</a></li>
                    <li><a class="{{ Request::is('discount') ? 'active' : '' }}"
                           href="{{route('discount.index')}}" style="text-decoration: none">
                            Amount Discount</a></li>
                </ul>
            </li>
        </ul>
    </li><!--Sale -->
    <li class="submenu">
        <a href="#"><i class="la la-cube"></i> <span>CRM</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li><a class="{{ Request::is('leads') ? 'active' : '' }}" href="{{route('leads.index')}}"
                   style="text-decoration: none"><span>All Leads</span></a>
            </li>
            <li class="submenu">
                <a href="#"><span> Deal</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a class="{{ Request::is('deals') ? 'active' : '' }}" href="{{ route('deals.index') }}"
                           style="text-decoration: none">All
                            Deals</a></li>
                    <li><a class="{{ Request::is('deals/create') ? 'active' : '' }}" href="{{ route('deals.create') }}"
                           style="text-decoration: none">
                            Deal Create</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><span> Quotation</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a class="{{ Request::is('quotations') ? 'active' : '' }}"
                           href="{{ route('quotations.index') }}" style="text-decoration: none">All Quotations</a></li>
                    <li><a class="{{ Request::is('quotations/create') ? 'active' : '' }}"
                           href="{{ route('quotations.create') }}" style="text-decoration: none">Whole Sale
                            Quotation</a></li>
                    <li><a class="{{ Request::is('retail/sale/quotation') ? 'active' : '' }}"
                           href="{{ route('quotations.retail') }}" style="text-decoration: none">Retail Sale
                            Quotation</a></li>
                </ul>
            </li>

        </ul>
    </li><!--CRM -->
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

                    <li><a class="{{ Request::is('roles') ? 'active' : '' }}" href="{{ route('roles.index') }}"
                           style="text-decoration: none">All
                            Roles</a></li>

                    <li><a class="{{ Request::is('roles/create') ? 'active' : '' }}"
                           href="{{ route('roles.create') }}" style="text-decoration: none">Create Role</a></li>

                </ul>
            </li>
            <li><a class="{{ Request::is('product/tax') ? 'active' : '' }}"
                   href="{{ route('taxes') }}" style="text-decoration: none">Tax Setting</a></li>
        </ul>
    </li><!--Setting-->
</ul>