@extends('layout.mainlayout')
@section('title',$detail_inv->invoice_id)
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
                            <h2 class="d-inline-flex mb-0 long-texts">Invoice: {{$detail_inv->invoice_id}}</h2></div>
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
                                    </div>
                                </div>
                                <button class="btn btn-danger btn-sm" type="button" id="create_pdf"><i class="fa fa-file-pdf-o mr-2"></i>PDF Download</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3" style="font-size: inherit !important;">
            <div class="col-md-2">
                Status
                <br> <strong><span class="float-left"><span class="text-dark badge badge-{{$detail_inv->status=='Paid'?'success':($detail_inv->status=='Partial'?'warning':($detail_inv->status=='Daft'?'white':'danger'))}}">
                       {{$detail_inv->status}}
                    </span></span></strong> <br><br></div>
            <div class="col-md-2">
                Customer
                <br> <strong><span class="float-left"><a href="{{route('customers.show',$detail_inv->customer->id)}}">
                      {{$detail_inv->customer->name}}
                    </a></span></strong> <br><br></div>
            <div class="col-md-2">
                Order ID
                <br> <strong><span class="float-left"><a href="https://app.akaunting.com/142258/sales/customers/1005081">
                      {{$detail_inv->order->order_id??"None"}}
                    </a></span></strong> <br><br></div>
            <div class="col-md-2">
                Tax
                <br> <strong><span class="float-left"><a href="https://app.akaunting.com/142258/sales/customers/1005081">
                      {{$detail_inv->tax->name??"None"}}({{$detail_inv->tax->rate??0}}%)
                    </a></span></strong> <br><br></div>
            <div class="col-md-2">
                Amount due
                <br>
                <strong>
                    <span class="float-left" id="overdue_amount">{{$detail_inv->due_amount}}</span></strong> <br><br></div>
            <div class="col-md-2">
                Due on
                <br> <strong><span class="float-left">
                    {{\Illuminate\Support\Carbon::parse($detail_inv->due_date)->toFormattedDateString()}}               </span></strong> <br><br></div>
        </div>

        <div class="row form" >
            <div class="col-12 ">
                <div class="row" >
                    <div class="col-lg-12" >
                        <div class="card shadow"  >
                            <div class="card-body" id="print_me" style="padding-top: 50px;">
                                <div class="row pb-4 mx-0 card-header-border">
                                    <div class="col-lg-6 col-7 col-md-6 mb-3">
                                        <img class="is-squared"
                                             src="{{$company!=null ? url(asset('/img/profiles/'.$company->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}" style="max-width: 100px;max-height: 100px;">
                                        <span>{{$company->name??''}}</span><br><span>{{$company->email??''}}</span><br>
                                        <span>{{$company->phone??''}}</span><br>
                                        <span>{{$company->address??''}}</span>
                                    </div>
                                    <div class="col-lg-3 col-3">
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
                                                            <th>UNIT Price</th>
                                                            <th>QUANTITY</th>
                                                            <th>Unit</th>
                                                            <th class="text-right">TOTAL</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($invoic_item as $item)
                                                            <tr>
                                                                <td>{{$item->id}}</td>
                                                                <td>{{$item->variant->product_name}}({{$item->variant->variant??''}})</td>
                                                                <td class="d-none d-sm-table-cell">{!!$item->description !!}</td>
                                                                <td>{{$item->unit_price}}
                                                                <td>{{$item->quantity}}</td>
                                                                <td>{{$item->unit->unit}}</td>
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
                                                    Delivery Fee: <p class="ml-2 mb-0 font-weight-bold"> {{$detail_inv->delivery_fee}} MMK </p>
                                                </div>

                                            </li>
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-end mb-2">
                                                    Grand Total: <p class="ml-2 mb-0 font-weight-bold">  {{$detail_inv->grand_total}} MMK</p>
                                                </div>

                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-12 col-12 col-md-12">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center p-4">
                                            <div class="flex align-items-start flex-column col-12">
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
        </div>
        <div id="print_me"  style="visibility: hidden">

            <script src="{{url(asset('js/html2pdf.js'))}}"></script>
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
                    html2pdf().from(element).save('{{$detail_inv->invoice_id}}');
                }


                $(document).ready(function () {
                    var item_id=$('#variant_id option:selected').val();
                    @foreach($invoic_item as $item)
                    if(item_id=='{{$item->variant->id}}') {
                        $('#unit').val('{{$item->unit->unit}}');
                        $('#unit_id').val({{$item->sell_unit}});
                        $('#stockout_qty').val({{$item->quantity}});
                        $('#real_qty').val({{$item->quantity}});
                    }
                    @endforeach
                    $('#variant_id').on('change',function () {
                        var item_id=$('#variant_id option:selected').val();
                        @foreach($invoic_item as $item)
                        if(item_id=='{{$item->variant->id}}') {
                            $('#unit').val('{{$item->unit->unit}}');
                            $('#unit_id').val({{$item->sell_unit}});
                            $('#stockout_qty').val({{$item->quantity}});
                            $('#real_qty').val({{$item->quantity}});
                        }
                        @endforeach
                    });


                });
            </script>
        </div>
    </div>
    <!-- /Page Content -->
@endsection
