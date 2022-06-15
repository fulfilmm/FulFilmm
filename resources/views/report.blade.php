@extends('layout.mainlayout')

@section('title', 'Dashboard')

@section('content')
    <style>
        .wrimagecard{
            margin-top: 0;
            margin-bottom: 1.5rem;
            text-align: left;
            position: relative;
            background: #fff;
            box-shadow: 12px 15px 20px 0px rgba(46,61,73,0.15);
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .wrimagecard .fa{
            position: relative;
            font-size: 70px;
        }
        .wrimagecard-topimage_header{
            padding: 20px;
            border-radius: 10px;
        }
        a.wrimagecard:hover, .wrimagecard-topimage:hover {
            box-shadow: 2px 4px 8px 0px rgba(46,61,73,0.2);
        }
        .wrimagecard-topimage a {
            width: 100%;
            height: 100%;
            display: block;
        }
        .wrimagecard-topimage_title {
            padding: 20px 24px;
            height: 80px;
            padding-bottom: 0.75rem;
            position: relative;
        }
        .wrimagecard-topimage a {
            border-bottom: none;
            text-decoration: none;
            color: #525c65;
            transition: color 0.3s ease;
        }
    </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Daily Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Dashboard
                        </li>
                        <li class="breadcrumb-item active">
                            Daily Report
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="wrimagecard wrimagecard-topimage">
                        <a href="{{url('selling/report')}}">
                            <div class="wrimagecard-topimage_header" style="background-color:rgba(187, 120, 36, 0.1) ">
                                <center><i class="fa fa-dollar" style="color:#BB7824"></i></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Sales Report</h4>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="wrimagecard wrimagecard-topimage">
                        <a href="{{route('report.income')}}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(22, 160, 133, 0.1)">
                                <center><img src="{{url(asset('img/icon_image/revenue.png.crdownload'))}}" alt="" width="70px" height="70px"></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Revenue Report
                                    <div class="pull-right badge" id="WrControls"></div></h4>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="wrimagecard wrimagecard-topimage">
                        <a href="{{route('report.inhand')}}">
                            <div class="wrimagecard-topimage_header" style="background-color:  rgba(213, 15, 37, 0.1)">
                                <center><img src="{{url(asset('img/icon_image/income.png'))}}" alt="" width="70px;" height="70px"></center>
                            </div>
                            <div class="wrimagecard-topimage_title" >
                                <h4>Income Report
                                    <div class="pull-right badge" id="WrForms"></div>
                                </h4>
                            </div>

                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="wrimagecard wrimagecard-topimage">
                        <a href="{{route('report.inemp')}}">
                            <div class="wrimagecard-topimage_header" style="background-color:  rgba(51, 105, 232, 0.1)">
                                <center><img src="{{url(asset('img/icon_image/cashinemp.webp'))}}" alt="" width="70px" height="70px"></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Cash In Transit Report
                                    <div class="pull-right badge" id="WrGridSystem"></div></h4>
                            </div>

                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="wrimagecard wrimagecard-topimage">
                        <a href="{{route('report.receivable')}}">
                            <div class="wrimagecard-topimage_header" style="background-color:  rgba(250, 188, 9, 0.1)">
                                <center><img src="{{url(asset('img/icon_image/receivable.png'))}}" alt="" width="70px" height="70px"></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Receivable Report
                                    <div class="pull-right badge" id="WrInformation"></div></h4>
                            </div>

                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="wrimagecard wrimagecard-topimage">
                        <a href="{{route('report.bill')}}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(121, 90, 71, 0.1)">
                                <center><i class="fa fa-money" style="color:#795a47"> </i></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Bill Report
                                    <div class="pull-right badge" id="WrNavigation"></div></h4>
                            </div>

                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="wrimagecard wrimagecard-topimage">
                        <a href="{{route('report.expense')}}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(130, 93, 9, 0.1)">
                                <center><i class="fa fa-credit-card-alt" style="color:#ff8482"></i></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Expenses Report
                                    <div class="pull-right badge" id="WrThemesIcons"></div></h4>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="wrimagecard wrimagecard-topimage">
                        <a href="{{route('report.payable')}}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(130, 93, 9, 0.1)">
                                <center><i class="fa fa-credit-card-alt" style="color:#fcffa9"></i></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Payable Report
                                    <div class="pull-right badge" id="WrThemesIcons"></div></h4>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="wrimagecard wrimagecard-topimage">
                        <a href="{{route('report.payment')}}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(130, 93, 9, 0.1)">
                                <center><i class="fa fa-credit-card-alt" style="color: #72ff99;"></i></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Payment Report
                                    <div class="pull-right badge" id="WrThemesIcons"></div></h4>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="wrimagecard wrimagecard-topimage">
                        <a href="{{url('stock/report')}}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(130, 93, 9, 0.1)">
                                <center><i class="fa fa-cubes" style="color:#825d09"></i></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Stock Report
                                    <div class="pull-right badge" id="WrThemesIcons"></div></h4>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="wrimagecard wrimagecard-topimage">
                        <a href="{{route('report.transfer')}}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(130, 93, 9, 0.1)">
                                <center><img src="{{url(asset('img/icon_image/stocktransfer.png'))}}" alt="" width="70px" height="70px"></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Stock Transfer Report
                                    <div class="pull-right badge" id="WrThemesIcons"></div></h4>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="wrimagecard wrimagecard-topimage">
                        <a href="{{route('report.stockin')}}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(130, 93, 9, 0.1)">
                                <center><img src="{{url(asset('img/icon_image/stockin.png'))}}" alt="" width="70px" height="70px"></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Stock In Report
                                    <div class="pull-right badge" id="WrThemesIcons"></div></h4>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="wrimagecard wrimagecard-topimage">
                        <a href="{{route('report.stockout')}}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(130, 93, 9, 0.1)">
                                <center><img src="{{url(asset('img/icon_image/stockout.png'))}}" alt="" width="70px" height="70px"></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Stock Out Report
                                    <div class="pull-right badge" id="WrThemesIcons"></div></h4>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="wrimagecard wrimagecard-topimage">
                        <a href="{{route('report.return')}}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(130, 93, 9, 0.1)">
                                <center><img src="{{url(asset('img/icon_image/stockreturn.jpg'))}}" alt="" width="70px" height="70px"></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Stock Return Report
                                    <div class="pull-right badge" id="WrThemesIcons"></div></h4>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="wrimagecard wrimagecard-topimage">
                        <a href="{{route('report.damage')}}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(130, 93, 9, 0.1)">
                                <center><img src="{{url(asset('img/icon_image/damageproduct.png'))}}" alt=""></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Damage Products Report
                                    <div class="pull-right badge" id="WrThemesIcons"></div></h4>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="wrimagecard wrimagecard-topimage">
                        <a href="{{route('report.foc')}}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(130, 93, 9, 0.1)">
                                <center><i class="fa fa-cubes" style="color:#825d09"></i></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>FOC Products Report
                                    <div class="pull-right badge" id="WrThemesIcons"></div></h4>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
