@php $maincompany=\App\Models\MainCompany::where('ismaincompany',true)->first(); @endphp
<!DOCTYPE html>
<html lang="en">
@include('layout.partials.head')
@yield('styles')

<body>
@if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
       @include('layout.partials.nav')
    @include('layout.partials.header')
<!-- Page Wrapper -->
<div class="page-wrapper">
        @include('layout.partials.flash-messages')
        @yield('content')`
</div>
@elseif(\Illuminate\Support\Facades\Auth::guard('customer')->check())
    @include('layout.partials.nav')
    @include('layout.partials.header')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        @include('layout.partials.flash-messages')
        @yield('content')`
    </div>
    @else
    @yield('content')
@endif

@include('layout.partials.footer-scripts')
<script>
    @yield('script')
</script>

    @stack('scripts')


</body>
</html>
