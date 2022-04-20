@extends('layout.mainlayout')
@section('title','Account Edit')
@section('content')
    <div class="container-fluid content-layout mt--6">
        <div class="page-header mt-2">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Account Update</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Account</li>
                        <li class="breadcrumb-item active">Update</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <form method="POST" action="{{route('accounts.update',$account->id)}}" accept-charset="UTF-8"
                  id="account" role="form" novalidate="novalidate" enctype="multipart/form-data"
                  class="form-loading-button">
                @csrf
                @method('put')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no">Account ID</label>
                                <input type="text" class="form-control" name="account_id" id="no" value="{{$account->account_no}}" required>
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
                                <input data-name="name" placeholder="Enter Name" required="required" name="name" type="text" id="name" value="{{$account->name}}" class="form-control" >
                            </div> <!---->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="branch">Office Branch</label>
                                <select name="branch_id" id="branch" class="form-control">
                                    @foreach($branch as $key=>$val)
                                        <option value="{{$key}}" {{$account->branch_id==$key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6 required">
                            <label for="number" class="form-control-label">Account Number</label>
                            <div class="input-group input-group-merge ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                </div>
                                <input data-name="number" value="{{$account->number}}" placeholder="Enter Account Number" required="required" name="number" type="text" id="number" class="form-control">
                            </div> <!---->
                        </div>
                        <div class="form-group col-md-6 required">
                            <label class="form-control-label">Currency</label>
                            <select name="currency" id="currency" class="form-control select">
                                <option value="MMK" {{$account->currency=='MMK'?'selected':''}}>Kyats</option>
                                <option value="USD" {{$account->currency=='USD'?'selected':''}}>USD</option>
                            </select>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="bank_name" class="form-control-label">Bank Name</label>
                            <div class="input-group input-group-merge ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-university"></i>
                                    </span>
                                </div>
                                <input data-name="bank_name" value="{{$account->bank_name}}" placeholder="Enter Bank Name" name="bank_name" type="text" id="bank_name" class="form-control">
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
                                <input data-name="bank_phone" value="{{$account->bank_phone}}" placeholder="Enter Bank Phone" name="bank_phone" type="text" id="bank_phone" class="form-control">
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
                                <input data-name="bank_phone" value="{{$account->opening_balance}}" placeholder="Enter Starting Balance" name="opening_balance" type="text" id="starting_balance" class="form-control">
                                <input type="hidden" name="balance" id="balance">
                            </div> <!---->
                        </div>
                        <div class="form-group col-md-12">
                            <label for="bank_address" class="form-control-label">Bank Address</label>
                            <textarea data-name="bank_address" placeholder="Enter Bank Address" rows="3" name="bank_address" cols="50" id="bank_address" class="form-control">
                                {{$account->bank_address}}
                            </textarea> <!---->
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
            $('#starting_balance').keyup(function () {
                var open_balance=$('#starting_balance').val();
                $('#balance').val(open_balance);
            })

        })
    </script>
@endsection