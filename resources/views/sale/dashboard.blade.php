@extends('layout.mainlayout')
@section('title','Sales Dashboard')
@section('content')
    <style>
        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

        #button-bar {
            min-width: 310px;
            max-width: 800px;
            margin: 0 auto;
        }


    </style>
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                        <li class="breadcrumb-item active">Sales Dashboard</li>

                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <form action="{{route('search.saledashboard')}}" method="GET">
        <div class="row justify-content-between">

               @if(isset($search_month))
                <div class="col">
                    <div class="form-group">
                        <a href="{{route('saletargets.index')}}" class="btn btn-primary col-12 shadow"><i class="fa fa-backward mr-3"></i>Back To Current Month</a>
                    </div>
                </div>
                   @endif

                <div class="col">
                    <div class="form-group">
                        <select name="month"  id="month" class="form-control shadow">
                            @foreach($month as $key=>$val)
                                <option value="{{$val}}"{{isset($search_month)?($search_month==$val?'selected':''):($val==date('M')?'selected':'')}}>{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <select name="year"  id="year" class="form-control shadow">
                            <option value="{{date('Y')-2}}" {{isset($searchYear)?($searchYear==date('Y')-2?'selected':''):''}}>{{date('Y')-2}}</option>
                            <option value="{{date('Y')-1}}" {{isset($searchYear)?($searchYear==date('Y')-1?'selected':''):''}}>{{date('Y')-1}}</option>
                            <option value="{{date('Y')}}" {{isset($searchYear)?($searchYear==date('Y')?'selected':''):'selected'}}>{{date('Y')}}</option>
                            <option value="{{date('Y')+1}}" {{isset($searchYear)?($searchYear==date('Y')+1?'selected':''):''}}>{{date('Y')+1}}</option>
                            <option value="{{date('Y')+2}}" {{isset($searchYear)?($searchYear==date('Y')+2?'selected':''):''}}>{{date('Y')+2}}</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary col-12 shadow">Search</button>
                    </div>
                </div>


        </div>
        </form>
        <div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
            <div class="col  my-2">
                <div class="alert-success alert mb-0 shadow">
                    <a href="{{url('saletargets/create')}}">
                        <div class="d-flex align-items-center">
                            <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-bullseye fa-lg"></i></div>
                            <div class="flex-fill ms-3 text-truncate">
                                <div class="h6 mb-0">{{isset($search_month)?$monthlysaletarget[$search_month]->target??0:$monthlysaletarget[date('M')]->target??0}}</div>
                                <span class="small">Sale Target ({{$search_month??date('M')}})</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col my-2">
                <div class="alert-info alert mb-0 shadow">
                    <a href="{{route('invoices.index')}}">
                        <div class="d-flex align-items-center">
                            <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-usd fa-lg"></i></div>
                            <div class="flex-fill ms-3 text-truncate">
                                <div class="h6 mb-0">Total Sale({{$search_month??date('M')}})</div>
                                <span class="small"> {{isset($search_month)?$monthly[$search_month]->total??0:$monthly[date('M')]->total??0}}</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col my-2">
                <div class="alert-warning alert mb-0 shadow">
                    <a href="{{route('invoices.index')}}">
                        <div class="d-flex align-items-center">
                            <div class="avatar rounded no-thumbnail bg-warning text-light shadow"><i class="fa fa-money fa-lg"></i></div>
                            <div class="flex-fill ms-3 text-truncate">
                                <div class="h6 mb-0">Cost Of Sale({{$search_month??date('M')}})</div>
                                <span class="small">{{isset($search_month)?$cos[$search_month]??0:$cos[date('M')]??0}}</span>
                            </div>
                            {{--@dd($search_month)--}}
                        </div>
                    </a>
                </div>
            </div>
            <div class="col my-2">
                <div class="alert-white alert mb-0 shadow">
                    <a href="{{route('invoices.index')}}">
                        <div class="d-flex align-items-center">
                            <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-credit-card" aria-hidden="true"></i></div>
                            <div class="flex-fill ms-3 text-truncate">
                                <div class="h6 mb-0">Gross Profit</div>
                                <span class="small">{{isset($search_month)?$gp[$search_month]:$gp[date('M')]}}</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col my-2">
                <div class="alert-danger alert mb-0 shadow">
                    <a href="{{route('invoices.index')}}">
                        <div class="d-flex align-items-center">
                            <div class="avatar rounded no-thumbnail bg-danger text-light shadow"><i class="fa fa-credit-card" aria-hidden="true"></i></div>
                            <div class="flex-fill ms-3 text-truncate">
                                <div class="h6 mb-0">Payable</div>
                                <span class="small">{{isset($search_month)?$payable[$search_month]:$payable[date('M')]??0}}</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col my-2">
                <div class="alert-info alert mb-0 shadow">
                    <a href="{{route('invoices.index')}}">
                        <div class="d-flex align-items-center">
                            <div class="avatar rounded no-thumbnail bg-purple text-light shadow"><i class="fa fa-credit-card" aria-hidden="true"></i></div>
                            <div class="flex-fill ms-3 text-truncate">
                                <div class="h6 mb-0">Receivable</div>
                                <span class="small">{{isset($search_month)?$receivable[$search_month]:$receivable[date('M')]}}</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <div class="card shadow">

                            <figure class="highcharts-figure my-2">
                                <div id="monthly"></div>

                            </figure>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="card shadow">
                            <figure class="highcharts-figure my-2">
                                <div id="yearly"></div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
{{--@dd($year[0])--}}
    <script>
        $(document).ready(function () {
            $(document).ready(function () {
                $('select').select2();
            });
        });
    </script>
    <script>
        var monthly=$("input[name='monthly'] option:checked").val();
        var chart = Highcharts.chart('monthly', {

            chart: {
                type: "column"
            },
            title: {
                text: '{{$searchYear??date('Y')}} Monthly Sale and Target '
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
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                labels: {
                    x:3
                }
            },

            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Amount'
                }

            },

            series: [{
                name: 'Sales Target',
                data: [
                    {{$monthlysaletarget['Jan']->target??0}},
                    {{$monthlysaletarget['Feb']->target??0}},
                    {{$monthlysaletarget['Mar']->target??0}},
                    {{$monthlysaletarget['Apr']->target??0}},
                    {{$monthlysaletarget['May']->target??0}},
                    {{$monthlysaletarget['Jun']->target??0}},
                    {{$monthlysaletarget['Jul']->target??0}},
                    {{$monthlysaletarget['Aug']->target??0}},
                    {{$monthlysaletarget['Sep']->target??0}},
                    {{$monthlysaletarget['Oct']->target??0}},
                    {{$monthlysaletarget['Nov']->target??0}},
                    {{$monthlysaletarget['Dec']->target??0}}
                ],
                crosshair: true
            }, {
                name: 'Total Sales',
                data: [
                    {{$monthly['Jan']->total??0}},
                    {{$monthly['Feb']->total??0}},
                    {{$monthly['Mar']->total??0}},
                    {{$monthly['Apr']->total??0}},
                    {{$monthly['May']->total??0}},
                    {{$monthly['Jun']->total??0}},
                    {{$monthly['Jul']->total??0}},
                    {{$monthly['Aug']->total??0}},
                    {{$monthly['Sep']->total??0}},
                    {{$monthly['Oct']->total??0}},
                    {{$monthly['Nov']->total??0}},
                    {{$monthly['Dec']->total??0}}
                ]
            },
                {
                    name: 'Cost Of Sales',
                    data: [
                        {{$cos['Jan']??0}},
                        {{$cos['Feb']??0}},
                        {{$cos['Mar']??0}},
                        {{$cos['Apr']??0}},
                        {{$cos['May']??0}},
                        {{$cos['Jun']??0}},
                        {{$cos['Jul']??0}},
                        {{$cos['Aug']??0}},
                        {{$cos['Sep']??0}},
                        {{$cos['Oct']??0}},
                        {{$cos['Nov']??0}},
                        {{$cos['Dec']??0}}
                    ]
                },
                {
                    name: 'Gross Profit',
                    data: [
                        {{$gp['Jan']??0}},
                        {{$gp['Feb']??0}},
                        {{$gp['Mar']??0}},
                        {{$gp['Apr']??0}},
                        {{$gp['May']??0}},
                        {{$gp['Jun']??0}},
                        {{$gp['Jul']??0}},
                        {{$gp['Aug']??0}},
                        {{$gp['Sep']??0}},
                        {{$gp['Oct']??0}},
                        {{$gp['Nov']??0}},
                        {{$gp['Dec']??0}}
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
                text: 'Yearly Sales and Target'
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
                categories: [{{$year[0]}}, '{{$year[1]}}', '{{$year[2]}}', '{{$year[3]}}', '{{$year[4]}}'],
                labels: {
                    x:-2
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
                name: 'Sales Target',
                data: [
                    {{$yearly_target[$year[0]]->target??0}},
                    {{$yearly_target[$year[1]]->target??0}},
                    {{$yearly_target[$year[2]]->target??0}},
                    {{$yearly_target[$year[3]]->target??0}},
                    {{$yearly_target[$year[4]]->target??0}}

                ]
            }, {
                name: 'Total Sales',
                data: [
                    {{$yearly[$year[0]]->total??0}},
                    {{$yearly[$year[1]]->total??0}},
                    {{$yearly[$year[2]]->total??0}},
                    {{$yearly[$year[3]]->total??0}},
                    {{$yearly[$year[4]]->total??0}}

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


    </script>
    <!-- /Page Wrapper -->
@endsection