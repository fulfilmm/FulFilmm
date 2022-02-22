@extends('layout.mainlayout')
@section('title','Sale Performance')
@section('content')
    <style>
        .highcharts-figure, .highcharts-data-table table {
            min-height: 400px;
            margin: 1em auto;
        }

        #container {
            height: 1000px;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #EBEBEB;
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
        .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
            padding: 0.5em;
        }
        .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }
        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }
    </style>
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Sale Performance </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item float-right">Expense Claim</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <figure class="highcharts-figure my-2 col-md-6">
                <div id="overall"></div>
            </figure>
            <figure class="highcharts-figure my-2 col-md-6">
                <div id="pie"></div>
            </figure>
        </div>
        <div class="row">
            <figure class="highcharts-figure col-md-4">
                <div id="pie1"></div>
            </figure>
            <figure class="highcharts-figure col-md-4">
                <div id="pie2"></div>
            </figure>
            <figure class="highcharts-figure col-md-4">
                <div id="pie3"></div>
            </figure>
        </div>
        <div class="row">
            <figure class="highcharts-figure col-12">
                <div id="container"></div>
            </figure>
        </div>
        <script>

            Highcharts.chart('overall', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Overall Sale Performance'
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: ''
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.0f}'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:0f}</b> of total<br/>'
                },

                series: [
                    {
                        name: "Sale Performance",
                        colorByPoint: true,
                        data: [
                            {
                                name: "New Appointment",
                                y:'{{$data['appointment']}}'

                            },
                            {
                                name: "Meeting",
                                y:'{{$data['meeting']}}',

                            },

                            {
                                name: "Proposal",
                                y:'{{$data['proposal']}}',

                            },
                            {
                                name: "Deal Win",
                                y:'{{$data['deal']}}',
                            },


                        ]
                    }
                ],
            });

            //
            Highcharts.chart('container', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Sale Person Performance Compare Chart'
                },
                xAxis: {
                    categories: [
                        @foreach($employee as $emp)
                            '{{$emp->name}}',
                        @endforeach
                    ],
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Population (millions)',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                tooltip: {
                    valueSuffix: ' millions'
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
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
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Appointment',
                    data: [
                       @foreach($employee as $emp)
                        {{$performance[$emp->id]['appointment']}},
                        @endforeach
                    ]
                },
                    {
                        name: 'Meeting',
                        data: [
                            @foreach($employee as $emp)
                            {{$performance[$emp->id]['meeting']}},
                            @endforeach
                        ]
                    }
                    ,{
                    name: 'Deal',
                    data: [
                        @foreach($employee as $emp)
                        {{$performance[$emp->id]['deal']}},
                        @endforeach
                    ]
                }, {
                    name: 'Proposal',
                    data: [
                        @foreach($employee as $emp)
                        {{$performance[$emp->id]['proposal']}},
                        @endforeach
                    ]
                },
                ]
            });
//pie
            var pipeline=['#989b9e','#000fff','#ffd84d','#800080','#24e832','#ff0000'];
            Highcharts.chart('pie', {
                chart: {
                    plotBackgroundColor: pipeline,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                colors:pipeline,
                title: {
                    text: 'Sale Pipeline Report'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '0'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y:.0f}'
                        }
                    }
                },
                series: [{
                    name: 'Percentage',
                    colorByPoint: true,
                    data: [{
                        name: 'New',
                        y:'{{$salepipeline['New']}}',
                    }, {
                        name: 'Qualified',
                        y: '{{$salepipeline['Qualified']}}'
                    }, {
                        name: 'Quotation',
                        y: '{{$salepipeline['Quotation']}}'
                    }, {
                        name: 'Invoicing',
                        y: '{{$salepipeline['Invoicing']}}'
                    }, {
                        name: 'Win',
                        y: '{{$salepipeline['Win']}}'
                    }, {
                        name: 'Lost',
                        y: '{{$salepipeline['Lost']}}'
                    }
                    ]
                }]
            });
            //pie1
            var pie1colors = ['#000fff','#989b9e'];
            Highcharts.chart('pie1', {
                chart: {
                    plotBackgroundColor: pie1colors,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                colors:pie1colors,
                title: {
                    text: 'Lead To Qualified'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '0'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.0f}%'
                        }
                    }
                },
                series: [{
                    name: 'Percentage',
                    colorByPoint: true,
                    data: [{
                        name: 'Qualified',
                        y: '{{$data['qualified']}}',

                    }, {
                        name: 'Leads',
                        y:'{{$data['unqualified']}}'
                    },
                    ]
                }]
            });
            //pie2
            var pie2colors = ['#ffd84d','#000fff'];
            Highcharts.chart('pie2', {
                chart: {
                    plotBackgroundColor: pie2colors,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Qualified to Quotation'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '0'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.0f}%'
                        }
                    }
                },
                colors:pie2colors,
                series: [{
                    name: 'Total Qualified',
                    colorByPoint: true,
                    data: [{
                        name: 'Quote',
                        y:{{$data['quotation']}}
                    }, {
                        name: 'Qualified',
                        y:{{$data['still_qualified']}}
                    },
                    ]
                }]
            });
            //pie3
            var pie3colors = ['#24e832','#ffd84d','#ff0000'];
            Highcharts.chart('pie3', {

                chart: {
                    plotBackgroundColor: pie3colors,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                colors:pie3colors,

                title: {
                    text: 'Quote to Win or Lost'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y:.0f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '0'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.0f}%'
                        }
                    }
                },
                series: [{
                    name: 'Total',
                    colorByPoint: true,
                    data: [ {
                        name: 'Win',
                        y: {{$data['win']}}
                    }, {
                        name: 'Quote',
                        y: {{$data['still_quotation']}}
                    },{
                        name:'Lost',
                        y:{{$data['lost']}}
                    }
                    ]
                }]
            });
        </script>
    </div>
    @endsection