@extends('layout.mainlayout')

@section('content')
<!-- Page Header -->
{{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
@include('layout.partials.breadcrumb',['header'=>'Customer Edit Form'])
<!-- /Page Header -->
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Update Customer</h4>
            </div>
            <div class="card-body">
                <form action="{{route('customers.update',$record->id)}}" method="POST" >
                    @csrf
                    @method('put')
                    @include('customer.form')
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </button>
                </form>
                {{-- {{dd($errors->all())}} --}}
            </div>
        </div>
    </div>
</div>


@endsection
