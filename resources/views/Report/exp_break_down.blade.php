@extends('layout.mainlayout')
@section('title','Expense Breakdown')
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
                <h3 class="page-title">Expense Break Down</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                    <li class="breadcrumb-item float-right">Expense Break Down</li>
                </ul>
            </div>
        </div>
    </div>
        <div class="col-12 my-3">
            <figure class="highcharts-figure my-5 col-md-12" style="height: 500px;">
                <div id="pie" class="border shadow"></div>
            </figure>
        </div>
        <script>
            // var pipeline=['#90b4a9','#5b9cff','#fdffa3','#800080','#72ff99','#ff0000'];
            Highcharts.chart('pie', {
                chart: {
                    type: 'pie',
                },
                // colors:pipeline,
                title: {
                    text: 'Expenses Break Down'
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
                            format: '{point.y:.0f}'
                        },
                        showInLegend: true,
                    }
                },
                series: [{
                    name: 'Percentage',
                    colorByPoint: true,
                    data: [
                        @foreach($expense as $key=>$val)
{{--                            @dd($key,$val)--}}
                        {
                        name: "{{$key}} ( {{$val??0}} MMK )",
                        y:parseFloat({{$val}})
                    },
                    @endforeach
                    ]
                }]
            });
        </script>
    </div>
    @endsection