@extends('layout.mainlayout')
@section('title','Add Revenue')
@section('content')
    <div class="container-fluid">
        <div class="page-header my-3">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">
                            <h3>Add Revenue</h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <form method="POST" action="{{route('income.store')}}" accept-charset="UTF-8" id="transaction" role="form" novalidate="novalidate" enctype="multipart/form-data"
                  class="form-loading-button needs-validation">
                @csrf
                <div class="card-body">
                    <div class="row">
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="date">Date</label>
                               <input type="date" id="date" name="transaction_date" class="form-control">
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="amount">Amount</label>
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fa fa-money"></i></span>
                                  </div>
                                  <input type="text" class="form-control" id="amount" name="amount">
                                  <div class="input-group-prepend">
                                      <select name="currency" id="" class="select">
                                          <option value="MMK">MMK</option>
                                          <option value="USD">USD</option>
                                      </select>
                                  </div>
                              </div>
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="account">Account</label>
                               <div class="input-group">
                                   <div class="input-group-prepend">
                                       <span class="input-group-text"><i class="fa fa-bank"></i></span>
                                   </div>
                                        <select name="account" id="account" class="form-control">
                                            @foreach($data['account'] as $account)
                                                <option value="{{$account}}">{{$account}}</option>
                                                @endforeach
                                        </select>
                               </div>
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="customer_id">Customer</label>
                               <div class="input-group">
                                   <div class="input-group-prepend">
                                       <span class="input-group-text"><i class="fa fa-user"></i></span>
                                   </div>
                               <select name="customer_id" id="customer_id" class="form-control">
                                   @foreach($data['customers'] as $key=>$val)
                                   <option value="{{$key}}">{{$val}}</option>
                                       @endforeach
                               </select>
                               </div>
                           </div>
                       </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="revenue_description">Description</label>
                                <textarea name="description" id="revenue_description" cols="30" rows="5" class="form-control">

                                </textarea>
                            </div>
                        </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="category">Category</label>
                               <div class="input-group">
                                   <div class="input-group-prepend">
                                       <span class="input-group-text"><i class="fa fa-folder"></i></span>
                                   </div>
                               <select name="category" id="category" class="form-control">
                                   @foreach($data['category'] as $cat)
                                   <option value="{{$cat}}">{{$cat}}</option>
                                       @endforeach
                               </select>
                               </div>
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
                       <div class="col-md-6">
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
                <input name="type" type="hidden" value="income">
            </form>
        </div>
    </div>
@endsection