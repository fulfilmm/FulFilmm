@php $maincompany=\App\Models\MainCompany::where('ismaincompany',true)->first(); @endphp
<!DOCTYPE html>
<html lang="en">
<head>

    @include('layout.partials.head')
    @yield('styles')
</head>

<body>
@if(\Illuminate\Support\Facades\Auth::check())
    @include('layout.partials.nav')

    @include('layout.partials.header')
<!-- Page Wrapper -->
<div class="page-wrapper">
        @include('layout.partials.flash-messages')
        @yield('content')`
</div>
@else
    @yield('content')`
@endif
    @include('layout.partials.footer-scripts')

    @stack('scripts')


</body>
</html>
