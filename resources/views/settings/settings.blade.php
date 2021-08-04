@extends('layout.mainlayout')
@section('title', 'Settings')
@section('content')

    <div class="content container-fluid">
    <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col">
                    @include('layout.partials.breadcrumb',['header'=>'Settings'])
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                  <h4>Upload profile</h4>
                  <form action="{{route('settings.profile-update')}}" class="form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <x-forms.basic.input type='file' name="file" value='' name="file" title="Image" required></x-forms.basic.input>
                    <button class="btn btn-primary">Change profile</button>

                  </form>
                </div>
            </div>
        </div>

    </div>


@endsection
@push('scripts')
    <script></script>
@endpush
