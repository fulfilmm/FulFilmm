@extends('layout.mainlayout')
@section('title',"Delivery Details")
@if(\Illuminate\Support\Facades\Auth::guard('customer')->check())
@section('noti')
    <li class="nav-item dropdown">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i> <span class="badge badge-pill">{{count($new_deli)}}</span>
        </a>
        <div class="dropdown-menu notifications">
            <div class="topnav-dropdown-header">
                <span class="notification-title">Notifications</span>
                {{--                <a href="javascript:void(0)" class="clear-noti"> Clear All </a>--}}
            </div>
            <div class="noti-content">
                <ul class="notification-list">
                    @foreach($new_deli as $alert)
                        <li class="notification-message">
                            <a href="{{route('deliveries.show',$alert->id)}}">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="noti-details">{{$alert->employee->name??\Illuminate\Support\Facades\Auth::guard('employee')->user()->name}}
                                            <span class="noti-title">Assigned to you {{$alert->delivery_id}}</span></p>
                                        <p class="noti-time"><span class="notification-time">{{\Carbon\Carbon::parse($alert->created_at)->toFormattedDateString()}} at {{date('h:i a', strtotime(\Carbon\Carbon::parse($alert->created_at)))}}</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </li>
@endsection
@endif
@section('content')
    <link rel="stylesheet" href="{{url(asset('css/invoice_css/argon.css'))}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="row">
            <div class="col-md-8 col-6">
                <div class="card">
                    <div class="card-body">
                        <div data-timeline-content="axis" data-timeline-axis-style="dashed" class="timeline timeline-one-side">
                            <a href="{{url('delivery/state/Draft/'.$delivery->id)}}" id="draft">
                                <div class="timeline-block"><span class="timeline-step badge-primary"><i class="la la-{{$delivery->draft==1?'check':''}} text-white"></i></span>
                                    <div class="timeline-content"><h2 class="font-weight-500">
                                            Draft
                                        </h2>
                                        @if($delivery->draft==1)
                                        <small>
                                            Draft State: {{\Carbon\Carbon::parse($delivery->created_at)->toFormattedDateString()}} on {{date('h:i a', strtotime($delivery->created_at))}}
                                        </small>
                                            @endif
                                    </div>
                                </div>
                            </a>
                            <a href="{{url('delivery/state/Packing/'.$delivery->id)}}" id="packing">
                                <div class="timeline-block">

                        <span class="timeline-step badge-danger"><i
                                    class="la la-{{$delivery->packing==1?'check':''}} text-white"></i></span>
                                    <div class="timeline-content"><h2 class="font-weight-500">
                                            Packing
                                        </h2>
                                        @if($delivery->packing==1)
                                        <small>
                                            Packing: {{\Carbon\Carbon::parse($delivery->packing_time)->toFormattedDateString()}} on {{date('h:i a', strtotime($delivery->packing_time))}}
                                        </small>
                                            @else
                                            <small>Not yet in packaging</small>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            <a href="{{url('delivery/state/Delivery/'.$delivery->id)}}" id="delivery">
                                <div class="timeline-block">

                                <span class="timeline-step badge-purple">
                                    <i class="la la-{{$delivery->on_way==1?'check':''}} text-white"></i>
                                </span>
                                    <div class="timeline-content">
                                        <h2 class="font-weight-500">On Delivery</h2>
                                        @if($delivery->on_way==1)
                                        <small>
                                            On The Way:{{\Carbon\Carbon::parse($delivery->onway_time)->toFormattedDateString()}} on {{date('h:i a', strtotime($delivery->onway_time))}}
                                        </small>
                                        @else
                                            <small>Not yet in on the way</small>
                                            @endif
                                    </div>
                                </div>
                            </a>
                            <a href="{{url('delivery/state/Done/'.$delivery->id)}}"  id="done">
                                <div class="timeline-block">

                                <span class="timeline-step badge-success">
                                    <i class="la la-{{$delivery->receipt==1?'check':''}} text-white"></i>
                                </span>
                                    <div class="timeline-content">
                                        <h2 class="font-weight-500">Done</h2>
                                       @if($delivery->receipt==1)
                                        <small>
                                           Done Time:{{\Carbon\Carbon::parse($delivery->receipt_time)->toFormattedDateString()}} on {{date('h:i a', strtotime($delivery->receipt_time))}}
                                        </small>
                                        @else
                                            <small>Not yet in Done</small>
                                           @endif
                                    </div>
                                </div>
                            </a>
                            <a href="" id="receipt">
                                <div class="timeline-block">
                                <span class="timeline-step badge-warning">
                                    <i class="la la-{{$delivery->customer_receive_confirm==1?'check':''}} text-white"></i>
                                </span>
                                    <div class="timeline-content">
                                        <h2 class="font-weight-500">Receipt</h2>
                                        <a href="{{url('delivery/state/receipt/'.$delivery->id)}}" id="recept" class="btn btn-success btn-sm disabled">Receipt</a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mt-3" style="font-size: inherit !important;">
           <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                        <a href="{{route('delivery.bill',$delivery->id)}}" class="btn btn-primary btn-sm float-right  {{$delivery->paid_deli_fee==1?'disabled':''}}">{{$delivery->paid_deli_fee==1?'Already Created Bill':'Create Bill'}}</a>
                        @endif<br>
                    <h3 class="d-inline-flex mb-0 long-texts">Shipping Information</h3>
                </div>
                <div class="col-12 my-2">
                    <div class="row my-3">
                        <div class="col-md-5">Delivery ID: <strong>{{$delivery->delivery_id}}</strong></div>

                        <div class="col-md-5 offset-md-2">Customer : <strong>{{$delivery->customer->name}}</strong></div>

                    </div>
                    <div class="row my-3">
                        <div class="col-md-5">Delivery Date: <strong>{{\Carbon\Carbon::parse($delivery->delivery_date)->toFormattedDateString()}}</strong></div>
                        <div class="col-md-5 offset-md-2">Customer Phone: <strong>{{$delivery->customer->phone}}</strong></div>

                    </div>
                    <div class="row my-3">
                        <div class="col-md-5">Warehouse : <strong>{{$delivery->warehouse->name}}</strong></div>
                        <div class="col-md-5 offset-md-2">Shipping Address: <strong>{{$delivery->shipping_address}}</strong></div>

                    </div>
                </div>
            </div>
           </div>
        </div>
            </div>
            <div class="col-md-4 ">
        <h3>Comment</h3>
        <div class="border" style="height: 500px;overflow: auto">
            @foreach($comments as $cmt)
                <div class="col-10 offset-1 my-2">
                    <div class="row border" style="border-radius: 30px;">
                        <div class="col-md-2 mt-3">
                            <img src="{{url(asset('img/profiles/avatar-02.jpg'))}}" alt="" class="rounded-circle" width="40px" height="40px">
                        </div>
                        <div class="col-md-6 mt-3">
                            @if($cmt->emp_id==null)
                                <span style="font-size: 14px">{{$cmt->courier->name}}</span>
                            @else
                                <span style="font-size: 14px">{{$cmt->emp->name}}</span>


                            @endif
                            <p style="font-size: 12px">{{$cmt->comment}}</p>

                        </div>
                        <div class="col-6 offset-2 mb-2">
                            <div class="row">
                                <span style="font-size: 12px">{{\Carbon\Carbon::parse($cmt->created_at)->toFormattedDateString()}}</span> <span style="font-size: 12px" class="ml-2">{{date('h:i a', strtotime($cmt->created_at))}}</span>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
        <div class="col">
            <form action="{{route('delivery.comment')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="input-group">
                        <input type="hidden" name="delivery_id" value="{{$delivery->id}}">
                        <input type="text" class="form-control" name="comments">
                        <button type="submit" class="btn btn-primary btn-sm">Comment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 my-2">
            <div class="text-left">
                <h3>Invoice Information</h3>
            </div>
            <div class="text-right">
                <div class="dropup header-drop-top">
                    <a href="" id="print" class="btn btn-white btn-sm"  onclick="printContent('print_me');" ><i class="fa fa-print"></i> Print</a>
                </div>
                <button class="btn btn-danger btn-sm" type="button" id="create_pdf"><i class="fa fa-file-pdf-o mr-2"></i>PDF Download</button>

            </div>
        </div>
        <div class="row form" >
            <div class="col-lg-12">
                <div class="card" >
                    <div class="card-body" id="print_me" style="padding-top: 50px;">
                        <div class="row pb-4 mx-0 card-header-border">
                            <div class="col-lg-6 col-6 col-md-6 mb-3">
                                <img class="is-squared"
                                     src="{{$company!=null ? url(asset('/img/profiles/'.$company->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}" style="max-width: 100px;max-height: 100px;">
                                <span>{{$company->name??''}}</span><br><span>{{$company->email??''}}</span><br>
                                <span>{{$company->phone??''}}</span><br>
                                <span>{{$company->address??''}}</span>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="text-left">
                                    <h5 class="font-weight-bold mb-2">Invoice number</h5>
                                    <b class="mb-0">{{$detail_inv->invoice_id}}</b>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="text-right">
                                    <h5 class="font-weight-bold mb-2">Invoice Date</h5>
                                    <p class="mb-0">{{\Illuminate\Support\Carbon::parse($detail_inv->invoice_date)->toFormattedDateString()}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-4 pb-5 mx-0">
                            <div class="col-lg-6 col-6">
                                <div class="text-left">
                                    <h5 class="font-weight-bold mb-3">Invoice From</h5>
                                    <p class="mb-0 mb-1">{{$detail_inv->employee->name}}</p>
                                    <p class="mb-0 mb-1">{{$detail_inv->employee->address}}</p>
                                    <p class="mb-0 mb-1">{{$detail_inv->employee->phone}}</p>
                                    <p class="mb-0 mb-2">{{$detail_inv->employee->email}}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-6">
                                <div class="text-right">
                                    <h5 class="font-weight-bold mb-3">Invoice To</h5>
                                    <p class="mb-0 mb-1">{{$detail_inv->customer->company->name}}</p>
                                    <p class="mb-0 mb-1">{{$detail_inv->customer->name}}</p>
                                    <p class="mb-0 mb-1">{{$detail_inv->customer->address}}</p>
                                    <p class="mb-0 mb-2">{{$detail_inv->customer->phone}}</p>
                                    <p class="mb-0 mb-2">{{$detail_inv->customer->email}}</p>
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
                                                @foreach($invoic_item as $item)
                                                    <tr>
                                                        <td>{{$item->id}}</td>
                                                        <td>{{$item->variant->product_name}}</td>
                                                        <td class="d-none d-sm-table-cell">{{$item->description}}</td>
                                                        <td>{{$item->unit_price}}
                                                        <td>{{$item->quantity}}</td>
                                                        <td class="text-right">{{$item->total}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-end">
                                            Total: <p class="ml-2 mb-0 font-weight-bold">  {{$detail_inv->total}} MMK </p>
                                        </div>

                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-end ">
                                            Discount: <p class="ml-2 mb-0 font-weight-bold">  {{$detail_inv->discount}} MMK</p>
                                        </div>

                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-end ">
                                            Tax: <p class="ml-2 mb-0 font-weight-bold"> {{$detail_inv->tax_amount}} MMK </p>
                                        </div>

                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-end ">
                                            Delivery Fee: <p class="ml-2 mb-0 font-weight-bold"> {{$detail_inv->delivery_fee??0}} MMK </p>
                                        </div>

                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-end mb-2">
                                            Grand Total: <p class="ml-2 mb-0 font-weight-bold">  {{$detail_inv->grand_total}} MMK</p>
                                        </div>

                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-flex flex-wrap justify-content-between align-items-center p-4">
                                    <div class="flex align-items-start flex-column">
                                        <h6>Notes</h6>
                                        <p class="mb-0 my-2">{{$detail_inv->other_information}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="print_me"  style="visibility: hidden">
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
                        doc.save('{{$detail_inv->invoice_id}}.pdf');
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

        <!-- /Page Content -->
@endsection
