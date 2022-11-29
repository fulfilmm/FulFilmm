@extends('layout.mainlayout')
@section('title','Order View')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Order</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('saleorders.index')}}">Order</a></li>
                        <li class="breadcrumb-item active">Order Details</li>
                    </ul>
                </div>
            </div>product
        </div>
      @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
        <div class="row">

            <div class="col-lg-12 mb-3">
                <div class="d-flex justify-content-between float-left ">
                    <div class="bs-offset-main bs-canvas-anim">
                        <button class="btn btn-white btn-sm  float-left mr-2" type="button" data-toggle="canvas"
                                data-target="#bs-canvas-left" aria-expanded="false"
                                aria-controls="bs-canvas-right"><i class="fa fa-comment "></i>
                        </button>
                    </div>
                    <a class="btn btn-success btn-sm" href="{{route('saleorders.edit',$data['Order']->id)}}">
                    <span class="float-left" type="button" ><i class="fa fa-edit"></i>
                    </span>
                    </a>
                </div>
                <div class="d-flex justify-content-between float-right ">

                    <div class="dropdown mr-1">
                        <a class="btn btn-outline-{{$data["Order"]->status=='Confirm'?'success':($data["Order"]->status=='Cancel'?'danger':'info')}} btn-sm btn-rounded  dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-dot-circle-o mr-1 text-{{$data["Order"]->status=='Confirm'?'success':($data["Order"]->status=='Cancel'?'danger':'info')}}"></i> {{$data["Order"]->status??''}}
                        </a>

                        <div class="dropdown-menu rounded bg-cyan" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{url('order/Pending/'.$data["Order"]->id ??'')}}"><i class="fa fa-dot-circle-o mr-1 text-primary"></i>Pending</a>
                            <a class="dropdown-item" href="{{url('order/Confirm/'.$data["Order"]->id ??'')}}"><i class="fa fa-dot-circle-o mr-1 text-success"></i>Confirm</a>

                            <a class="dropdown-item" href="{{url('order/Cancel/'.$data["Order"]->id??'')}}"><i class="fa fa-dot-circle-o mr-1 text-danger"></i>Cancel</a>

                        </div>
                    </div>
                   @if($data["Order"]->status=='Confirm')
                        <a class="btn btn-primary btn-sm mr-1 shadow-sm btn-rounded" href="{{route('generate_inv',$data["Order"]->id??'')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Generate Invoice
                        </a>
                       @endif

                    <div class="bs-offset-main bs-canvas-anim">
                        <button class="btn btn-primary btn-sm shadow-sm btn-rounded" type="button" data-toggle="canvas"
                                data-target="#bs-canvas-right" aria-expanded="false"
                                aria-controls="bs-canvas-right">Assign
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <input type="hidden" id="order_id" value="{{$data['Order']->id}}">
        <div class="row">
            <div class="col-lg-6" id="refreshDiv">
                <div class="card shadow">
                    <ul class="list-group list-group-flush mr-1 ml-1">
                        <li class="list-group-item p-3">
                            <h5 class="font-weight-bold pb-2">Order Info</h5>
                            <div class="table-responsive" >
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                            ID
                                        </td>
                                        <td>
                                            {{$data['Order']->order_id??''}}
                                        </td>
                                    </tr>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                            Date &#38; Time
                                        </td>
                                        <td>
                                           {{$data['Order']->order_date??''}}
                                        </td>
                                    </tr>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                            Payment Method
                                        </td>
                                        <td>
                                            {{$data['Order']->payment_method??''}}
                                        </td>
                                    </tr>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                            Quotation ID
                                        </td>
                                        <td class="text-primary">
                                            @if($data['Order']->quotation_id!=null)
                                                <a href="{{route('quotations.show',$data['Order']->quotation->id)}}">
                                                    {{$data["Order"]->quotation->quotation_id}}
                                                </a>
                                                @else
                                                None
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                            Follower
                                        </td>
                                        <td>
                                            @if(count($data['Order']->follower)==0)
                                                Empty Follower
                                                @else
                                                @foreach($data['Order']->follower as $item)
                                                    {{$item->emp_name}}
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                            Assigned
                                        </td>
                                        <td>
                                            @switch($data['assign_info']->assign_type??'')
                                                @case('emp')
                                                {{$data['assign_info']->employee->name}}
                                                @break
                                                @case('dept')
                                                {{$data['assign_info']->department->name}}
                                                @break
                                                @case('group')
                                                {{$data['assign_info']->group->name}}
                                                @break
                                                @default
                                                None
                                                @endswitch
                                        </td>
                                    </tr>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                            Status
                                        </td>
                                        <td>
                                            <p class="mb-0 text-success font-weight-bold d-flex justify-content-start align-items-center">
                                                <small><i class="fa fa-dot-circle-o mr-2"></i></small>{{$data['Order']->status}}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                            Total Cost
                                        </td>
                                        <td>
                                            <p class="mb-0 text-danger font-weight-bold d-flex justify-content-start align-items-center">
                                                {{number_format($data['Order']->grand_total)}} MMK
                                            </p>
                                        </td>
                                    </tr>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                         Sale Type
                                        </td>
                                        <td>
                                            <p class="mb-0  font-weight-bold d-flex justify-content-start align-items-center">
                                                {{$data['Order']->sales_type??'N/A'}}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>


                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <ul class="list-group list-group-flush mr-1 ml-1">
                        <li class="list-group-item p-3">
                            <h5 class="font-weight-bold pb-2">Customer Details</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                            Name
                                        </td>
                                        <td>
                                            {{$data['Order']->customer->name}}
                                        </td>
                                    </tr>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                            Email
                                        </td>
                                        <td>
                                            {{$data['Order']->email}}
                                        </td>
                                    </tr>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                            Phone
                                        </td>
                                        <td>
                                            {{$data['Order']->phone}}
                                        </td>
                                    </tr>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                            Address
                                        </td>
                                        <td>
                                            {{$data['Order']->address}}
                                        </td>
                                    </tr>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                            Billing Address
                                        </td>
                                        <td>
                                            {{$data['Order']->address}}
                                        </td>
                                    </tr>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                            Shipment Type
                                        </td>
                                        <td>
                                            {{$data['Order']->address}}
                                        </td>
                                    </tr>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                            Shipping Address
                                        </td>
                                        <td>
                                            {{$data['Order']->address}}
                                        </td>
                                    </tr>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                            Remark
                                        </td>
                                        <td>
                                            {{$data['Order']->comment}}
                                        </td>
                                    </tr>
                                    <tr class="white-space-no-wrap">
                                        <td class="text-muted pl-0">
                                            Advance Payment
                                        </td>
                                        <td>
                                            <p class="mb-0 text-danger font-weight-bold d-flex justify-content-start align-items-center">
                                                {{number_format($data['advance_pay']->amount??0)}} MMK
                                            </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-12">
               <div class="card shadow">
                   <div class="card-header">
                       Order Items
                   </div>
                   <div class="col-12 my-3">
                       <div class="table-responsive">
                           {{--@if(!$data['Order']->status=='Confirm')--}}
                           {{--@if(!isset($order_data))--}}
                           {{--<div class="form-group">--}}
                           {{--<label for="">Add Item</label>--}}
                           {{--<select name="" id="product" class="form-control" style="min-width: 150px;">--}}
                           {{--<option value="">Select Product</option>--}}
                           {{--@foreach($data['product'] as $product)--}}
                           {{--<option value="{{$product->id}}">{{$product->name}}</option>--}}
                           {{--@endforeach--}}
                           {{--</select>--}}
                           {{--</div>--}}
                           {{--@endif--}}
                           {{--@endif--}}
                           <table class="table table-hover table-white" id="order_table">
                               <thead>
                               <th colspan="3">Product</th>
                               <th>Quantity</th>
                               <th>Price</th>
                               <th>Unit</th>
                               <th>Discount/Promotion</th>
                               <th>Total</th>
                               </thead>
                               <tbody id="tbody">
                               <input type="hidden" id="creation_id" value="{{$data['items'][0]->creation_id??$data['Order']->id}}">
                               @foreach($data['items'] as $order)
                                   <tr>
                                       <td style="min-width: 200px;" colspan="3">

                                           <input type="hidden" id="order_id_{{$order->id}}" value="{{$order->id}}">
                                           <div class="row">
                                               <div class="col-md-4">
                                                   <img src="{{url(asset('product_picture/'.$order->variant->image))}}"  alt="" width="40px" height="40px">
                                               </div>
                                               <div class="col-8">
                                                   <div>
                                                       <span class="font-weight-bold">{{$order->variant->product_name}}</span>
                                                   </div>
                                                   <p class="m-0 mt-1">
                                                       {!! $order->description !!}
                                                   </p>
                                               </div>
                                           </div>
                                       </td>
                                       <td>
                                           {{$order->quantity}}
                                       </td>
                                       <td>
                                           {{$order->unit_price}}
                                       </td>
                                       <td>{{$order->unit->unit??'N/A'}}</td>
                                       <td>{{$order->discount_promotion==0?'N/A':$order->discount_promotion.'%'}}</td>
                                       <td>
                                           {{number_format($order->total)}}</td>
                                   </tr>
                               @endforeach

                               </tbody>
                               <tr>
                                   <td colspan="2"></td>
                                   <th colspan="5" class="text-right"><span class="mt-5">Total</span></th>
                                   <td id="" colspan="2">{{$data['Order']->total}}
                                   </td>
                               </tr>
                               <tr>
                                   <td colspan="2"></td>
                                   <th colspan="5" class="text-right"><span class="mt-5">Discount</span></th>

                                   <td id="discount_div" colspan="2">{{$data['Order']->discount??0}} MMK</td>
                               </tr>
                               <tr>
                                   <td colspan="2"></td>
                                   <th colspan="5" class="text-right"><span class="mt-5">Tax</span></th>
                                   <td id="tax" colspan="2">
                                       {{$data['Order']->tax_amount}} ({{$data['Order']->tax->name}} {{$data['Order']->tax->rate}}%)
                                       <input type="hidden" id="tax_amount" name="tax_mount">
                                   </td>
                               </tr>

                               <tr>
                                   <td colspan="2"></td>
                                   <th colspan="5" class="text-right"><span class="mt-5">Grand Total</span></th>
                                   <td colspan="2" id="grand_total_div">
                                       {{number_format($data['Order']->grand_total)}} MMK
                                   </td>
                                   <td></td>

                               </tr>
                           </table>
                       </div>
                   </div>
               </div>
            </div>
        </div>
        <div id="bs-canvas-right" class="bs-canvas bs-canvas-anim bs-canvas-right position-fixed  h-100 mt-5"
             style="max-width: 350px;background-color:#d7dbe0">
            <header class="bs-canvas-header p-3 overflow-auto">
                <button type="button" class="bs-canvas-close float-left close " aria-label="Close"><span aria-hidden="true"
                                                                                                         class="text-dark">&times;</span>
                </button>
                <h4 class="d-inline-block text-dark mb-0 float-left ml-5">Assign Order</h4>
            </header>
            <div class="bs-canvas-content px-3 py-2">
                <form action="{{route('order.assign',$data['Order']->id)}}" method="post">
                    @csrf
                    <div class="form-group ">
                        <label for="">Assign Type</label>
                        <select class="form-control type"
                                id="assign_type"
                                name="assignType"
                                style="width: 100%">
                            <option value="item0">Choose Assign
                                Type
                            </option>
                            <option value="emp">Employee
                            </option>
                            <option value="dept">Department
                            </option>
                            <option value="group">Group
                            </option>
                        </select>
                        <span class="text-danger assing_type_err"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Assign To</label>
                        <select name="assign_id"
                                id="assign_to"
                                class="form-control assign_to"
                                style="width: 100%;" required>
                            <option></option>
                        </select>
                        <span class="text-danger assign_to_err"></span>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-outline-danger ml-2 text-center" id="add">Assign</button>
                    </div>
                </form>
            </div>
            <script>
                $(document).ready(function () {
                    $("#assign_type").change(function () {
                        var val = $(this).val();
                        if (val == "dept") {
                            $("#assign_to").html("@foreach($data['dept'] as $key=>$val)<option value='{{$key}}'>{{$val}}</option> @endforeach");
                        } else if (val == "emp") {
                            $("#assign_to").html("@foreach($data['emp'] as $key=>$val)<option value='{{$key}}'>{{$val}}</option> @endforeach");
                        }else if (val == "group") {
                            $("#assign_to").html("@foreach($data['group'] as $key=>$val)<option value='{{$key}}'>{{$val}}</option> @endforeach")
                        }else {
                            $("#assign_to").html("<option></option>")
                        }
                    });
                });
                {{--$(document).ready(function () {--}}
                    {{--$(document).on('change','#product',function (){--}}
                        {{--var creation_id = $('#creation_id').val();--}}
                        {{--var order_id=$('#order_id').val();--}}
                        {{--var product = $('#product option:selected').val();--}}
                        {{--var grand_total=$('#grand_total').val();--}}
                        {{--$.ajax({--}}
                            {{--data: {--}}
                                {{--"product_id":product,--}}
                                {{--"invoice_id":creation_id,--}}
                                {{--'order_id':order_id,--}}
                                {{--'grand_total':grand_total,--}}

                            {{--},--}}
                            {{--type: 'POST',--}}
                            {{--url: "{{route('invoice_items.store')}}",--}}
                            {{--headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},--}}
                            {{--success: function (data) {--}}
                                {{--console.log(data);--}}
                                {{--$("#order_table").load(location.href + " #order_table>* ");--}}
                                {{--$("#grand_total_div").load(location.href + " #grand_total_div>* ");--}}
                                {{--var alltotal = [];--}}
                                {{--$('.total').each(function () {--}}
                                    {{--alltotal.push(this.value);--}}
                                {{--});--}}
                                {{--var grand_total = 0;--}}
                                {{--for (var i = 0; i < alltotal.length; i++) {--}}
                                    {{--grand_total = parseFloat(grand_total) + parseFloat(alltotal[i]);--}}
                                {{--}--}}
                                {{--$('#grand_total').val(grand_total);--}}
                                {{--location.reload();--}}

                            {{--}--}}
                        {{--});--}}
                    {{--});--}}
                {{--});--}}
            </script>

        </div>
        <div id="bs-canvas-left" class="bs-canvas bs-canvas-anim bs-canvas-left position-fixed  h-100 mt-5"
             style="max-width: 350px;background-color:#d7dbe0">
            <header class="bs-canvas-header p-3 overflow-auto">
                <button type="button" class="bs-canvas-close float-right close " aria-label="Close"><span aria-hidden="true"
                                                                                                         class="text-dark">&times;</span>
                </button>
                <h4 class="d-inline-block text-dark mb-0 float-left ml-5">Comments</h4>
            </header>
            <div class="bs-canvas-content px-3 py-2">
                @foreach($data['comments'] as $cmt)
                    <div class="chat chat-left">
                        <div class="nav float-right custom-menu">
                            <a href="{{route('order_comment.delete',$cmt->id)}}"
                               class="followers-add" data-toggle="tooltip"
                               data-placement="bottom"><i class="la la-trash-o"></i></a>
                        </div>
                        <div class="chat-avatar">
                            <a href="#" class="avatar">
                                <img src="{{url(asset('img/profiles/avatar-02.jpg'))}}" alt="">
                            </a>
                        </div>
                        <div class="chat-body">
                            <div class="chat-bubble">
                                <div class="chat-content">
                                    <span class="task-chat-user">{{$cmt->employee->name}}</span>
                                    <span class="chat-time">{{$cmt->created_at->toFormattedDateString()}} at {{date('h:i a', strtotime($cmt->created_at))}}</span>
                                    <p>{{$cmt->comment_text}}</p>
                                </div>
                            </div>
                            @if($cmt->document!=null)
                                <ul class="attach-list">
                                    <li class="pdf-file"><i class="fa fa-file-pdf-o"></i> <a
                                                href="{{url(asset('ticket_attach/'.$cmt->document_file))}}"
                                                download="">{{$cmt->document_file}}</a></li>
                                </ul>
                            @endif
                        </div>

                    </div>
                @endforeach
                    <form action="{{route('orders.comment')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="message-area">
                            <input type="hidden" name="order_id" value="{{$data['Order']->id}}">
                            <div class="input-group col-12">
                                <input type="text" class="form-control" name="comment_text"
                                       placeholder="Add Note...">
                                <span class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="la la-plus"></i></button>
                                    </span>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>

    @endsection