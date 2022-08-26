@extends('layout.mainlayout')
@section('title',$po->po_id)
@section('content')
    <link rel="stylesheet" href="{{url(asset('css/invoice_css/argon.css'))}}">
    <!-- Page Content -->
    <style>
        hr {
            border:none;
            border-top:1px dashed #000000;
            color:#fff;
            background-color:#fff;
            height:1px;
            width:100%;
        }
    </style>
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
                                    {{$po->po_id}}
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
                                <span>Approver :</span>
                                <img src="{{$po->approver_name->profile_img!=null? url(asset('img/profiles/'.$po->approver_name->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}"
                                        alt="" class="avatar avatar-xs rounded-circle"><a
                                        href="{{route('employees.show',$po->approver_name->id)}}">{{$po->approver_name->name}}</a>
                            <br>
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
                                   Sent Mail
                                </h2>
                                <small>
                                    Status:
                                </small>
                                <small>
                                    {{$po->sent==1?'Sent':'Un-Sent'}}
                                </small><br>

                                    <div class="mt-3">
                                        <a href="{{url('sent/mail/'.$po->id)}}" class="btn btn-{{$po->sent==1?'success':'danger'}} btn-sm header-button-top ">{{$po->sent==1?'Re-Send':'Send Mail'}}</a>
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
                                    <a href="{{$po->confirm==1?url('receipt/show/'.$product_receive->id):''}}" class="btn btn-outline-primary btn-sm header-button-top {{$po->confirm==0?'disabled':''}}">Receipt Product</a>
                                    </div>
                                    @endif
                            </div>
                        </div>
                        {{--<div class="timeline-block">--}}
                            {{--<span class="timeline-step badge-success"><i--}}
                                        {{--class="la la-money text-white"></i></span>--}}
                            {{--<div class="timeline-content"><h2 class="font-weight-500">--}}
                                    {{--Paid Bill--}}
                                {{--</h2>--}}
                                {{--<small>--}}
                                    {{--Status:--}}
                                {{--</small>--}}
                                {{--<small>--}}
                                    {{--{{$po->paid_bill==1?'Paid':'Unpaid'}}--}}
                                {{--</small>--}}
                               {{--@if(!$inventory_receipt)--}}
                                    {{--<div class="mt-3">--}}
                                        {{--<a href="{{route('po.bill',$po->id)}}" class="btn btn-success btn-sm header-button-bottom {{$po->confirm==0?'disabled':''}}" >--}}
                                            {{--Create Bill--}}
                                        {{--</a>--}}
                                    {{--</div>--}}
                                   {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>

        <div class="row form" >
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-body" id="print_me" style="padding-top: 50px;">
                        <div class="row pb-4 mx-0 card-header-border">
                            <div class="col-lg-4 col-4 col-md-4 mb-3">
                                <img class="is-squared"
                                     src="{{$company!=null ? url(asset('/img/profiles/'.$company->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}" style="max-width: 100px;max-height: 100px;">

                            </div>
                            <div class="col-lg-4 col-4">
                                <h3 class="text-center justify-content-center">{{$company->name??''}}</h3>
                                <h6 class="text-center justify-content-center">{{$company->email??''}}</h6>
                                <h6 class="text-center justify-content-center">{{$company->phone??''}}</h6>
                                <h6 class="text-center justify-content-center">{{$company->address??''}}</h6>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="text-right">
                                    <b class="mb-0">{{$po->po_id}}</b>
                                    <p class="mb-0" style="font-size: 12px;">Deadline Date : {{\Illuminate\Support\Carbon::parse($po->deadline)->toFormattedDateString()}}</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row pt-4 pb-5 mx-0">
                            <div class="col-lg-6 col-6">
                                <div class="text-left">
                                    <h5 class="font-weight-bold mb-3">Company Information</h5>
                                    <p class="mb-0 mb-1">{{$po->employee->name}}</p>
                                    <p class="mb-0 mb-1">{{$po->employee->address}}</p>
                                    <p class="mb-0 mb-1">{{$po->employee->phone}}</p>
                                    <p class="mb-0 mb-2">{{$po->employee->email}}</p>
                                    <p class="mb-0 mb-2">Shipping To : {{$po->shipping_address}}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-6">
                                <div class="text-right">
                                    <h5 class="font-weight-bold mb-3">Supplier Information</h5>
                                    <p class="mb-0 mb-1">{{$po->vendor->company->name??'N/A'}}</p>
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
                                                    <th>UNIT</th>
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
                                                        <td>{{$item->product_unit->unit??''}}</td>
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
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        Attachment File
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($attach as $key=>$val)
                                <div class="col-md-4">
                                    <ul class="files-list">
                                        @if($po->attach!=null)
                                            <li>
                                                <div class="files-cont">
                                                    <div class="file-type">
                                                                    <span class="files-icon"><i
                                                                                class="fa fa-file-pdf-o"></i></span>
                                                    </div>
                                                    <div class="files-info">
                                                                    <span class="file-name text-ellipsis"><a
                                                                                href="">{{$val}}</a></span>
                                                        <span class="file-date">{{$po->created_at}}</span>
                                                        <div class="file-size"></div>
                                                    </div>
                                                    <a class="dropdown-item"
                                                       href="{{url(asset("/attach_file/$val"))}}"><i class="fa fa-download mr-1"></i>Download</a>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        Followers
                    </div>
                    <div class="col-12">
                        <div class="row my-2 ml-3">
                            @foreach($followers as $follower)
                                <a href="#" data-toggle="tooltip" title="{{$follower->emp->name}}"
                                   class="avatar avatar-sm rounded-circle">
                                    <img src="{{$follower->emp->profile_img!=null? url(asset('img/profiles/'.$follower->emp->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
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
                        <strong>Do you want to Delete Purchase Order id {{$po->po_id}}?</strong>
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
            <script src="{{url(asset('js/html2pdf.js'))}}"></script>
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

            $('#create_pdf').on('click', function () {
                generatePDF();
            });
            function generatePDF() {
                // Choose the element that our invoice is rendered in.
                var element = document.getElementById('print_me');
                // Choose the element and save the PDF for our user.
                html2pdf().from(element).save('{{$po->po_id}}');
            }
        </script>

        <!-- /Page Content -->
@endsection
