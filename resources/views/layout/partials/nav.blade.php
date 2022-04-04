<div class="main-wrapper">
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <!---employee menu start-->
            @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                <!--- Finance menu start -->
                @if(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Accountant'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Finance Manager'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Cashier')
                    @include('menu.finance')
                    <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                @elseif(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Super Admin' ||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='CEO'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='General Manager')
                    @include('menu.admin')
                    <!-- end of finance menu and start CEO Super Admin menu -->
                @elseif(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Stock Manager')
                    @include('menu.stock')
                    <!--end of CEO Super Admin and start Sale menu start-->
                @elseif(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Sale Manager'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Sale')
                    @include('menu.sale')
                    <!--end sale menu and start Complaint Menu -->
                @elseif(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Agent'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Customer Service Manager')
                    @include('menu.csm')
                @elseif(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name='Purchaser')
                    @include('menu.purchaser')
                    <!--end complaint menu and start Admin manager menu-->
                @elseif(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Admin Manager'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Car Driver')
                    @include('menu.adminmanager')
                @endif
            @else
                <!-- employee menu end -->
                    <!--- customer login menu start -->
                @include('menu.customerprotal')
                <!-- end of customer login menu -->
                @endif
            </div>
        </div>
    </div>
</div>