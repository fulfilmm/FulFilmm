
@extends('layout.mainlayout')
@section('title', 'Employee')
@section('content')

<div class="content container-fluid">

    <!-- Page Header -->
    @include('layout.partials.page-header', ['route' => 'employees', 'import' => true, 'export' => false, 'card' => true, 'list' => true])
    
    This is reporting page

</div>


@endsection
@push('scripts')
<script>
</script>
@endpush
