@extends('layout.mainlayout')
@section('title',$po->purchaseorder_id)
@section('content')
    <link rel="stylesheet" href="{{url(asset('css/invoice_css/argon.css'))}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div id="header" class="">
            <div class=" content-layout">
                <div class="header-body">
                    <div class="row  align-items-center">
                        <div class="col-xs-12 col-sm-4 col-md-5 align-items-center">
                            <h2 class="d-inline-flex mb-0 long-texts"></h2></div>
                        <div class="col-xs-12 col-sm-8 col-md-7">
                            <div class="text-right">
                                <div class="dropup header-drop-top">
                                    <button type="button" data-toggle="dropdown" aria-expanded="false"
                                            class="btn btn-white btn-sm"><i class="fa fa-chevron-down"></i>&nbsp; More
                                        Actions
                                    </button>
                                    <div role="menu" class="dropdown-menu">
                                        <a href="" id="print" class="dropdown-item "  onclick="printContent('print_me');" ><i class="fa fa-print"></i> Print</a>
                                        <div class="dropdown-divider"></div>
                                        <button type="button" title="Delete" data-toggle="modal" data-target="#delete{{$po->id}}" class="dropdown-item action-delete">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                                <button class="btn btn-danger btn-sm" type="button" id="create_pdf"><i class="fa fa-file-pdf-o mr-2"></i>PDF Download</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="card my-3">
                <div class="card-body">
                    <div data-timeline-content="axis" data-timeline-axis-style="dashed" class="timeline timeline-one-side">
                        <div class="timeline-block">
                            <span class="timeline-step badge-primary"><i class="la la-plus text-white"></i></span>
                            <div class="timeline-content"><h2 class="font-weight-500">
                                    {{$po->purchaseorder_id}}
                                </h2>

                                <small>
                                    Ordered on {{\Carbon\Carbon::parse($po->ordered_date)->toFormattedDateString()}}
                                </small>
                                <div class="mt-3">
                                    <a href="{{route('purchaseorders.edit',$po->id)}}"
                                                     class="btn btn-primary btn-sm btn-alone header-button-top {{$po->confirm==1?'disabled':''}}">
                                        Edit
                                    </a>
                                    @if($po->confirm==1)
                                        <span><i class="fa fa-check"></i></span>
                                        @endif
                                   </div>
                            </div>
                        </div>
                        <div class="timeline-block">
                            <span class="timeline-step badge-info"><i class="la la-check-circle-o text-white"></i></span>
                            <div class="timeline-content">
                                <small>
                                    Confirmed on {{\Carbon\Carbon::parse($po->confirm_date)->toFormattedDateString()}}
                                </small>
                                <div class="mt-3">
                                    <a href="{{route('purchaseorders.confirm',$po->id)}}"
                                       class="btn btn-primary btn-sm btn-alone header-button-top  {{$po->confirm==1?'disabled':''}}">
                                        Confirm
                                    </a>
                                    @if($po->confirm==1)
                                        <span><i class="fa fa-check"></i></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="timeline-block "><span class="timeline-step badge-danger"><i
                                        class="la la-cube text-white"></i></span>
                            <div class="timeline-content">
                                <h2 class="font-weight-500">
                                   Product Receipt
                                </h2>
                                <small>
                                    Status:
                                </small>
                                <small>
                                    {{$po->is_receipt==1?'Receipt':'UnReceipt'}}
                                </small><br>
                                @if($po->is_receipt==1)
                                    <small>
                                        Receipt Date {{\Carbon\Carbon::parse($po->receipt_date)->toFormattedDateString()}}
                                    </small>
                                    <div class="mt-3">
                                        <a href="" class="btn btn-outline-primary btn-sm header-button-top disabled ">Receipt Product</a>

                                            <span><i class="fa fa-check"></i></span>
                                    </div>

                                @else
                                <div class="mt-3">
                                    <a href="" class="btn btn-outline-primary btn-sm header-button-top {{$po->confirm==0?'disabled':''}}">Receipt Product</a>
                                    </div>
                                    @endif
                            </div>
                        </div>
                        <div class="timeline-block">
                            <span class="timeline-step badge-success"><i
                                        class="la la-money text-white"></i></span>
                            <div class="timeline-content"><h2 class="font-weight-500">
                                    Paid Bill
                                </h2>
                                <small>
                                    Status:
                                </small>
                                <small>
                                    {{$po->paid_bill==1?'Paid':'Unpaid'}}
                                </small>
                               @if(!$inventory_receipt)
                                    <div class="mt-3">
                                        <a href="{{route('po.bill',$po->id)}}" class="btn btn-success btn-sm header-button-bottom {{$po->confirm==0?'disabled':''}}" >
                                            Create Bill
                                        </a>
                                    </div>
                                   @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <div class="row form" >
            <div class="col-lg-12">
                <div class="card" >
                    <div class="card-body" id="print_me" style="padding-top: 50px;">
                        <div class="row pb-4 mx-0 card-header-border">
                            <div class="col-lg-5 col-6 col-md-5 mb-3">
                                <img class="is-squared"
                                     src="{{$company!=null ? url(asset('/img/profiles/'.$company->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}" style="max-width: 100px;max-height: 100px;">
                                <span>{{$company->name??''}}</span><br><span>{{$company->email??''}}</span><br>
                                <span>{{$company->phone??''}}</span><br>
                                <span>{{$company->address??''}}</span>
                            </div>
                            <div class="col-lg-4 col-4">
                                <div class="text-left">
                                    <h5 class="font-weight-bold mb-2">Purchase Order number</h5>
                                    <b class="mb-0">{{$po->purchaseorder_id}}</b>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="text-right">
                                    <h5 class="font-weight-bold mb-2">Deadline Date</h5>
                                    <p class="mb-0">{{\Illuminate\Support\Carbon::parse($po->deadline)->toFormattedDateString()}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-4 pb-5 mx-0">
                            <div class="col-lg-6 col-6">
                                <div class="text-left">
                                    <h5 class="font-weight-bold mb-3">Company Information</h5>
                                    <p class="mb-0 mb-1">{{$po->employee->name}}</p>
                                    <p class="mb-0 mb-1">{{$po->employee->address}}</p>
                                    <p class="mb-0 mb-1">{{$po->employee->phone}}</p>
                                    <p class="mb-0 mb-2">{{$po->employee->email}}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-6">
                                <div class="text-right">
                                    <h5 class="font-weight-bold mb-3">Supplier Information</h5>
                                    <p class="mb-0 mb-1">{{$po->vendor->company->name}}</p>
                                    <p class="mb-0 mb-1">{{$po->vendor->name}}</p>
                                    <p class="mb-0 mb-1">{{$po->vendor->address}}</p>
                                    <p class="mb-0 mb-2">{{$po->vendor->phone}}</p>
                                    <p class="mb-0 mb-2">{{$po->vendor->email}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item p-0">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ITEM</th>
                                                    <th class="d-none d-sm-table-cell">DESCRIPTION</th>
                                                    <th>UNIT COST</th>
                                                    <th>QUANTITY</th>
                                                    <th class="text-right">TOTAL</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($items as $item)
                                                    <tr>
                                                        <td>{{$item->id}}</td>
                                                        <td>
                                                            @foreach($products as $key=>$val)
                                                                @if($key==$item->product->product_id)
                                                                    {{$val}} @if($item->product->color!=null||$item->product->size!=null||$item->product->other!=null)
                                                                                 ({{$item->product->color}} {{$item->product->size}} {{$item->product->other}})
                                                                                 @endif
                                                                    @endif
                                                                @endforeach
                                                        </td>
                                                        <td class="d-none d-sm-table-cell">{{$item->description}}</td>
                                                        <td>{{$item->price}}
                                                        <td>{{$item->qty}}</td>
                                                        <td class="text-right">{{$item->total}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-end">
                                            Total: <p class="ml-2 mb-0 font-weight-bold">  {{$po->subtotal}} MMK </p>
                                        </div>

                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-end ">
                                            Discount: <p class="ml-2 mb-0 font-weight-bold">  {{$po->discount}} MMK</p>
                                        </div>

                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-end ">
                                            Tax: <p class="ml-2 mb-0 font-weight-bold"> {{$po->tax_amount}} MMK </p>
                                        </div>

                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-end mb-2">
                                            Grand Total: <p class="ml-2 mb-0 font-weight-bold">  {{$po->grand_total}} MMK</p>
                                        </div>

                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-flex flex-wrap justify-content-between align-items-center p-4">
                                    <div class="flex align-items-start flex-column">
                                        <h6>Notes</h6>
                                        <p class="mb-0 my-2">{{$po->description}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="modal fade" id="add_payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">--}}
        {{--<div class="modal-dialog modal-lg" role="document">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<h5 class="modal-title">Add Payment</h5>--}}
                    {{--<button type="button" aria-hidden="true"  data-dismiss="modal" class="close">×</button>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                    {{--<form method="POST" action="{{route('income.store')}}" accept-charset="UTF-8" id="transaction" role="form" novalidate="novalidate" enctype="multipart/form-data"--}}
                          {{--class="form-loading-button needs-validation">--}}
                        {{--@csrf--}}
                        {{--<div class="card-body">--}}
                            {{--<div class="row">--}}
                                {{--<input type="hidden" name="type" value="Revenue">--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label for="date">Date</label>--}}
                                        {{--<input type="date" id="date" name="transaction_date" class="form-control">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label for="amount">Amount</label>--}}
                                        {{--<div class="input-group">--}}
                                            {{--<div class="input-group-prepend">--}}
                                                {{--<span class="input-group-text"><i class="fa fa-money"></i></span>--}}
                                            {{--</div>--}}
                                            {{--<input type="text" class="form-control" id="amount" name="amount" value="{{$data['overdue_amount']}}">--}}
                                            {{--<div class="input-group-prepend">--}}
                                                {{--<select name="currency" id="" class="select">--}}
                                                    {{--<option value="MMK">MMK</option>--}}
                                                    {{--<option value="USD">USD</option>--}}
                                                {{--</select>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label for="account">Account</label>--}}
                                        {{--<div class="input-group">--}}
                                            {{--<div class="input-group-prepend" style="width: 12%">--}}
                                                {{--<span class="input-group-text"><i class="fa fa-bank"></i></span>--}}
                                            {{--</div>--}}
                                            {{--<select name="account" id="account" class="form-control" style="width: 83%">--}}
                                                {{--@foreach($data['account'] as $account)--}}
                                                    {{--<option value="{{$account->id}}">{{$account->name}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label for="customer_id">Customer</label>--}}
                                        {{--<div class="input-group">--}}
                                            {{--<div class="input-group-prepend" style="width: 12%;">--}}
                                                {{--<span class="input-group-text"><i class="fa fa-user"></i></span>--}}
                                            {{--</div>--}}
                                            {{--<select name="customer_id" id="customer_id" class="form-control" style="width: 83%;">--}}
                                                {{--@foreach($data['customers'] as $customer)--}}
                                                    {{--<option value="{{$customer->id}}" {{$customer->id==$detail_inv->customer->id?'selected':''}}>{{$customer->name}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-12">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label for="revenue_description">Description</label>--}}
                                        {{--<textarea name="description" id="revenue_description" cols="30" rows="5" class="form-control">--}}

                                {{--</textarea>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-6" id="cat_div">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label for="category">Category</label>--}}
                                        {{--<div class="input-group">--}}
                                            {{--<div class="input-group-prepend" style="width: 10%">--}}
                                                {{--<span class="input-group-text"><i class="fa fa-folder"></i></span>--}}
                                            {{--</div>--}}
                                            {{--<select name="category" id="category" class="form-control " style="width: 80%" >--}}
                                                {{--@foreach($data['category'] as $cat)--}}
                                                    {{--<option value="{{$cat->name}} {{$cat->name==' Invoice'?'selected':''}}">{{$cat->name}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                            {{--<div class="input-group-prepend" style="width: 10%">--}}
                                                {{--<a href="" class="input-group-text" data-toggle='modal' data-target='#add_cat'><i--}}
                                                            {{--class="fa fa-plus"></i></a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label for="payment_method">Payment Method</label>--}}
                                        {{--<div class="input-group">--}}
                                            {{--<div class="input-group-prepend">--}}
                                                {{--<span class="input-group-text"><i class="fa fa-credit-card"></i></span>--}}
                                            {{--</div>--}}
                                            {{--<select name="payment_method" id="payment_method" class="form-control ">--}}
                                                {{--@foreach($data['payment_method'] as $payment_method)--}}
                                                    {{--<option value="{{$payment_method}}">{{$payment_method}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<div class="form-group"><label for="reference">Reference</label>--}}
                                        {{--<div class="input-group">--}}
                                            {{--<div class="input-group-prepend">--}}
                                                {{--<span class="input-group-text"><i class="fa fa-file-text-o"></i></span>--}}
                                            {{--</div>--}}
                                            {{--<input type="text" class="form-control" name="reference" id="reference">--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<input type="hidden" name="invoice_id" value="{{$detail_inv->id}}">--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="card-footer">--}}
                            {{--<div class="row save-buttons">--}}
                                {{--<div class="col-md-12"><a href="{{route('invoices.show',$detail_inv->id)}}"--}}
                                                          {{--class="btn btn-outline-secondary">Cancel</a>--}}
                                    {{--<button type="submit" class="btn btn-icon btn-success"><!----> <span--}}
                                                {{--class="btn-inner--text">Save</span></button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <div class="modal custom-modal fade" id="delete{{$po->id}}">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        &times;
                    </button>
                </div>
                <form action="{{route('purchaseorders.destroy',$po->id)}}" method="POST">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <strong>Do you want to Delete Purchase Order id {{$po->purchaseorder_id}}?</strong>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button"class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success ">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="print_me"  style="visibility: hidden">
        @include('transaction.add_category')
        <script>
            function printContent(el){
                // document.title = ;
                var restorepage = $('body').html();
                $('#myTab').remove();
                var printcontent = $('#' + el).clone();
                printcontent.append('<div class="row" style="position: fixed;bottom: 110px; left: 50px" ><div class="row justify-content-between"> <div class="col-12 text-center"><span>{{$company->web_link??''}}</span></div></div></div>');
                printcontent.append('<div class="row" style="position: fixed;bottom: 90px; left: 50px" ><div class="row justify-content-between"> <div class="col-12 text-center"><span>{{$company->email??''}}</span></div></div></div>');
                printcontent.append('<div class="row" style="position: fixed;bottom: 70px; left: 50px" ><div class="row justify-content-between"> <div class="col-12 text-center"><span>{{$company->phone??''}}</span></div></div></div>');
                printcontent.append('<div class="row" style="position: fixed;bottom: 50px; left: 50px" ><div class="row justify-content-between"> <div class="col-12 text-center"><span>{{$company->address??''}}</span></div></div></div>');
                $('body').empty().html(printcontent);
                $('.footer').hide();
                window.print();
                $('body').html(restorepage);
            }
            (function () {
                var
                    form = $('.form'),
                    cache_width = form.width(),
                    a4 = [595.28, 841.89]; // for a4 size paper width and height

                $('#create_pdf').on('click', function () {
                    $('body').scrollTop(0);
                    createPDF();
                });
                //create pdf
                function createPDF() {
                    getCanvas().then(function (canvas) {
                        var
                            img = canvas.toDataURL("image/png"),
                            doc = new jsPDF({
                                unit: 'px',
                                format: 'a4'
                            });
                        doc.addImage(img, 'JPEG', 20, 20);
                        doc.save('{{$po->purchaseorder_id}}.pdf');
                        form.width(cache_width);
                    });
                }

                // create canvas object
                function getCanvas() {
                    form.width((a4[0] * 1.33333) - 80).css('max-width', 'none');
                    return html2canvas(form, {
                        imageTimeout: 2000,
                        removeContainer: true
                    });
                }

            }());

        </script>
        <script>
            (function ($) {
                $.fn.html2canvas = function (options) {
                    var date = new Date(),
                        $message = null,
                        timeoutTimer = false,
                        timer = date.getTime();
                    html2canvas.logging = options && options.logging;
                    html2canvas.Preload(this[0], $.extend({
                        complete: function (images) {
                            var queue = html2canvas.Parse(this[0], images, options),
                                $canvas = $(html2canvas.Renderer(queue, options)),
                                finishTime = new Date();

                            $canvas.css({ position: 'absolute', left: 0, top: 0 }).appendTo(document.body);
                            $canvas.siblings().toggle();

                            $(window).click(function () {
                                if (!$canvas.is(':visible')) {
                                    $canvas.toggle().siblings().toggle();
                                    throwMessage("Canvas Render visible");
                                } else {
                                    $canvas.siblings().toggle();
                                    $canvas.toggle();
                                    throwMessage("Canvas Render hidden");
                                }
                            });
                            throwMessage('Screenshot created in ' + ((finishTime.getTime() - timer) / 1000) + " seconds<br />", 4000);
                        }
                    }, options));

                    function throwMessage(msg, duration) {
                        window.clearTimeout(timeoutTimer);
                        timeoutTimer = window.setTimeout(function () {
                            $message.fadeOut(function () {
                                $message.remove();
                            });
                        }, duration || 2000);
                        if ($message)
                            $message.remove();
                        $message = $('<div ></div>').html(msg).css({
                            margin: 0,
                            padding: 10,
                            background: "#000",
                            opacity: 0.7,
                            position: "fixed",
                            top: 10,
                            right: 10,
                            fontFamily: 'Tahoma',
                            color: '#fff',
                            fontSize: 12,
                            borderRadius: 12,
                            width: 'auto',
                            height: 'auto',
                            textAlign: 'center',
                            textDecoration: 'none'
                        }).hide().fadeIn().appendTo('body');
                    }
                };
            })(jQuery);
        </script>

        <!-- /Page Content -->
@endsection
