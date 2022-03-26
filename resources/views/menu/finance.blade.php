<ul>
    <li class="menu-title">
        <span>Main</span>
    </li>
    <li class="submenu">
        <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}" style="text-decoration: none">
                    Dashboard</a></li>
        </ul>
    </li>
    <li class="submenu">
        <a href="#"><i class="la la-th-list" style="font-size: 18px;"></i><span> Contact</span> <span
                    class="menu-arrow"></span></a>
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
        <a href="#"><i class="la la-group"></i> <span>Operation</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
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
                <a href="#"><i class="la la-th mr-2" style="font-size: 18px"></i><span> Room</span> <span
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
        <a href="#"><i class="la la-cube"></i> <span>Accounting</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li><a class="{{ Request::is('coatype') ? 'active' : '' }}" href="{{route('coatype.index')}}"
                   style="text-decoration: none"><i class="la la-bank mr-2" style="font-size: 18px"></i><span>Account Type</span>
                </a></li>
            <li><a class="{{ Request::is('chartofaccount') ? 'active' : '' }}" href="{{route('chartofaccount.index')}}"
                   style="text-decoration: none"><i class="la la-bank mr-2" style="font-size: 18px"></i><span>Chart Of Account</span>
                </a></li>
            <li><a class="{{ Request::is('accounts') ? 'active' : '' }}" href="{{route('accounts.index')}}"
                   style="text-decoration: none"><i class="la la-bank mr-2"
                                                    style="font-size: 18px"></i><span> Account</span> </a></li>
            <li><a class="{{ Request::is('revenuebudget') ? 'active' : '' }}" href="{{route('revenuebudget.index')}}"
                   style="text-decoration: none"><i class="la la-dollar mr-2" style="font-size: 18px"></i><span> Revenue Budget</span>
                </a></li>
            <li><a class="{{ Request::is('expensebudget') ? 'active' : '' }}" href="{{route('expensebudget.index')}}"
                   style="text-decoration: none"><i class="la la-dollar mr-2" style="font-size: 18px"></i><span> Expense Budget</span>
                </a></li>
            <li>
                <a class="{{ Request::is('transaction/category') ? 'active' : '' }}"
                   href="{{route('transaction.category')}}" style="text-decoration: none"><i class="la la-cube mr-2"
                                                                                             style="font-size: 18px"></i><span> Category</span>
                </a>
            </li>
        </ul>

    </li>
    <li class="submenu">
        <a href="#"><i class="la la-cube"></i> <span>Banking</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li class="submenu">
                <a href="#"><i class="la la-building mr-2" style="font-size: 18px;"></i> <span> Expense Claim</span>
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
            <li><a class="{{ Request::is('advancepayments') ? 'active' : '' }}"
                   href="{{ route('advancepayments.index') }}" style="text-decoration: none"><i class="la la-money mr-2"
                                                                                                style="font-size: 18px"></i>Advance
                    Payment</a></li>
            <li>
                <a class="{{ Request::is('transaction/category') ? 'active' : '' }}"
                   href="{{route('transaction.category')}}" style="text-decoration: none"><i class="la la-cube mr-2"
                                                                                             style="font-size: 18px"></i><span> Category</span>
                </a>
                <a class="{{ Request::is('accounts') ? 'active' : '' }}" href="{{route('accounts.index')}}"
                   style="text-decoration: none"><i class="la la-bank mr-2"
                                                    style="font-size: 18px"></i><span> Account</span> </a>
                <a class="{{ Request::is('transactions') ? 'active' : '' }}" href="{{route('transactions.index')}}"
                   style="text-decoration: none"><i class="la la-cube mr-2" style="font-size: 18px"></i><span> Transaction</span>
                </a>
                <a class="{{ Request::is('revenue') ? 'active' : '' }}" href="{{route('revenue')}}"
                   style="text-decoration: none"><i class="la la-cube mr-2"
                                                    style="font-size: 18px"></i><span> Revenue</span> </a>
                <a class="{{ Request::is('expense') ? 'active' : '' }}" href="{{route('expense')}}"
                   style="text-decoration: none"><i class="la la-cube mr-2"
                                                    style="font-size: 18px"></i><span> Expense</span> </a>
            </li>
        </ul>

    </li>
    <li class="submenu">
        <a href="#"><i class="la la-puzzle-piece"></i> <span> Stock Managements</span> <span
                    class="menu-arrow"></span></a>

        <ul style="display: none;">

            <li><a class="{{ Request::is('inventory') ? 'active' : '' }}"
                   href="{{ route('inventory.index') }}" style="text-decoration: none"><i class="la la-bar-chart mr-2"
                                                                                          style="font-size: 18px"></i>Inventory</a>
            </li>
            <li><a class="{{ Request::is('warehouses') ? 'active' : '' }}"
                   href="{{ route('warehouses.index') }}" style="text-decoration: none"><i class="la la-building mr-2"
                                                                                           style="font-size: 18px"></i>Warehouse</a>
            </li>
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
                    <li><a class="{{ Request::is('foc/index') ? 'active' : '' }}" href="{{route('foc.index')}}"
                           style="text-decoration: none">
                            FOC Product</a></li>
                </ul>
            </li>

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
            <li class="submenu">
                <a href="#"><i class="la la-cube mr-2" style="font-size: 18px"></i><span>Supplier</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a class="{{ Request::is('suppliers') ? 'active' : '' }}" href="{{route('suppliers')}}"
                           style="text-decoration: none">All Suppliers</a></li>
                    <li><a class="{{ Request::is('customers/create') ? 'active' : '' }}"
                           href="{{route('customers.create')}}" style="text-decoration: none">
                            Supplier Create</a></li>

                </ul>
            </li>
            <li><a class="{{ Request::is('stocks') ? 'active' : '' }}"
                   href="{{ route('stocks') }}" style="text-decoration: none">Stocks</a></li>
            <li><a class="{{ Request::is('ecommerce/stock/index') ? 'active' : '' }}"
                   href="{{ route('ecommerce_stock') }}" style="text-decoration: none">E-commerce Stocks</a></li>

            <li><a class="{{ Request::is('stocks/index') ? 'active' : '' }}" href="{{route('stocks.index')}}"
                   style="text-decoration: none">Stock Transaction</a></li>
            <li><a class="{{ Request::is('stockin') ? 'active' : '' }}" href="{{route('showstockin')}}"
                   style="text-decoration: none">
                    Stock In</a></li>
            <li><a class="{{ Request::is('stockout/index') ? 'active' : '' }}"
                   href="{{ route('stock.out.index') }}" style="text-decoration: none">Stocks Out</a></li>


            <li><a class="{{ Request::is('transfer/index') ? 'active' : '' }}"
                   href="{{ route('transfer.index') }}" style="text-decoration: none"><i class="la la-exchange mr-2"
                                                                                         style="font-size: 18px"></i>Stock
                    Transfer</a></li>
            <li><a class="{{ Request::is('damage/index') ? 'active' : '' }}"
                   href="{{ route('damage.index') }}" style="text-decoration: none"><i class="la la-cube mr-2"
                                                                                       style="font-size: 18px"></i>Damage
                    Product</a></li>
        </ul>

    </li>
    <li class="submenu">
        <a href="#"><i class="la la-shopping-cart"></i> <span>Purchase</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
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

    </li>
    <li class="submenu">
        <a href="#"><i class="la la-money " style="font-size: 18px"></i><span>Bills</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li><a class="{{ Request::is('bills') ? 'active' : '' }}" href="{{route('bills.index')}}"
                   style="text-decoration: none">All Bill</a></li>
            <li><a class="{{ Request::is('bills') ? 'active' : '' }}" href="{{route('bills.create')}}"
                   style="text-decoration: none">Create</a></li>
        </ul>
    </li>
    <li class="submenu">
        <a href="#"><i class="la la-truck" style="font-size: 18px;"></i> <span>Delivery</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">

            <li><a class="{{ Request::is('deliveries') ? 'active' : '' }}"
                   href="{{ route('deliveries.index') }}" style="text-decoration: none">All Delivery</a></li>
            <li><a class="{{ Request::is('delivery/transaction') ? 'active' : '' }}"
                   href="{{ route('delivery.transaction') }}" style="text-decoration: none">Delivery Transaction</a>
            </li>

        </ul>
    </li>
    <li class="submenu">
        <a href="#"><i class="la la-cube"></i> <span>Sales</span> <span
                    class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li><a class="{{ Request::is('barcode/create') ? 'active' : '' }}"
                   href="{{ route('barcode.create') }}" style="text-decoration: none"><i class="la la-calendar mr-1"
                                                                                         style="font-size: 18px;"></i>Barcode
                    Generate</a></li>
            <li class="submenu">
                <a href="#"><i class="la la-cube mr-2" style="font-size: 18px"></i><span> Selling Price</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a class="{{ Request::is('product/price/index') ? 'active' : '' }}"
                           href="{{route('add.index')}}" style="text-decoration: none">All Price List</a></li>
                </ul>
            </li>
            <li><a class="{{ Request::is('main/customer') ? 'active' : '' }}"
                   href="{{ route('customer') }}" style="text-decoration: none"><i class="la la-calendar mr-1"
                                                                                   style="font-size: 18px;"></i>Customers</a>
            </li>
            <li><a class="{{ Request::is('selling/report') ? 'active' : '' }}"
                   href="{{ route('sale.report') }}" style="text-decoration: none"><i class="la la-calendar mr-1"
                                                                                      style="font-size: 18px;"></i>Sale
                    Report</a></li>
            <li><a class="{{ Request::is('saletargets/create') ? 'active' : '' }}"
                   href="{{ route('saletargets.create') }}" style="text-decoration: none"><i class="la la-bullseye mr-1"
                                                                                             style="font-size: 18px;"></i>
                    Add Sale Target</a></li>
            <li class="submenu">
                <a href="#"><img src="{{url(asset('img/icon_image/invoice.png'))}}" alt="" width="18px" height="18px"
                                 class="mr-1"><span> Invoice</span> <span
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
                <a href="#"><img src="{{url(asset('img/icon_image/order24.png'))}}" alt="" class="mr-1" width="18px"
                                 height="18px;"><span> Order</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a class="{{ Request::is('saleorders') ? 'active' : '' }}"
                           href="{{ route('saleorders.index') }}" style="text-decoration: none">All Orders</a></li>
                    <li><a class="{{ Request::is('saleorders/create') ? 'active' : '' }}"
                           href="{{ route('saleorders.create') }}" style="text-decoration: none">Orders Create</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="la la-cube mr-2" style="font-size: 18px"></i><span>Promotion and Discount</span>
                    <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a class="{{ Request::is('discount_promotions') ? 'active' : '' }}"
                           href="{{route('discount_promotions.index')}}" style="text-decoration: none">All Promotion and
                            Discount</a></li>
                    <li><a class="{{ Request::is('discount_promotions/create') ? 'active' : '' }}"
                           href="{{route('discount_promotions.create')}}" style="text-decoration: none">
                            Add Promotion and Discount</a></li>
                </ul>
            </li>
        </ul>
    </li>

</ul>