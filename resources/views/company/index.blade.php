@extends('layout.mainlayout')
@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Welcome Admin!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Companies</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->


        {{-- Content Start --}}
        {{-- သင်ရေးလိုသမျှဒီထဲတွင်ရေးနိုင်ပါသည်။ --}}

        Hello world!

        {{-- Content End --}}


    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
@endsection

