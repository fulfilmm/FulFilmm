@extends('layout.mainlayout')
@section('title','Product Receive')
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
        <form  method="post" name="validate">
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
                    @else
                        <button type="submit" formaction="{{route('product.validate',$receipt->id)}}" class="btn btn-primary btn-sm">Validate</button>
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
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--@dd($receipt_item);--}}
                                @foreach($receipt_item as $item)
                                    <tr>
                                        <td>
                                            {{$item->product->product_name}}({{$item->product->variant}})
                                        </td>
                                        <td>
                                            @if($receipt->is_validate==1)
                                                {{$item->demand}}
                                            @else
                                                <input type="number" name="demand[]" class="form-control"
                                                       value="{{$item->demand}}"></td>
                                        @endif
                                        <td>{{$item->product_unit->unit}}</td>
                                        <td>
                                            @if($receipt->is_validate==1)
                                                {{$item->qty}}
                                            @else
                                                @php
                                                 $receive_qty=($item->product_unit->unit_convert_rate) * ($item->demand);
                                                @endphp
                                                <input type="text" name="done[]" class="form-control"
                                                       value="{{$receive_qty}}">

                                        @endif
                                        </td>
                                        <td>
                                            @foreach($sell_unit as $unit)
                                                @if($item->product->product_id==$unit->product_id)
                                                    {{$unit->unit}}
                                                    @endif
                                                @endforeach
                                        </td>
                                        <td>


                                                <button type="button" class="btn btn-primary btn-sm {{$receipt->is_validate==1?'':'disabled'}} {{$item->is_stocked_in==1?'disabled':''}}" data-toggle="modal" data-target="#stockin_{{$item->id}}">
                                                   <i class="la la-plus"></i> Stock In
                                                </button>
                                        @if($receipt->is_validate==1)
                                                <!-- Modal -->
                                                <div class="modal fade" id="stockin_{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Stock In</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form method="POST" name="stockin">
                                                            <div class="modal-body">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <input type="hidden" name="receive_id" value="{{$item->id}}">
                                                                            <div class="form-group">
                                                                                <label for="warehouse">Product</label>
                                                                                <input type="text" class="form-control" value="{{$item->product->product_name}}({{$item->product->variant}})">
                                                                                <input type="hidden" name="product_id" value="{{$item->variant_id}}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="customer">Supplier</label>
                                                                                <select name="supplier_id" id="customer" class="form-control">
                                                                                    <option value="{{$receipt->vendor->id}}">{{$receipt->vendor->name}}</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="exp_date">Expired Date</label>
                                                                                <input type="date" class="form-control" name="exp_date" id="exp_date">
                                                                                @error('exp_date')
                                                                                <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="exp_date">Alert Month</label>
                                                                                <input type="text" class="form-control" name="alert_month" id="alert_month{{$item->id}}" value="{{old('alert_month')}}" dataformatas="Y-M">
                                                                                @error('alert_month')
                                                                                <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="branch">Office Branch</label>
                                                                                <select name="branch_id" id="branch" class="form-control" onchange="branch_select(this.value)">
                                                                                    @foreach($branch as $brch)
                                                                                        <option value="{{$brch->id}}" {{$brch->id==old('branch_id')?'selected':''}}>{{$brch->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="warehouse">Warehouse</label>
                                                                                <select name="warehouse_id" id="warehouse" class="form-control">
                                                                                    @foreach($warehouse as $key=>$val)
                                                                                        <option value="{{$key}}">{{$val}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Quantity</label>
                                                                                <input type="number" name="qty" class="form-control" value="{{$item->qty}}">
                                                                                @error('qty')
                                                                                <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="value">Purchase Price</label>
                                                                                <input type="number" name="purchase_price" class="form-control" placeholder="Enter Purchase Price" value="{{$item->price}}">
                                                                                @error('purchase_price')
                                                                                <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                         <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="loca">Location</label>
                                                                            <input type="text" class="form-control" name="product_location" placeholder="Enter product location in warehouse">
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary" formaction="{{route('stockin')}}" id="stock_submit">Stock In</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <script>
                                                        $(document).ready(function () {
                                                            $(".ui-datepicker-calendar").hide();
                                                            $('#alert_month{{$item->id}}').datepicker({
                                                                changeYear: true,
                                                                changeMonth:true,
                                                                changeCalender:false,
                                                                showButtonPanel: true,
                                                                dateFormat: 'yy-mm',
                                                                onClose: function(dateText, inst) {
                                                                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                                                                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                                                                    $(this).datepicker('setDate', new Date(year,month));
                                                                }
                                                            });
                                                            $("#datepicker").focus(function() {
                                                                $(".ui-datepicker-month").show();
                                                                $(".ui-datepicker-calender").hide();

                                                            });
                                                        });
                                                    </script>
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
        <!-- Button trigger modal -->
        <div id="print_me"  style="visibility: hidden">
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