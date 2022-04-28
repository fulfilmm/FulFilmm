@extends('layout.mainlayout')
@section('title','Add Expense')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Add Expense</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('transactions.index')}}">Transaction</a></li>
                        <li class="breadcrumb-item float-right">New Expense</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card shadow">
            <form method="POST" action="{{route('expense.store')}}" accept-charset="UTF-8" id="transaction" role="form" novalidate="novalidate" enctype="multipart/form-data"
                  class="form-loading-button needs-validation">
                @csrf
                <input type="hidden" name="exp_id" value="{{$exp_claim->id??''}}">
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" name="type" value="Expense">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" id="date" name="transaction_date" class="form-control">
                            </div>
                            @error('transaction_date')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-money"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="amount" name="amount" value="{{$exp_claim->total??''}}">
                                    <div class="input-group-prepend">
                                        <select name="currency" id="" class="select">
                                            <option value="MMK">MMK</option>
                                            <option value="USD">USD</option>
                                        </select>
                                    </div>
                                </div>
                                @error('amount')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account">Bank Account</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-bank"></i></span>
                                    </div>
                                    <select name="account" id="account" class="form-control">
                                        @foreach($data['account'] as $account)
                                            <option value="{{$account->id}}">{{$account->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('account')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account">Gl Account</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-bank"></i></span>
                                    </div>
                                    <select name="coa_account" id="account" class="form-control">
                                        @foreach($data['coas'] as $account)
                                            <option value="{{$account->id}}">{{$account->code.'-'.$account->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('coa_account')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_id">Supplier</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <select name="customer_id" id="customer_id" class="form-control">
                                        <option value="">None</option>
                                        @foreach($data['customers'] as $customer)
                                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('customer_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_method">Cashier</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <select name="approver_id" id="payment_method" class="form-control ">
                                        @foreach($data['emps'] as $emps)
                                            @if($emps->department->name=='Finance Department')
                                            <option value="{{$emps->id}}">{{$emps->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="cat_div">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-folder"></i></span>
                                    </div>
                                    <select name="category" id="category" class="form-control">
                                        @foreach($data['category'] as $cat)
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-prepend">
                                        <a href="" class="input-group-text" data-toggle='modal' data-target='#add_cat'><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                                @error('category')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="revenue_description">Description</label>
                                <textarea name="description" id="desc" cols="30" rows="5" class="form-control">
                                   {!! $exp_claim->description??'' !!}
                                </textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="recurring">Recurring</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-refresh"></i></span>
                                </div>
                                <select name="recurring" id="recurring" class="form-control">
                                    @foreach($data['recurring'] as $recurring)
                                        <option value="{{$recurring}}">{{$recurring}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_method">Payment Method</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                                    </div>
                                    <select name="payment_method" id="payment_method" class="form-control ">
                                        @foreach($data['payment_method'] as $payment_method)
                                            <option value="{{$payment_method}}">{{$payment_method}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group"><label for="reference">Reference</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" ><i class="fa fa-file-text-o"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="reference" id="reference">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="attach">Attachment</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-paperclip"></i></span>
                                    </div>
                                    <input type="file" name="attachment" class="form-control" id="attach">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row save-buttons">
                        <div class="col-md-12"><a href="https://app.akaunting.com/142258/sales/revenues"
                                                  class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-icon btn-success"><!----> <span
                                        class="btn-inner--text">Save</span></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
    {{--@include('transaction.add_category')--}}
    <script>
        ClassicEditor.create($('#desc')[0], {
            toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
        });
        $(document).ready(function () {
            $('select').select2();
        });
    </script>

@endsection