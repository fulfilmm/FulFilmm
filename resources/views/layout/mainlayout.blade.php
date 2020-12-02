<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.partials.head')
    @yield('styles')
</head>

<body>

    @include('layout.partials.nav')

    @include('layout.partials.header')
<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">
        @include('layout.partials.flash-messages')
        @yield('content')
    </div>
</div>

    @include('layout.partials.footer-scripts')

    @stack('scripts')


</body>
</html>
