@extends('layout.mainlayout')
@section('title','RFQs')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Product Receive</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Product Receive</li>
                    </ul>
                </div>
            </div>
        </div>
        <form action="{{route('product.validate',$receipt->id)}}" method="post">
            @csrf
            <div class="col-12 border-bottom mb-3">
                {{--<div class="row my-3">--}}
                {{--<div class="col-12">--}}
                {{--<button class="btn btn-primary btn-sm">Save</button>--}}
                {{--<button class="btn btn-primary btn-sm">Create</button>--}}
                {{--</div>--}}
                {{--</div>--}}

                <div class="my-2">

                    @if($receipt->is_validate==1)
                        @if($receipt->inprogress==1)
                            <a href="{{route('receipt.rededit',$receipt->id)}}" class="btn btn-info btn-sm">Edit</a>
                            @endif
                        <button type="button" id="create_pdf" class="btn btn-danger btn-sm">PDF Download</button>
                        <button type="button"  id="print" onclick="printContent('print_me');" class="btn btn-white btn-sm"><i class="fa fa-print"></i>Print</button>
                        <a href="{{url('add/to/stock/'.$receipt->id)}}" class="btn btn-success btn-sm">Add To Stock</a>
                    @else
                        <button type="submit" class="btn btn-primary btn-sm">Validate</button>
                    @endif
                </div>
            </div>
            <div class="col-12 form">
                <div  id="print_me">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>{{$receipt->received_id}}</h4>
                        </div>
                        <div class="col-md-6">
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <span class="text-muted">Supplier Name</span>
                                </div>
                                <div class="col-md-6">
                                    {{$receipt->vendor->name}}
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <span class="text-muted">Supplier Email</span>
                                </div>
                                <div class="col-md-6">
                                    {{$receipt->vendor->email}}
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <span class="text-muted">Supplier Phone</span>
                                </div>
                                <div class="col-md-6">
                                    {{$receipt->vendor->phone}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mt-3">
                                <div class="col-md-12"></div>
                                <div class="col-md-4 ">
                                    <span class="text-muted">Schedule Date</span>
                                </div>
                                <div class="col-md-6">
                                    @if($receipt->is_validate==1)
                                        {{\Carbon\Carbon::parse($receipt->schedule_date)->format('Y-m-d')}}
                                    @else
                                        <input type="date" class="form-control" name="schedule_date"
                                               value="{{\Carbon\Carbon::parse($receipt->schedule_date)->format('Y-m-d')}}">
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12"></div>
                                <div class="col-md-4 ">
                                    <span class="text-muted">Deadline</span>
                                </div>
                                <div class="col-md-6">
                                    @if($receipt->is_validate==1)
                                        {{\Carbon\Carbon::parse($receipt->deadline)->format('Y-m-d')}}
                                    @else
                                        <input type="date" class="form-control" name="deadline"
                                               value="{{\Carbon\Carbon::parse($receipt->deadline)->format('Y-m-d')}}">
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12"></div>
                                <div class="col-md-4 ">
                                    <span class="text-muted">Source</span>
                                </div>
                                <div class="col-md-6">
                                    @if($receipt->is_validate==1)
                                        {{$receipt->purchaseorder->purchaseorder_id}}
                                    @else
                                        <span><input type="text" name="source" class="form-control"
                                                     value="{{$receipt->purchaseorder->purchaseorder_id}}"></span>
                                    @endif
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
                                    <th>Demand</th>
                                    <th>Demand Unit</th>
                                    <th>Done</th>
                                    <th>Default Unit</th>
                                    <th>Warehouse</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($receipt_item as $item)
                                    <tr>
                                        <td>
                                            @foreach($product as $key=>$val)
                                                @if($key==$item->product->product_id)
                                                    {{$val}}
                                                    @if($item->product->color!=null||$item->product->size!=null||$item->product->other!=null)
                                                        ({{$item->product->color}} {{$item->product->size}} {{$item->product->other}})
                                                    @endif
                                                    @endif
                                                @endforeach
                                        </td>
                                        <td>
                                            @if($receipt->is_validate==1)
                                                {{$item->demand}}
                                            @else
                                                <input type="number" name="demand[]" class="form-control"
                                                       value="{{$item->demand}}"></td>
                                        @endif
                                        <td>{{$item->unit}}</td>
                                        <td>
                                            @if($receipt->is_validate==1)
                                                {{$item->qty}}
                                            @else
                                                <input type="text" name="done[]" class="form-control"
                                                       value="{{$item->demand}}">

                                        @endif
                                        </td>
                                        <td>Default Unit</td>
                                        <td>
                                            @if($receipt->is_validate==1)
                                                {{$item->warehouse->name??''}}
                                                @else
                                                <select name="warehouse_id[]" id="" class="select2 form-control" required>
                                                    <option value="">Select Warehouse</option>
                                                    @foreach($warehouse as $key=>$val)
                                                        <option value="{{$key}}">{{$val}}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div id="print_me"  style="visibility: hidden">
            <div id="store" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Store To Stock</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group ">
                                <div class="row">
                                    <label class="col-md-3">Product</label>
                                    <div class="col-md-9">
                                        <select name="[]" id="product{{$item->id}}"
                                                class="form-control select2 update{{$item->id}}">
                                            @foreach($product as $key=>$value)
                                                <option value="{{$key}}" {{$key==$item->product_id?'selected':''}}>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="" class="col-md-3">Description</label>
                                    <div class="col-md-9">
                                                                    <textarea name="" id="desc{{$item->id}}" cols="30" rows="2"
                                                                              class="form-control col-md-8 update{{$item->id}}">{{$item->description}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="" class="col-md-3">Qty</label>
                                    <div class="col-md-9">
                                        <input type="number" id="qty{{$item->id}}"
                                               class="form-control update{{$item->id}}"
                                               name="qty"
                                               value="{{$item->qty??''}}"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="" class="col-md-3">Price</label>
                                    <div class="col-md-9">
                                        <input type="number" id="price{{$item->id}}"
                                               class="form-control update{{$item->id}}"
                                               name="price"
                                               value="{{$item->price??''}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="" class="col-md-3">Total</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text"
                                               id="total{{$item->id}}"
                                               value="{{$item->total??''}}">
                                    </div>
                                </div>
                            </div>
                            <button id="update_item{{$item->id}}" data-dismiss="modal"
                                    class="btn btn-primary float-right">Save
                            </button>
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
                a4 = [590.28, 841.89]; // for a4 size paper width and height

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
                            unit: 'px'
                        });
                    doc.addImage(img, 'JPEG', 20, 20);
                    doc.save('{{$receipt->received_id}}.pdf');
                    form.width(cache_width);
                });
            }

            // create canvas object
            function getCanvas() {
                form.width((a4[0] * 1.33333) - 60).css('max-width', 'none');
                return html2canvas(form, {
                    imageTimeout: 2000,
                    removeContainer: true
                });
            }

        }());
        function printContent(el) {
            // document.title = ;
            var restorepage = $('body').html();
            $('#myTab').remove();
            var printcontent = $('#' + el).clone();
            $('body').empty().html(printcontent);
            $('.footer').hide();
            window.print();
            $('body').html(restorepage);
        }
    </script>
@endsection