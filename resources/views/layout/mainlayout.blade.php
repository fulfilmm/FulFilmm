<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.partials.head')
    @yield('styles')
</head>

<body>

    @include('layout.partials.nav')

    @include('layout.partials.header')

    @yield('content')

    @include('layout.partials.footer-scripts')

    @stack('scripts')


</body>
</html>
