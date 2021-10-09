<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
@php $maincompany=\App\Models\MainCompany::where('ismaincompany',true)->first(); @endphp
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="HtWrBN54J4Hvm3aUZ2DJ5I279HPiAermNf8yTUDS">
    <meta name="description" content="Rose Billing">

    <title>Standard Invoices</title>
    {{--<link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">--}}
    <link rel="shortcut icon" type="image/x-icon"
          href="{{$maincompany!=null ? url(asset('/img/profiles/'.$maincompany->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}">
    <!-- BEGIN: Vendor CSS-->
    <link media="all" type="text/css" rel="stylesheet"
          href="http://rose.localhost/focus/app_end-ltr.css?id=192844a53499763dfa62">
    <link media="all" type="text/css" rel="stylesheet" href="http://rose.localhost/core/app-assets/css-ltr/core/menu/menu-types/vertical-menu-modern.css">
    <!-- END: Vendor CSS-->
    <link rel="stylesheet" href="{{url(asset('css/font-awesome.min.css'))}}">

    <!-- BEGIN: Custom CSS-->
    <link media="all" type="text/css" rel="stylesheet" href="http://rose.localhost/core/assets/css/style-ltr.css">
    <!-- END: Custom CSS-->
    <meta name="d_unit" content="Default Unit">
    <script src="{{url(asset("js/jquery-3.2.1.min.js"))}}"></script>
</head>
<body class="vertical-layout vertical-menu-modern 2-columns   fixed-navbar" data-open="click"
      data-menu="vertical-menu-modern" data-col="2-columns">
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header border-bottom">
            <ul class="nav navbar-nav flex-row ">
                <li class="nav-item mobile-menu d-lg-none mr-auto">
                    <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="fa fa-bars font-large-1"></i></a></li>
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="https://suite.ultimatekode.com/crm/invoices">
                        <img src="{{$maincompany!=null ? url(asset('/img/profiles/'.$maincompany->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}" class="avatar-50" style="max-height:30px;max-width: 40px">
                        <h6 class="brand-text">{{$maincompany!=null?$maincompany->name:''}}</h6>
                    </a>
                    </li>

                <li class="nav-item d-lg-none"><a class="nav-link open-navbar-container" data-toggle="collapse"
                                                  data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">

                    {{--<li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i--}}
                    {{--class="fa fa-window-maximize"></i> <i class="fa fa-window-minimize"></i></a></li>--}}
                    {{--<li class="dropdown">--}}
                    {{--<a href="#" class="nav-link " data-toggle="dropdown" role="button"--}}
                    {{--aria-expanded="false">--}}
                    {{--<i class="ficon ft-toggle-left"></i> </a>--}}
                    {{--<ul class="dropdown-menu lang-menu" role="menu">--}}
                    {{--<li class="dropdown-item"><a href="http://rose.localhost/dir/ltr"><i--}}
                    {{--class="ficon ft-layout"></i> LTR</a></li>--}}
                    {{--<li class="dropdown-item"><a href="http://rose.localhost/dir/rtl"><i--}}
                    {{--class="ficon ft-layout"></i> RTL</a></li>--}}
                    {{--</ul>--}}


                    {{--</li>--}}
                </ul>
                <ul class="nav navbar-nav float-right">

                    @yield('cart')
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <span class="avatar avatar-online"><img src=""><i></i></span>
                            <span class="user-name">Walk In</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                                                          href="http://rose.localhost/crm/user/profile"><i
                                        class="fa fa-user"></i> Edit Profile</a>
                            <div class="dropdown-divider"></div>
                            <form id="logout-form" action="{{route('customers.logout')}}" method="POST">
                                @csrf
                                <button class="dropdown-item"><i
                                            class="fa fa-power-off"></i> Logout
                                </button>

                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>


    </div>
</nav>
<!-- END: Header-->


<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            {{--<li class="navigation-header  text-center mb-2"><span class="white">Customer Panel</span>--}}
            {{--<div class="mt-2"></div>--}}
            {{--<img src="http://localhost/rose_billing_3/5.files_to_upload/storage/app/public/img/customer/example.png"--}}
            {{--class="avatar-100"></li>--}}
            <li class=" nav-item"><a href="{{url('customer/home')}}"
                                     class="menu-item  active"><i
                            class="fa fa-home"></i><span class="menu-title">Home</span></a>

            </li>

            <li class=" nav-item"><a href="{{route('customer.invoice')}}"
                                     class="menu-item  "><img src="{{url(asset('img/icon_image/invoice.png'))}}" alt=""
                                                              width="24px" height="24px" class="mr-1"><span
                            class="menu-title">Invoices</span></a>

            </li>


            <li class=" nav-item"><a href="{{route('customer.quotation')}}"
                                     class="menu-item "><img src="{{url(asset('img/icon_image/quotation.png'))}}" alt=""
                                                             class="mr-1"><span class="menu-title">Quote</span></a>

            </li>

            <li class=" nav-item"><a href="{{route('orders.index')}}"
                                     class="menu-item "><img src="{{url(asset('img/icon_image/order24.png'))}}" alt=""
                                                             class="mr-1"><span class="menu-title">Order</span></a>

            </li>

            <li class=" nav-item"><a href="{{route('request_tickets.create')}}"
                                     class="menu-item "><img src="{{url(asset('img/icon_image/complaint.png'))}}" alt=""
                                                             class="mr-1"><span class="menu-title">Complain</span></a>

            </li>


        </ul>
    </div>
</div>
<div class="app-content content">

    <div id="c_body"></div>
    <div class="">
        <div class="content-wrapper">
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script src="{{url(asset('js/customerprotal_js/app.js'))}}"></script>

</body>
</html>
