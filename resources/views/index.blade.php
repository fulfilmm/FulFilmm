@extends('layout.mainlayout')

@section('title', 'Dashboard')

@section('content')
    <style>
        /*.highcharts-credits{*/
        /*display: none;*/
        /*}*/
    </style>
    <div class="p-3">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Welcome {{ ucfirst(\Illuminate\Support\Facades\Auth::user()->name)}}!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">{{\Illuminate\Support\Facades\Auth::user()->role->name}}
                            Dashboard
                        </li>
                    </ul>
                </div>
                @if(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Super Admin'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='CEO'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='General Manager')

                    <div class="col-12">
                        <div class="float-right">
                            <ul class="nav nav-tabs nav-tabs-solid  justify-content-center">
                                <li class="nav-item"><a class="nav-link active rounded-pill shadow-sm"  onclick="report_type(4)" href="" data-toggle="tab">Current Month</a></li>
                                <li class="nav-item"><a class="nav-link rounded-pill shadow-sm" href="" onclick="report_type(2)" data-toggle="tab">1st Half Year</a></li>
                                <li class="nav-item"><a class="nav-link rounded-pill shadow-sm" href="" onclick="report_type(3)" data-toggle="tab">2nd Half Year</a></li>
                                <li class="nav-item"><a class="nav-link rounded-pill shadow-sm" href="" onclick="report_type(1)" data-toggle="tab">Current Year</a></li>
                            </ul>
                            {{--<input type="radio" name="report_type" class="radio" value="1"><label for=""--}}
                            {{--class="ml-2">Current--}}
                            {{--Year</label>--}}
                            {{--<input type="radio" name="report_type" class="radio" value="2"><label for="" class="ml-2">Jan--}}
                            {{--to June</label>--}}
                            {{--<input type="radio" name="report_type" class="radio" value="3"><label for="" class="ml-2">July--}}
                            {{--to Dec</label>--}}
                            {{--<input type="radio" name="report_type" class="radio" value="4"checked><label for="" class="ml-2">Current--}}
                            {{--Month</label>--}}
                        </div>
                    </div>
                @endif
            </div>

        </div>
        <!-- /Page Header -->
        @if(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Customer Service Manager')
            @include('Dashboard.ticket_admin')
        @elseif(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='CEO'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Super Admin'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='General Manager')
            @include('Dashboard.ceo_admin')
        @elseif(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Agent')
            @include('Dashboard.cs_agent')
        @elseif(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Sales'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Sales Manager')
            @include('Dashboard.salemanagerandsale')
        @elseif(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Stock Manager')
            @include('Dashboard.stockmanager')
        @elseif(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Accountant'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Cashier')
            @include('Dashboard.accountantandcashier')
        @elseif(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Finance Manager')
            @include("Dashboard.financemanager")

        @else
            @include('Dashboard.normalemp_dashboard')
        @endif

    </div>
    @if(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Super Admin'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='CEO'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='General Manager')
        <script>

            var chart = Highcharts.chart('best', {

                chart: {
                    type: "column"
                },
                title: {
                    text: 'Top 10 Best Selling Products'
                },

                legend: {
                    layout: "vertical",
                    align: 'right',
                    verticalAlign: 'top',
                    x: -40,
                    y: 80,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor:
                        Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                    shadow: true
                },

                xAxis: {
                    categories: [
                        '{{$best_sell[0]['product_name']??''}}({{$best_sell[0]['variant']??'Top 1'}})',
                        '{{$best_sell[1]['product_name']??''}}({{$best_sell[1]['variant']??'Top 2'}})',
                        '{{$best_sell[2]['product_name']??''}}({{$best_sell[2]['variant']??'Top 3'}})',
                        '{{$best_sell[3]['product_name']??''}}({{$best_sell[3]['variant']??'Top 4'}})',
                        '{{$best_sell[4]['product_name']??''}}({{$best_sell[4]['variant']??'Top 5'}})',
                        '{{$best_sell[5]['product_name']??''}}({{$best_sell[5]['variant']??'Top 6'}})',
                        '{{$best_sell[6]['product_name']??''}}({{$best_sell[6]['variant']??'Top 7'}})',
                        '{{$best_sell[7]['product_name']??''}}({{$best_sell[7]['variant']??'Top 8'}})',
                        '{{$best_sell[8]['product_name']??''}}({{$best_sell[8]['variant']??'Top 9'}})',
                        '{{$best_sell[9]['product_name']??''}}({{$best_sell[9]['variant']??'Top 10'}})'
                    ],
                    labels: {
                        x:3
                    }
                },

                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: 'Quantity'
                    }

                },

                series: [{
                    name: 'Selling Quantity',
                    data: [
                        {{$best_sell[0]['qty']??0}},
                        {{$best_sell[1]['qty']??0}},
                        {{$best_sell[2]['qty']??0}},
                        {{$best_sell[3]['qty']??0}},
                        {{$best_sell[4]['qty']??0}},
                        {{$best_sell[5]['qty']??0}},
                        {{$best_sell[6]['qty']??0}},
                        {{$best_sell[7]['qty']??0}},
                        {{$best_sell[8]['qty']??0}},
                        {{$best_sell[9]['qty']??0}},

                    ],
                    crosshair: true
                },
                ],

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                align: 'center',
                                verticalAlign: 'bottom',
                                layout: 'horizontal'
                            },
                            yAxis: {
                                labels: {
                                    align: 'left',
                                    x: 0,
                                    y: -5
                                },
                                title: {
                                    text: null
                                }
                            },
                            subtitle: {
                                text: null
                            },
                            credits: {
                                enabled: false
                            }
                        }
                    }]
                }
            });
            var chart = Highcharts.chart('bad', {

                chart: {
                    type: "column"
                },
                title: {
                    text: 'Top 10 Bad Selling Products'
                },

                legend: {
                    layout: "vertical",
                    align: 'right',
                    verticalAlign: 'top',
                    x: -40,
                    y: 80,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor:
                        Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                    shadow: true
                },

                xAxis: {
                    categories: [
                        '{{$bad_sell[0]['product_name']??''}}({{$bad_sell[0]['variant']??'Top 1'}})',
                        '{{$bad_sell[1]['product_name']??''}}({{$bad_sell[1]['variant']??'Top 2'}})',
                        '{{$bad_sell[2]['product_name']??''}}({{$bad_sell[2]['variant']??'Top 3'}})',
                        '{{$bad_sell[3]['product_name']??''}}({{$bad_sell[3]['variant']??'Top 4'}})',
                        '{{$bad_sell[4]['product_name']??''}}({{$bad_sell[4]['variant']??'Top 5'}})',
                        '{{$bad_sell[5]['product_name']??''}}({{$bad_sell[5]['variant']??'Top 6'}})',
                        '{{$bad_sell[6]['product_name']??''}}({{$bad_sell[6]['variant']??'Top 7'}})',
                        '{{$bad_sell[7]['product_name']??''}}({{$bad_sell[7]['variant']??'Top 8'}})',
                        '{{$bad_sell[8]['product_name']??''}}({{$bad_sell[8]['variant']??'Top 9'}})',
                        '{{$bad_sell[9]['product_name']??''}}({{$bad_sell[9]['variant']??'Top 10'}})'
                    ],
                    labels: {
                        x:3
                    }
                },

                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: 'Quantity'
                    }

                },

                series: [{
                    name: 'Selling Quantity',
                    data: [
                        {{$bad_sell[0]['qty']??0}},
                        {{$bad_sell[1]['qty']??0}},
                        {{$bad_sell[2]['qty']??0}},
                        {{$bad_sell[3]['qty']??0}},
                        {{$bad_sell[4]['qty']??0}},
                        {{$bad_sell[5]['qty']??0}},
                        {{$bad_sell[6]['qty']??0}},
                        {{$bad_sell[7]['qty']??0}},
                        {{$bad_sell[8]['qty']??0}},
                        {{$bad_sell[9]['qty']??0}},

                    ],
                    crosshair: true
                },
                ],

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                align: 'center',
                                verticalAlign: 'bottom',
                                layout: 'horizontal'
                            },
                            yAxis: {
                                labels: {
                                    align: 'left',
                                    x: 0,
                                    y: -5
                                },
                                title: {
                                    text: null
                                }
                            },
                            subtitle: {
                                text: null
                            },
                            credits: {
                                enabled: false
                            }
                        }
                    }]
                }
            });
            var chart = Highcharts.chart('yearly', {

                chart: {
                    type: ''
                },
                title: {
                    text: 'In Flow,Out Flow and Balance'
                },

                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -40,
                    y: 80,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor:
                        Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                    shadow: true
                },
                tooltip: {
                    valueSuffix: 'MMK',
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} MMK</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    labels: {
                        x: -2
                    }
                },

                yAxis: {
                    min: 0,
                    title: {
                        text: 'Amount',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },

                series: [{
                    name: 'In Flow',
                    color: '#0f6bff',
                    data: [
                        {{$monthly_income['Jan']->total??0}},
                        {{$monthly_income['Feb']->total??0}},
                        {{$monthly_income['Mar']->total??0}},
                        {{$monthly_income['Apr']->total??0}},
                        {{$monthly_income['May']->total??0}},
                        {{$monthly_income['Jun']->total??0}},
                        {{$monthly_income['Jul']->total??0}},
                        {{$monthly_income['Aug']->total??0}},
                        {{$monthly_income['Sep']->total??0}},
                        {{$monthly_income['Oct']->total??0}},
                        {{$monthly_income['Nov']->total??0}},
                        {{$monthly_income['Dec']->total??0}}
                    ]
                }, {
                    name: 'Out Flow',
                    color:'#fe2e76',
                    data: [
                        {{$monthly_expense['Jan']->total??0}},
                        {{$monthly_expense['Feb']->total??0}},
                        {{$monthly_expense['Mar']->total??0}},
                        {{$monthly_expense['Apr']->total??0}},
                        {{$monthly_expense['May']->total??0}},
                        {{$monthly_expense['Jun']->total??0}},
                        {{$monthly_expense['Jul']->total??0}},
                        {{$monthly_expense['Aug']->total??0}},
                        {{$monthly_expense['Sep']->total??0}},
                        {{$monthly_expense['Oct']->total??0}},
                        {{$monthly_expense['Nov']->total??0}},
                        {{$monthly_expense['Dec']->total??0}},


                    ]
                }, {
                    name: 'Balance',
                    color:'#79ff18',
                    data: [
                        {{$profit['Jan']??0}},
                        {{$profit['Feb']??0}},
                        {{$profit['Mar']??0}},
                        {{$profit['Apr']??0}},
                        {{$profit['May']??0}},
                        {{$profit['Jun']??0}},
                        {{$profit['Jul']??0}},
                        {{$profit['Aug']??0}},
                        {{$profit['Sep']??0}},
                        {{$profit['Oct']??0}},
                        {{$profit['Nov']??0}},
                        {{$profit['Dec']??0}},
                    ]
                }
                ],

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                align: 'center',
                                verticalAlign: 'bottom',
                                layout: 'vertical'
                            },
                            yAxis: {
                                labels: {
                                    align: 'left',
                                    x: 0,
                                    y: -5
                                },
                                title: {
                                    text: null
                                }
                            },
                            subtitle: {
                                text: null
                            },
                            credits: {
                                enabled: false
                            }
                        }
                    }]
                }
            });
            $(document).ready(function () {
                $('#total_income').text("{{number_format($items['current_month_income'])??0}}");
                $('#total_expense').text("{{number_format($items['current_month_expense'])??0}}");
                $('#total_profit').text("{{number_format($items['current_month_profit'])??0}}");
                $('#total_bill').text("{{number_format($items['current_month_bill'])??0}}");

            });
            function report_type (val) {
                if (val == 1) {
                    $('#total_income').text("{{number_format($items['total_income'])??0}}");
                    $('#total_expense').text("{{number_format($items['total_expense'])??0}}");
                    $('#total_profit').text("{{number_format($items['profit'])??0}}");
                    $('#total_bill').text("{{number_format($items['total_bill'])??0}}");
                } else if (val == 2) {
                    $('#total_income').text("{{number_format($items['first_term_income'])??0}}");
                    $('#total_expense').text("{{number_format($items['first_term_expense'])??0}}");
                    $('#total_profit').text("{{number_format($items['first_term_profit'])??0}}");
                    $('#total_bill').text("{{number_format($items['first_term_bill'])??0}}");
                } else if (val == 3) {
                    $('#total_income').text("{{number_format($items['second_term_income'])??0}}");
                    $('#total_expense').text("{{number_format($items['second_term_expense'])??0}}");
                    $('#total_profit').text("{{number_format($items['second_term_profit'])??0}}");
                    $('#total_bill').text("{{number_format($items['second_term_bill'])??0}}");
                } else {
                    $('#total_income').text("{{number_format($items['current_month_income'])??0}}");
                    $('#total_expense').text("{{number_format($items['current_month_expense'])??0}}");
                    $('#total_profit').text("{{number_format($items['current_month_profit'])??0}}");
                    $('#total_bill').text("{{number_format($items['current_month_bill'])??0}}");
                }
            }
        </script>
    @endif
@endsection

