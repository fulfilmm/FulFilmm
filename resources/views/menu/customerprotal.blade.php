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
    <li class="submenu">
        <a href="{{ route('deliveries.index') }}"><i class="la la-file-text mr-2" style="font-size: 18px;"></i>Order<span class="menu-arrow"></span></a>
        <ul style="display: none;">
        <li> <a class="{{ Request::is('saleorders') ? 'active' : '' }}"
           href="{{ route('orders.index') }}" style="text-decoration: none"><i class="la la-cube mr-2" style="font-size: 18px"></i> All Orders</a></li>
            <li>
                <a class="{{Request::is('orders/create')}}" href="{{route('orders.create')}}">
                   <i class="la la-cube mr-2" style="font-size: 18px;"></i> Post Order
                </a>
            </li>
        </ul>
    </li>
    <li class="submenu">
        <a href="{{ route('deliveries.index') }}"><i class="la la-truck mr-2" style="font-size: 18px;"></i>Delivery<span class="menu-arrow"></span></a>
        <ul style="display: none;">

            <li><a class="{{ Request::is('deliveries') ? 'active' : '' }}"
                   href="{{ route('deliveries.index') }}" style="text-decoration: none">All Delivery</a></li>
            <li><a class="{{ Request::is('delivery/transaction') ? 'active' : '' }}"
                   href="{{ route('delivery.transaction') }}" style="text-decoration: none">Delivery Transaction</a></li>

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