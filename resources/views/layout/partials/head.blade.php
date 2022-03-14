<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="FullFill Business Suite">
        {{--<meta http-equiv="refresh" content="5" >--}}
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="FullFill ">
        <meta name="robots" content="noindex, nofollow">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{url(asset('img/favicon.png'))}}">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{url(asset("css/bootstrap.min.css"))}}">
        <link rel="stylesheet" href="{{asset("css/select2.min.css")}}">
        

        <!--------------------- Vue Link ----------------------->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="{{ mix('js/app.js') }}" defer></script>

        <!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{url(asset("/css/font-awesome.min.css"))}}">

        <!-- Lineawesome CSS -->
        <link rel="stylesheet" href="{{url("css/line-awesome.min.css")}}">

        <!-- Select2 CSS -->


        <!-- Datetimepicker CSS -->
        <link rel="stylesheet" href="{{url(asset("css/bootstrap-datetimepicker.min.css"))}}">

        <!-- Calendar CSS -->
        <link rel="stylesheet" href="{{url(asset("css/fullcalendar.min.css"))}}">

        <!-- Tagsinput CSS -->
        <link rel="stylesheet" href="{{url(asset("plugins/bootstrap-tagsinput/bootstrap-tagsinput.css"))}}">

        <!-- Datatable CSS -->
        <link rel="stylesheet" href="{{url(asset("css/dataTables.bootstrap4.min.css"))}}">

        <!-- Chart CSS -->
        <link rel="stylesheet" href="{{url(asset("plugins/morris/morris.css"))}}">
        <link rel="stylesheet" href="{{url(asset('css/offcavas.css'))}}">
        <!-- Summernote CSS -->
        <link rel="stylesheet" href="{{url(asset("plugins/summernote/dist/summernote-bs4.css"))}}">

        <link rel="stylesheet" href="{{url(asset('css/jquery_ui.css'))}}">
        <link rel="stylesheet" href="{{url(asset('css/jquery.datetimepicker.css'))}}">
        <link rel="stylesheet" href="{{url(asset('css/exportcss/buttons.dataTables.min.css'))}}">

        {{--<!-- Main CSS -->--}}
        @php
            $active_theme=\App\Models\ThemeSetting::where('active',1)->first();
        @endphp
        <link rel="stylesheet" href="{{url(asset("css/theme/$active_theme->link"))}}">
        <script src="{{url(asset("js/jquery-3.2.1.min.js"))}}"></script>
        <script src="{{asset('/js/ckeditor.js')}}"></script>
        <script src="{{url(asset('js/http_cdnjs.cloudflare.com_ajax_libs_Chart.js_2.7.3_Chart.js'))}}"></script>

        <script src="{{url(asset('js/http_code.highcharts.com_highcharts.src.js'))}}"></script>

        <script src="{{url(asset('js/chart_exporting.js'))}}"></script>
        <script src="{{url(asset('js/http_code.highcharts.com_modules_export-data.js'))}}"></script>
        {{--<style>--}}
            {{--svg{--}}
                {{--height: 20px;--}}
            {{--}--}}

        {{--</style>--}}
        <script type="text/javascript" src="{{url(asset('js/barcodegenerator/jquery-barcode.js'))}}"></script>
        <script type="text/javascript" src="{{url(asset('js/barcodegenerator/jquery-barcode.min.js'))}}"></script>
        {{--<script type="text/javascript">--}}

            {{--function generateBarcode(){--}}
                {{--var value =$('#product_code').val();--}}
                {{--var btype ='std25';--}}
                {{--var renderer ='css';--}}


                {{--var settings = {--}}
                    {{--output:renderer,--}}
                    {{--bgColor: '#FFFFFF',--}}
                    {{--color: '#000000',--}}
                    {{--barWidth: '1',--}}
                    {{--barHeight: '50',--}}
                    {{--moduleSize: '5',--}}
                    {{--posX: '10',--}}
                    {{--posY: '20',--}}
                    {{--addQuietZone: '1'--}}
                {{--};--}}

                {{--if (renderer == 'canvas'){--}}
                    {{--clearCanvas();--}}
                    {{--$("#barcodeTarget").hide();--}}
                    {{--$("#canvasTarget").show().barcode(value, btype, settings);--}}
                {{--} else {--}}
                    {{--$("#canvasTarget").hide();--}}
                    {{--$("#barcodeTarget").html("").show().barcode(value, btype, settings);--}}
                {{--}--}}
            {{--}--}}

            {{--function showConfig1D(){--}}
                {{--$('.config .barcode1D').show();--}}
                {{--$('.config .barcode2D').hide();--}}
            {{--}--}}

            {{--function showConfig2D(){--}}
                {{--$('.config .barcode1D').hide();--}}
                {{--$('.config .barcode2D').show();--}}
            {{--}--}}

            {{--function clearCanvas(){--}}
                {{--var canvas = $('#canvasTarget').get(0);--}}
                {{--var ctx = canvas.getContext('2d');--}}
                {{--ctx.lineWidth = 1;--}}
                {{--ctx.lineCap = 'butt';--}}
                {{--ctx.fillStyle = '#FFFFFF';--}}
                {{--ctx.strokeStyle  = '#000000';--}}
                {{--ctx.clearRect (0, 0, canvas.width, canvas.height);--}}
                {{--ctx.strokeRect (0, 0, canvas.width, canvas.height);--}}
            {{--}--}}

            {{--$(function(){--}}
                {{--$('input[name=btype]').click(function(){--}}
                    {{--if ($(this).attr('id') == 'datamatrix') showConfig2D(); else showConfig1D();--}}
                {{--});--}}
                {{--$('input[name=renderer]').click(function(){--}}
                    {{--if ($(this).attr('id') == 'canvas') $('#miscCanvas').show(); else $('#miscCanvas').hide();--}}
                {{--});--}}
                {{--generateBarcode();--}}
            {{--});--}}

        {{--</script>--}}
        <link rel="stylesheet" href="{{url(asset('css/mdtimepicker.css'))}}">
        {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>--}}
        <style>
            body,head,header,h3,.card-title{
                font-family: 'Inter';
            }
            a{
                text-decoration: none;
            }
        </style>
    </head>
