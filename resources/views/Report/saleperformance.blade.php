@extends('layout.mainlayout')
@section('title','Sales Performance')
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
                    <h3 class="page-title">Sales Performance </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item float-right">Sales Performance</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <figure class="highcharts-figure my-2 col-md-6 ">
                <div id="overall" class="border shadow"></div>
            </figure>
            <figure class="highcharts-figure my-2 col-md-6">
                <div id="pie" class="border shadow"></div>
            </figure>
        </div>
        <div class="row">
            <figure class="highcharts-figure col-md-4 shadow-sm">
                <div id="pie1" class="border shadow"></div>
            </figure>
            <figure class="highcharts-figure col-md-4">
                <div id="pie2" class="border shadow"></div>
            </figure>
            <figure class="highcharts-figure col-md-4">
                <div id="pie3" class="border shadow"></div>
            </figure>
        </div>
        <div class="row">
            <figure class="highcharts-figure col-12">
                <div id="container" class="border shadow"></div>
            </figure>
        </div>
        <script>
            let colors=['#90b4a9','#54adff','#f6ffab','#800080'];
            Highcharts.chart('overall', {
                chart: {
                    type: 'column',
                    options3d: {
                        enabled: true,
                        alpha: 0,
                        beta: -6,
                        depth: 50,
                        viewDistance: 25
                    }
                },
                colors:colors,
                title: {
                    text: 'Overall Sales Performance'
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
                        name: "Sales Performance",
                        colorByPoint: true,
                        data: [
                            {
                                name: "New Appointment",
                                y:parseFloat({{$data['appointment']}})

                            },
                            {
                                name: "Meeting",
                                y:parseFloat({{$data['meeting']}}),

                            },

                            {
                                name: "Proposal",
                                y:parseFloat({{$data['proposal']}}),

                            },
                            {
                                name: "Deal Win",
                                y:parseFloat({{$data['deal']}}),
                            },


                        ]
                    }
                ],
            });

            //
            Highcharts.chart('container', {
                chart: {
                    type: 'bar',
                    options3d: {
                        enabled: true,
                        alpha: 0,
                        beta: 0,
                        depth: 80,
                        viewDistance: 25
                    }
                },
                title: {
                    text: 'Sales Person Performance Compare Chart'
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
                        text: 'Count',
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
                        Highcharts.defaultOptions.legend.backgroundColor || '#dbecfd',
                    shadow: true
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Appointment',
                    data: [
                       @foreach($employee as $emp)
                        parseFloat({{$performance[$emp->id]['appointment']}}),
                        @endforeach
                    ]
                },
                    {
                        name: 'Meeting',
                        data: [
                            @foreach($employee as $emp)
                           parseInt( {{$performance[$emp->id]['meeting']}}),
                            @endforeach
                        ]
                    }
                    ,{
                    name: 'Deal',
                    data: [
                        @foreach($employee as $emp)
                        parseInt({{$performance[$emp->id]['deal']}}),
                        @endforeach
                    ]
                }, {
                    name: 'Proposal',
                    data: [
                        @foreach($employee as $emp)
                        parseInt({{$performance[$emp->id]['proposal']}}),
                        @endforeach
                    ]
                },
                ]
            });
//pie
            var pipeline=['#90b4a9','#5b9cff','#fdffa3','#800080','#72ff99','#ff0000'];
            Highcharts.chart('pie', {
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
                },
                colors:pipeline,
                title: {
                    text: 'Sales Pipeline Report'
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
                            enabled: false,
                            format: '{point.y:.0f}'
                        },
                        showInLegend: true,
                    }
                },
                series: [{
                    name: 'Percentage',
                    colorByPoint: true,
                    data: [{
                        name: 'New',
                        y:parseFloat({{$salepipeline['New']}}),
                    }, {
                        name: 'Qualified',
                        y: parseFloat({{$salepipeline['Qualified']}})
                    }, {
                        name: 'Quotation',
                        y: parseFloat({{$salepipeline['Quotation']}})
                    }, {
                        name: 'Invoicing',
                        y: parseFloat({{$salepipeline['Invoicing']}})
                    }, {
                        name: 'Win',
                        y:parseFloat({{$salepipeline['Win']}})
                    }, {
                        name: 'Lost',
                        y: parseFloat({{$salepipeline['Lost']}})
                    }
                    ]
                }]
            });
            //pie1
            var pie1colors = ['#5B9CFF','#fdb5d8'];
            Highcharts.chart('pie1', {
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
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
                            enabled: false,
                            format: '{point.percentage:.0f}%'
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Percentage',
                    colorByPoint: true,
                    data: [{
                        name: 'Qualified',
                        y: parseFloat({{$data['qualified']}}),

                    }, {
                        name: 'Leads',
                        y:parseFloat({{$data['unqualified']}})
                    },
                    ]
                }]
            });
            //pie2
            var pie2colors = ['#fdffa3','#5B9CFF'];
            Highcharts.chart('pie2', {
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
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
                            enabled: false,
                            format: '<b>{point.name}</b>: {point.percentage:.0f}%'
                        },
                        showInLegend: true,
                    }
                },
                colors:pie2colors,
                series: [{
                    name: 'Total Qualified',
                    colorByPoint: true,
                    data: [{
                        name: 'Quote',
                        y:parseFloat({{$data['quotation']}})
                    }, {
                        name: 'Qualified',
                        y:parseFloat({{$data['still_qualified']}})
                    },
                    ]
                }]
            });
            //pie3
            var pie3colors = ['#72ff99','#fdffa3','#ff0000'];
            Highcharts.chart('pie3', {

                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
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
                        depth: 35,
                        dataLabels: {
                            enabled: false,
                            format: '<b>{point.name}</b>: {point.percentage:.0f}%'
                        },
                        showInLegend: true,
                    }
                },
                series: [{
                    name: 'Total',
                    colorByPoint: true,
                    data: [ {
                        name: 'Win',
                        y:parseFloat({{$data['win']}})
                    }, {
                        name: 'Quote',
                        y: parseFloat({{$data['still_quotation']}})
                    },{
                        name:'Lost',
                        y:parseFloat({{$data['lost']}})
                    }
                    ]
                }]
            });
        </script>
    </div>
    @endsection