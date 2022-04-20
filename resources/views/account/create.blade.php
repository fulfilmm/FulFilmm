@extends('layout.mainlayout')
@section('title','Account')
@section('content')
    <div class="container-fluid content-layout mt--6">
        <div class="page-header mt-2">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Account</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Account</li>
                        <li class="breadcrumb-item active">Create</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <form method="POST" action="{{route('accounts.store')}}">
                @csrf
                <input type="hidden" name="company_id" value="{{$company->id??''}}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no">Account Number</label>
                                <input type="text" class="form-control" name="account_id" placeholder="Enter Account No." value="{{old('account_id')}}" required>
                                @error('account_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-6 required">
                            <label for="name" class="form-control-label">Name</label>
                            <div class="input-group input-group-merge ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-font"></i>
                                    </span>
                                </div>
                                <input data-name="name" placeholder="Enter Name" required="required" name="name" type="text" id="name" class="form-control" value="{{old('name')}}">
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div> <!---->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="branch">Office Branch</label>
                                <select name="branch_id" id="branch" class="form-control">
                                    @foreach($branch as $key=>$val)
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6 required">
                            <label for="number" class="form-control-label">Bank Account Number</label>
                            <div class="input-group input-group-merge ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                </div>
                                <input data-name="number" placeholder="Enter Bank Account Number" required="required" name="number" type="text" id="number" class="form-control" value="{{old('number')}}">
                                @error('number')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div> <!---->
                        </div>
                        <div class="form-group col-md-6 required">
                            <label class="form-control-label">Currency</label>
                            <select name="currency" id="currency" class="form-control select">
                                <option value="MMK" {{old('currency')=="MMK"?'selected':''}}>Kyat</option>
                                <option value="USD" {{old('currency')=='USD'?'selected':''}}>USD</option>
                            </select>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="bank_name" class="form-control-label">Bank Name</label>
                            <div class="input-group input-group-merge ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-university"></i>
                                    </span>
                                </div>
                                <input data-name="bank_name" placeholder="Enter Bank Name" name="bank_name" type="text" id="bank_name" class="form-control" value="{{old('bank_name')}}">
                                @error('bank_name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div> <!---->
                        </div>
                        <div class="form-group col-md-6">
                            <label for="bank_phone" class="form-control-label">Bank Phone</label>
                            <div class="input-group input-group-merge ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-phone"></i>
                                    </span>
                                </div>
                                <input data-name="bank_phone" placeholder="Enter Bank Phone" name="bank_phone" type="text" id="bank_phone" class="form-control" value="{{old('bank_phone')}}">
                                @error('bank_phone')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div> <!---->
                        </div>
                        <div class="form-group col-md-6">
                            <label for="bank_phone" class="form-control-label">Starting Balance</label>
                            <div class="input-group input-group-merge ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-balance-scale"></i>
                                    </span>
                                </div>
                                <input data-name="bank_phone" placeholder="Enter Starting Balance" name="balance" type="text" id="starting_balance" class="form-control" value="{{old('balance')}}">
                                @error('balance')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div> <!---->
                        </div>
                        <div class="form-group col-md-12">
                            <label for="bank_address" class="form-control-label">Bank Address</label>
                            <textarea  placeholder="Enter Bank Address" rows="3" name="bank_address" cols="50" id="bank_address" class="form-control">
                                {{old('bank_address')}}

                            </textarea> <!---->
                            @error('bank_address')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="enable" value="1" checked>
                                <label class="custom-control-label" for="customSwitch1">Enabled</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row save-buttons">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-icon btn-success float-right ml-2"><!---->
                                <span class="btn-inner--text ">Save</span>
                            </button>
                            <a href="{{route('accounts.index')}}" class="btn btn-outline-secondary float-right">Cancel</a>

                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('select').select2();
        });
    </script>
@endsection