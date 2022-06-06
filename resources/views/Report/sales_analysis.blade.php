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
                    <h3 class="page-title">Sales Analysis </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item float-right">Sales Analysis</li>
                    </ul>
                </div>
            </div>
        </div>
        <form action="{{url('sales/analysis')}}" method="get">
            @csrf
            <div class="row">
                <div class="col-md-4 col-12 offset-md-8">
                    <div class="form-group">
                        <div class="input-group">
                            <select name="month" id="month" class="form-control">
                                @foreach($months as $key=>$val)
                                    <option value="{{$val}}" {{$val==$search_month?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-white" type="submit"><i class="la la-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
       @if(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Super Admin'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='CEO')
            <div class="row">
                <figure class="highcharts-figure my-2 col-md-12 ">
                    <div id="branch" class="border shadow"></div>
                </figure>
            </div>
           @endif
        <div class="row">
            <figure class="highcharts-figure my-2 col-md-12 ">
                <div id="region" class="border shadow"></div>
            </figure>
        </div>
        <div class="row">
            <figure class="highcharts-figure my-2 col-md-12 ">
                <div id="zone" class="border shadow"></div>
            </figure>
        </div>
        <div class="row">
            <figure class="highcharts-figure col-12">
                <div id="saleman" class="border shadow"></div>
            </figure>
        </div>
        <script>
            $(document).ready(function () {
               $('select').select2();
            });
            let colors=['#90b4a9','#54adff','#f6ffab','#800080'];
            Highcharts.chart('branch', {
                chart: {
                    type: 'column',
                    options3d: {
                        enabled: true,
                        alpha: 0,
                        beta: 0,
                        depth: 80,
                        viewDistance: 25
                    }
                },
                title: {
                    text: 'Sales Analysis By Branch'
                },
                xAxis: {
                    categories: [
                        @foreach($branch as $bh)
                            '{{$bh->name}}',
                        @endforeach
                    ],
                    title: {
                        text: null
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
                series: [
                    {
                        name: 'Total Sales',
                        data: [
                            @foreach($branch as $bh)
                            parseInt( {{$branch_sales[$bh->id]['sale']}}),
                            @endforeach
                        ]
                    }
                ]
            });
            Highcharts.chart('region', {
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
                    text: 'Sales Analysis By Region'
                },
                xAxis: {
                    categories: [
                        @foreach($region as $reg)
                            '{{$reg->name}}({{$reg->branch->name}})',
                        @endforeach
                    ],
                    title: {
                        text: null
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
                series: [
                    {
                        name: 'Total Sales',
                        data: [
                            @foreach($region as $reg)
                            parseInt( {{$region_sales[$reg->id]['sale']}}),
                            @endforeach
                        ]
                    }
                ]
            });
            Highcharts.chart('zone', {
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
                    text: 'Sales Analysis By Sales Zone'
                },
                xAxis: {
                    categories: [
                        @foreach($zone as $zon)
                            '{{$zon->name}}({{$zon->region->name}})',
                        @endforeach
                    ],
                    title: {
                        text: null
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
                series: [
                    {
                        name: 'Total Sales',
                        data: [
                            @foreach($zone as $zon)
                            parseInt( {{$zone_sales[$zon->id]['sale']}}),
                            @endforeach
                        ]
                    }
                ]
            });

            //
            Highcharts.chart('saleman', {
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
                    text: 'Sales Analysis By Sales Person'
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
                        text: 'Amount',
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
                series: [
                    {
                        name: 'Total Sales',
                        data: [
                            @foreach($employee as $emp)
                            parseInt( {{$saleman_sales[$emp->id]['sale']}}),
                            @endforeach
                        ]
                    }
                ]
            });
            //pie
        </script>
    </div>
@endsection