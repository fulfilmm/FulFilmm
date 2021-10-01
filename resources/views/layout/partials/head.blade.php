<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{url(asset('img/favicon.png'))}}">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{url(asset("css/bootstrap.min.css"))}}">

        <!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{url(asset("/css/font-awesome.min.css"))}}">

        <!-- Lineawesome CSS -->
        <link rel="stylesheet" href="{{url("css/line-awesome.min.css")}}">

        <!-- Select2 CSS -->
        <link rel="stylesheet" href="{{asset("css/select2.min.css")}}">

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
        {{--<!-- Main CSS -->--}}
        <link rel="stylesheet" href="{{url(asset("css/style.css"))}}">
        <script src="{{url(asset("js/jquery-3.2.1.min.js"))}}"></script>
        {{--<script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>--}}
        <script src="{{asset('/js/ckeditor.js')}}"></script>


    </head>
