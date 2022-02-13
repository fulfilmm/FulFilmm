@extends('layout.mainlayout')
@section('title','RFQs')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">RFQ View</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">RFQ</li>
                    </ul>
                </div>
            </div>
        </div>
{{--        {{$rfq->status}}--}}

       <div class="row">
           <div class="col-md-10">
               <div class="card shadow form">
                   <div class="col-12 my-5">
                       <div class="row">
                           <div class="col-md-12">
                               <span>Request For Quotation</span>
                               <h4>{{$rfq->purchase_id}}</h4>
                           </div>
                           <div class="col-md-6">
                               <div class="row mt-3">
                                   <div class="col-md-6">
                                       <span class="text-muted">Vendor</span>
                                   </div>
                                   <div class="col-md-6">
                                       {{$rfq->vendor->name}}
                                   </div>
                               </div>
                               <div class="row mt-3">
                                   <div class="col-md-6">
                                       <span class="text-muted">Vendor Reference</span>
                                   </div>
                                   <div class="col-md-6">
                                       {{$rfq->vendor_reference}}
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-6">
                               @if($rfq->status=='Confirm Order')
                                   <div class="row mt-3">
                                       <div class="col-md-12"></div>
                                       <div class="col-md-4 offset-md-2">
                                           <span class="text-muted">Confirm Date</span>
                                       </div>
                                       <div class="col-md-6">
                                           <span>{{\Carbon\Carbon::parse($rfq->confirm_date)->toFormattedDateString()}}</span>
                                       </div>
                                   </div>
                               @else
                                   <div class="row mt-3">
                                       <div class="col-md-12"></div>
                                       <div class="col-md-4 offset-md-2">
                                           <span class="text-muted">Deadline</span>
                                       </div>
                                       <div class="col-md-6">
                                           <span>{{\Carbon\Carbon::parse($rfq->deadline)->toFormattedDateString()}}</span>
                                       </div>
                                   </div>
                               @endif
                               <div class="row mt-3">
                                   <div class="col-md-12"></div>
                                   <div class="col-md-4 offset-md-2">
                                       <span class="text-muted">Receipt Date</span>
                                   </div>
                                   <div class="col-md-6">
                                       <span>{{\Carbon\Carbon::parse($rfq->receipt_date)->toFormattedDateString()}}</span>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="row my-5">
                           <div class="col-md-12">
                               <table class="table">
                                   <thead>
                                   <tr>
                                       <th>Product</th>
                                       <th>Description</th>
                                       <th>Quantity</th>
                                       <th>Price</th>
                                       <th>SubTotal</th>
                                   </tr>
                                   </thead>
                                   <tbody>
                                   @foreach($rfq_items as $item)
                                       <tr>
                                           <td>{{$item->product->name??''}}</td>
                                           <td>{{$item->description}}</td>
                                           <td>{{$item->qty}}</td>
                                           <td>{{$item->price}}</td>
                                           <td>{{$item->total}}</td>
                                       </tr>
                                   @endforeach
                                   </tbody>
                               </table>
                           </div>
                           <div class="col-12">
                               <h4>Description</h4>
                               <p>{{$rfq->description}}</p>
                           </div>
                       </div>
                   </div>

               </div>
           </div>
           <div class="col-md-2">
               <div class="card shadow">
                 <div class="col-12">
                     <a href="" class="btn btn-primary btn-sm col-12 my-2"><i class="fa fa-edit"></i> Edit</a>
                     <a href="{{route('rfq.preparemail',$rfq->id)}}"  class="btn btn-primary btn-sm col-12 my-2">{{$rfq->status=='RFQ Sent'?'Re-Sent':'SEND EMAIL'}}</a>
                     <a href="{{route('rfq.statuschange',[$rfq->id,'Cancel'])}}" class="btn btn-primary btn-sm col-12 my-2">CANCEL</a>
                     @if($rfq->status=='RFQ Sent'||$rfq->status='Daft')
                         <a href="{{route('rfq.statuschange',[$rfq->id,'Confirm Order'])}}" class="btn btn-primary btn-sm col-12 my-2">CONFIRM </a>
                     @endif
                     <button class="btn btn-danger btn-sm col-12 my-2" type="button" id="create_pdf"><i class="fa fa-file-pdf-o mr-2"></i>PDF</button>
                 </div>
               </div>
           </div>
       </div>
    </div>
    <script>
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
                    doc.save('{{$rfq->purchase_id}}.pdf');
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
@endsection