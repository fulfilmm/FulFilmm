@extends(\Illuminate\Support\Facades\Auth::guard('employee')->check()?'layout.mainlayout':'layouts.app')
@section('title','Invoice Create')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    <!-- Page Content -->
    @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
        <div class="content container-fluid">
            @endif

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Order</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add Order</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="font-weight-bold pb-3">Customer Details</h5>
                                @csrf
                                <div class="col-md-12 mb-3">
                                    <label for="Text1" class="form-label font-weight-bold text-muted text-uppercase">Customer <span class="text-danger">*</span></label>
                                    <select name="customer_id" class="form-control" id="customer_id" required>
                                        <option value="">Choose Customer</option>
                                        @foreach($data['customer'] as $customer)
                                            @if(\Illuminate\Support\Facades\Auth::guard('customer')->check()&& \Illuminate\Support\Facades\Auth::guard('customer')->user()->id==$customer->id)
                                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                @else
                                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                @endif
                                            @endforeach
                                    </select>
                                    <span class="text-danger customer_id_err"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="phone" class="form-label font-weight-bold text-muted text-uppercase">Phone <span class="text-danger">*</span></label>
                                    <input type="text"  class="form-control" id="phone" name="phone" placeholder="Enter Phone" required>
                                    <span class="text-danger phone_err"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="email" class="form-label font-weight-bold text-muted text-uppercase">Email <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                                    <span class="text-danger email_err"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="address" class="form-label font-weight-bold text-muted text-uppercase">Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address" required>
                                    <span class="text-danger address_err"></span>
                                </div>
                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label font-weight-bold text-muted text-uppercase">Billing Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="billing_address" name="billing_address" placeholder="Enter Billing Address" required>
                                <span class="text-danger email_err"></span>
                            </div>
                            <div class="form-group col-12">
                                <label for="" class="form-label font-weight-bold text-muted text-uppercase">Shipping Type</label><br>
                               <input type="radio" class="shipping_type" name="shipping_type" value="pickup" checked> <label for="shipping_address" class="ml-2 mr-3">Pick Up</label>
                                <input type="radio" class="shipping_type" name="shipping_type" value="delivery"><label for="shipping_address" class="ml-2 mr-3">Delivery</label>
                            </div>
                            <div class="form-group col-12" id="delivery_address">
                                <label for='' class='form-label font-weight-bold text-muted text-uppercase'>Shipping Address</label>
                                <input type='text' class='form-control' name='shipping_address' id='shipping_address' placeholder='Shipping Address'>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="font-weight-bold pb-3">Order Details</h5>
                            <div class="row g-3">
                                <div class="col-md-6 mb-3">
                                    <label for="order_date" class="form-label font-weight-bold text-muted text-uppercase">Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="order_date" placeholder="DD MM YYYY" required>
                                    <span class="text-danger order_date_err"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="time" class="form-label font-weight-bold text-muted text-uppercase">Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="time" placeholder="00:00" required>
                                    <span class="text-danger time_err"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="Text7" class="form-label font-weight-bold text-muted text-uppercase">Payment Method <span class="text-danger">*</span></label><br>
                                    <div class="form-group"  aria-label="Basic outlined example">
                                        <input type="radio" name="payment_type" id="payment_type" value="Cash" class="mr-2" checked><label for="">Cash</label>
                                        <input type="radio" name="payment_type" id="payment_type" value="Mobile Banking" class="mr-2 ml-2"><label>Mobile Banking</label>
                                        <input type="radio" name="payment_type" id="payment_type" value="Bank Transfer" class="mr-2 ml-2"><label for="">Bank Transfer</label>
                                    </div>
                                    <span class="text-danger payment_type_err"></span>
                                </div>
                                <div class="col-md-12 ">
                                    <label for="Text7" class="form-label font-weight-bold text-muted text-uppercase">Payment Term <span class="text-danger">*</span></label><br>
                                    <div class="form-group"  aria-label="Basic outlined example">
                                        <select class="form-control" name="payment_term" id="payment_term" required>
                                            <option value="COD - Cash on delivery">COD - Cash on delivery</option>
                                            <option value="Payment seven days after invoice date">Payment seven days after invoice date</option>
                                            <option value="EOM - End of month">EOM - End of month</option>

                                        </select>
                                        <span class="text-danger payment_term_err"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    {{--@dd($data['quotation'])--}}
                                    <div class="form-group">
                                        <label for="quotation_id" class="font-weight-bold text-muted text-uppercase">Quotation ID</label>
                                        <select name="quotation_id" id="quotation_id" class="form-control">
                                            <option value="">None</option>
                                            @foreach($data['quotation'] as $key=>$val)
                                            <option value="{{$key}}">{{$val}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="comment" class="form-label font-weight-bold text-muted text-uppercase">Remark</label>
                                    <textarea type="text" class="form-control" id="comment" name="comment" rows="2.5" placeholder="Enter your comment"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-3">
                            <h5 class="font-weight-bold mb-3">Order Items</h5>
                        </li>
                        <li class="list-group-item p-0">
                            <div class="table-responsive" id="order_table">
                                <table class="table table-hover table-white">
                                    <thead>
                                    <th>Product</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Taxes(%)</th>
                                    <th>Total(Include Tax)</th>
                                    <th>Currency Unit</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody id="tbody">
                                    @foreach($data['items'] as $order)
                                        <tr>
                                            <td><input type="hidden" id="order_id_{{$order->id}}" value="{{$order->id}}">
                                              <div class="row">
                                                  <input type="hidden" name="product_id" id="product_{{$order->id}}" value="{{$order->product_id}}">
                                                  <div class="col-md-4">
                                                      <img src="{{url(asset('product_picture/'.$order->product->image))}}"  alt="" width="40px" height="40px">
                                                  </div>
                                                  <div class="data-content">
                                                      <div>
                                                          <span class="font-weight-bold">{{$order->product->name}}</span>
                                                      </div>
                                                      <p class="m-0 mt-1">
                                                          {{$order->product->description}}
                                                      </p>
                                                  </div>
                                              </div>
                                            </td>
                                            <td>
                                                <input type="text" name="description" id="order_description_{{$order->id}}" class="form-control update_item_{{$order->id}}" value="{{$order->description}}" style="min-width: 200px;">
                                            </td>
                                            <td>
                                                <input type="text" name="quantity" id="quantity_{{$order->id}}" class="form-control update_item_{{$order->id}}" value=" {{$order->quantity}}">
                                            </td>
                                            <td>
                                                <input type="text" id="price_{{$order->id}}" class="form-control update_item_{{$order->id}}" value="{{$order->unit_price}}" style="min-width: 120px;">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control update_item_{{$order->id}}" name="tax" id="product_tax_{{$order->id}}" value="{{$order->tax_id}}" >
                                            </td>
                                            <td>
                                                <input type="text" name="total" id="total_{{$order->id}}" class="form-control col-md-7 update_item_{{$order->id}}" value="{{$order->total}}" style="min-width: 150px;" >
                                            </td>
                                            <td><input type="text" class="form-control update_item_{{$order->id}}" id="unit_{{$order->id}}" value="{{$order->currency_unit}}"></td>

                                            <td>
                                                <a class="btn btn-danger btn-sm" data-toggle="modal" href="#remove{{$order->id}}" ><i class="fa fa-trash-o "></i></a>
                                            </td>
                                        </tr>

                                        @include('saleorder.item_edit_jquery')
                                        @include('invoice.item_remove')
                                    @endforeach
                                    <tr>
                                        <td>
                                            <input type="hidden" id="creation_id" value="{{$data['id'][0]}}">
                                            <select name="" class="form-control" id="product" style="width: 200px" >
                                                <option value="">Search Product</option>
                                                @foreach($data['product'] as $product)
                                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="description" id="order_description" class="form-control" style="min-width: 200px;">
                                        </td>
                                        <td>
                                            <input type="text" name="quantity" id="quantity" class="form-control " value="0">
                                        </td>
                                        <td>
                                            <input type="text" id="price" class="form-control " value="0" style="min-width: 120px;">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="tax" id="product_tax"  >
                                        </td>
                                        <td>
                                            <input type="text" name="total" id="total" class="form-control col-md-7" value="0" style="min-width: 150px;" >
                                        </td>
                                        <td><input type="text" class="form-control" id="unit"></td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger ml-2 text-sm" id="add_item"><i class="fa fa-plus"></i></button>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tr>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                        </li>
                        <li class="list-group-item p-3">
                            <div class="d-flex justify-content-end align-items-center" id="grand_total_div">
                                <input class="form-control" type="hidden" id="grand_total" value="{{$data['grand_total']}}" style="min-width: 150px" readonly>
                               <span>Total:</span> <p class="ml-2 mb-0 mr-5 font-weight-bold"> {{$data['grand_total']}}</p>
                            </div>
                        </li>
                        <li class="list-group-item p-3">
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="button" class="btn btn-primary ml-5 btn-sm" id="order_submit">Create Order</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <!-- /Page Content -->
@include('saleorder.jquery_for_order_create')

@endsection
