<div class="header">

    <!-- Logo -->
    <div class="header-left">
        <a href="{{url('companysettings/create')}}" class="logo">
            <img src="{{$maincompany!=null ? url(asset('/img/profiles/'.$maincompany->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}"
                 width="40" height="40" alt="">
        </a>
    </div>
    <!-- /Logo -->

    <a id="toggle_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
    </a>

    <!-- Header Title -->
    <div class="page-title-box">
        <h3>{{$maincompany->name ?? null}}</h3>
    </div>
    <!-- /Header Title -->

    <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
    <!-- Header Menu -->
    <ul class="nav user-menu">

        <!-- Search -->
        <li class="nav-item">
          @yield('search')
        </li>
        <!-- /Search -->

        <!-- Flag -->
    {{-- <li class="nav-item dropdown has-arrow flag-nav">--}}
    {{--<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">--}}
    {{--<img src="img/flags/us.png" alt="" height="20"> <span>English</span>--}}
    {{--</a>--}}
    {{--<div class="dropdown-menu dropdown-menu-right">--}}
    {{--<a href="javascript:void(0);" class="dropdown-item">--}}
    {{--<img src="img/flags/us.png" alt="" height="16"> English--}}
    {{--</a>--}}
    {{--<a href="javascript:void(0);" class="dropdown-item">--}}
    {{--<img src="img/flags/fr.png" alt="" height="16"> French--}}
    {{--</a>--}}
    {{--<a href="javascript:void(0);" class="dropdown-item">--}}
    {{--<img src="img/flags/es.png" alt="" height="16"> Spanish--}}
    {{--</a>--}}
    {{--<a href="javascript:void(0);" class="dropdown-item">--}}
    {{--<img src="img/flags/de.png" alt="" height="16"> German--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</li> --}}
    <!-- /Flag -->
        @php
            if(\Illuminate\Support\Facades\Auth::guard('employee')->check()){
            $notifications=\App\Models\Notification::with('notify_user','notifier')->where('notify_user_id',\Illuminate\Support\Facades\Auth::guard('employee')->user()->id)->where('read_at',null)->get();
            }else{
            $notifications=\App\Models\Notification::with('notify_user','notifier')->where('notify_user_id',\Illuminate\Support\Facades\Auth::guard('customer')->user()->id)->where('read_at',null)->get();}
        @endphp
       @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
            <li class="nav-item dropdown">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i> <span class="badge badge-pill">{{count($notifications)}}</span>
                </a>
                <div class="dropdown-menu notifications">
                    <div class="topnav-dropdown-header">
                        <span class="notification-title">Notifications</span>
                        {{--                <a href="javascript:void(0)" class="clear-noti"> Clear All </a>--}}
                    </div>
                    <div class="noti-content">
                        <ul class="notification-list">
                            @foreach($notifications as $alert)
                                <li class="notification-message">
                                    <a href="{{route('notifications.show',$alert->uuid)}}">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="noti-details">{{$alert->notifier->name??\Illuminate\Support\Facades\Auth::guard('employee')->user()->name}}
                                                    <span class="noti-title"> {{$alert->message}}</span></p>
                                                <p class="noti-time"><span class="notification-time">{{\Carbon\Carbon::parse($alert->created_at)->toFormattedDateString()}} at {{date('h:i a', strtotime(\Carbon\Carbon::parse($alert->created_at)))}}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="topnav-dropdown-footer">
                        <a href="{{route('notifications.index')}}">View all Notifications</a>
                    </div>
                </div>
            </li>
           @else
           @yield('noti')
           @endif
        <!-- Notifications -->
    {{-- <li class="nav-item dropdown">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i> <span class="badge badge-pill">3</span>
        </a>
        <div class="dropdown-menu notifications">
            <div class="topnav-dropdown-header">
                <span class="notification-title">Notifications</span>
                <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
            </div>
            <div class="noti-content">
                <ul class="notification-list">
                    <li class="notification-message">
                        <a href="activities">
                            <div class="media">
                                <span class="avatar">
                                    <img alt="" src="img/profiles/avatar-02.jpg">
                                </span>
                                <div class="media-body">
                                    <p class="noti-details"><span class="noti-title">John Doe</span> added new task <span class="noti-title">Patient appointment booking</span></p>
                                    <p class="noti-time"><span class="notification-time">4 mins ago</span></p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="notification-message">
                        <a href="activities">
                            <div class="media">
                                <span class="avatar">
                                    <img alt="" src="img/profiles/avatar-03.jpg">
                                </span>
                                <div class="media-body">
                                    <p class="noti-details"><span class="noti-title">Tarah Shropshire</span> changed the task name <span class="noti-title">Appointment booking with payment gateway</span></p>
                                    <p class="noti-time"><span class="notification-time">6 mins ago</span></p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="notification-message">
                        <a href="activities">
                            <div class="media">
                                <span class="avatar">
                                    <img alt="" src="img/profiles/avatar-06.jpg">
                                </span>
                                <div class="media-body">
                                    <p class="noti-details"><span class="noti-title">Misty Tison</span> added <span class="noti-title">Domenic Houston</span> and <span class="noti-title">Claire Mapes</span> to project <span class="noti-title">Doctor available module</span></p>
                                    <p class="noti-time"><span class="notification-time">8 mins ago</span></p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="notification-message">
                        <a href="activities">
                            <div class="media">
                                <span class="avatar">
                                    <img alt="" src="img/profiles/avatar-17.jpg">
                                </span>
                                <div class="media-body">
                                    <p class="noti-details"><span class="noti-title">Rolland Webber</span> completed task <span class="noti-title">Patient and Doctor video conferencing</span></p>
                                    <p class="noti-time"><span class="notification-time">12 mins ago</span></p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="notification-message">
                        <a href="activities">
                            <div class="media">
                                <span class="avatar">
                                    <img alt="" src="img/profiles/avatar-13.jpg">
                                </span>
                                <div class="media-body">
                                    <p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> added new task <span class="noti-title">Private chat module</span></p>
                                    <p class="noti-time"><span class="notification-time">2 days ago</span></p>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="topnav-dropdown-footer">
                <a href="activities">View all Notifications</a>
            </div>
        </div>
    </li> --}}
    <!-- /Notifications -->

        <!-- Message Notifications -->
    {{-- <li class="nav-item dropdown">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
            <i class="fa fa-comment-o"></i> <span class="badge badge-pill">8</span>
        </a>
        <div class="dropdown-menu notifications">
            <div class="topnav-dropdown-header">
                <span class="notification-title">Messages</span>
                <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
            </div>
            <div class="noti-content">
                <ul class="notification-list">
                    <li class="notification-message">
                        <a href="chat">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">
                                        <img alt="" src="img/profiles/avatar-09.jpg">
                                    </span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">Richard Miles </span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="notification-message">
                        <a href="chat">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">
                                        <img alt="" src="img/profiles/avatar-02.jpg">
                                    </span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">John Doe</span>
                                    <span class="message-time">6 Mar</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="notification-message">
                        <a href="chat">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">
                                        <img alt="" src="img/profiles/avatar-03.jpg">
                                    </span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author"> Tarah Shropshire </span>
                                    <span class="message-time">5 Mar</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="notification-message">
                        <a href="chat">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">
                                        <img alt="" src="img/profiles/avatar-05.jpg">
                                    </span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">Mike Litorus</span>
                                    <span class="message-time">3 Mar</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="notification-message">
                        <a href="chat">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">
                                        <img alt="" src="img/profiles/avatar-08.jpg">
                                    </span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author"> Catherine Manseau </span>
                                    <span class="message-time">27 Feb</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="topnav-dropdown-footer">
                <a href="chat">View all Messages</a>
            </div>
        </div>
    </li> --}}
    <!-- /Message Notifications -->

        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#"
               class="{{\Illuminate\Support\Facades\Auth::guard('employee')->check()?'dropdown-toggle':''}} nav-link"
               data-toggle="dropdown">
                @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                    <span class="user-img"><img
                                src="{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->profile_img?asset('img/profiles/'.\Illuminate\Support\Facades\Auth::guard('employee')->user()->profile_img):url(asset('img/profiles/avatar-21.jpg'))}}"
                                alt="" width="30px" height="30px;">
                        <span class="status online"></span></span>
                @endif
                <span>{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->name ?? \Illuminate\Support\Facades\Auth::guard('customer')->user()->name}}</span>
            </a>
            <div class="dropdown-menu">
                {{-- <a class="dropdown-item" href="profile">My Profile</a>--}}
                @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                    <a class="dropdown-item"
                       href="{{route('employees.show',\Illuminate\Support\Facades\Auth::guard('employee')->user()->id)}}">Profile</a>
                    <a class="dropdown-item" href="{{route('password.edit')}}">Change Password</a>

                    <form id="logout-form" action="{{ route('employees.logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item"> Logout</button>

                    </form>
                @else
                    <form id="logout-form" action="{{ route('customers.logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item"> Logout</button>

                    </form>
                @endif

            </div>
        </li>
    </ul>
    <!-- /Header Menu -->

    <!-- Mobile Menu -->
{{--<div class="dropdown mobile-user-menu">--}}
{{--<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i--}}
{{--class="fa fa-ellipsis-v"></i></a>--}}
{{--<div class="dropdown-menu dropdown-menu-right">--}}
{{--<a class="dropdown-item" href="">My Profile</a>--}}
{{--<a class="dropdown-item" href="">Settings</a>--}}
{{--<a class="dropdown-item" href="">Logout</a>--}}
{{--</div>--}}
{{--</div>--}}
<!-- /Mobile Menu -->

</div>
