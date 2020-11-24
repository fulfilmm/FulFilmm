

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
                    <h3 class="page-title">Company Create/Edit</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Companies</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Company</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('companies.store')}}" method="POST" >
                            @csrf
                            @include('forms.dynamic-input',['name'=>'name', 'title'=>'Name', 'required' =>true])
                            @include('forms.dynamic-input',['name'=>'address', 'title'=>'Address', 'required' =>true])
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">Business Type</label>
                                <div class="col-md-10" id="business_type" name="business_type">
                                    <select name="business_type" class="form-control">
                                            <option value="tech">Tech</option>
                                    </select>
                                </div>
                            </div>

                            @include('forms.dynamic-input',['name'=>'phone', 'title'=>'Phone', 'type' => 'number', 'required' =>true])
                            @include('forms.dynamic-input',['name'=>'mission', 'title'=>'Mission'])
                            @include('forms.dynamic-input',['name'=>'vision', 'title'=>'Vision'])
                            @include('forms.dynamic-input',['name'=>'email', 'title'=>'Email', 'type' => 'email'])
                            @include('forms.dynamic-input',['name'=>'ceo_name', 'title'=>'CEO name'])
                            @include('forms.dynamic-input',['name'=>'web_link', 'title'=>'Web link'])
                            @include('forms.dynamic-input',['name'=>'linkedin', 'title'=>'Linkedin'])
                            @include('forms.dynamic-input',['name'=>'facebook_page', 'title'=>'Facebook Page'])
                            @include('forms.dynamic-input',['name'=>'company_registry', 'title'=>'Company Registry'])
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">Parent Company</label>
                                <div class="col-md-10" id="parent_company" name="parent_company">
                                    <select name="parent_company" class="form-control">
                                            <option value="1">Banana</option>
                                            <option value="2">Apple</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">Parent Company 2</label>
                                <div class="col-md-10" id="parent_company_2" name="parent_company_2">
                                    <select name="parent_company_2" class="form-control">
                                            <option value="1">Banana</option>
                                            <option value="2">Apple</option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </button>
                        </form>
                        {{-- {{dd($errors->all())}} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
@endsection




