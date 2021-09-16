@extends('layout.mainlayout')
@section('title','Order View')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Order</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Order</a></li>
                        <li class="breadcrumb-item active">Order Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-3">

                <div class="d-flex justify-content-between float-right ">
                    <div class="dropdown mr-1">
                        <a class="btn btn-outline-info btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{$data["Order"]->status??''}}
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                            @if($data['Order']->status??'Cancel'!="Cancel")
                                <a class="dropdown-item" href="{{url('order/Pending/'.$data["Order"]->id ??'')}}">Pending</a>
                                <a class="dropdown-item" href="{{url('order/Confirm/'.$data["Order"]->id ??'')}}">Confirm</a>
                            @endif
                            @if($data['Order']->status??'Confirm'!="Confirm")
                            <a class="dropdown-item" href="{{url('order/Cancel/'.$data["Order"]->id??'')}}">Cancel</a>
                                @endif
                        </div>
                    </div>

                    <a class="btn btn-primary btn-sm mr-1" href="{{route('generate_inv',$data["Order"]->id??'')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Generate Invoice
                    </a>
                    <div class="bs-offset-main bs-canvas-anim">
                        <button class="btn btn-primary btn-sm" type="button" data-toggle="canvas"
                                data-target="#bs-canvas-left" aria-expanded="false"
                                aria-controls="bs-canvas-right">Assign
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <ul class="list-group list-group-flush mr-1 ml-1">
                        <li class="list-group-item p-3">
                            <h5 class="font-weight-bold pb-2">Order Info</h5>
                            <div class="table-responsive">
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
                                            Invoice
                                        </td>
                                        <td class="text-primary">
                                            {{--<a href="{{route('invoices.show',$data['items'][0]->inv_id)}}">--}}
                                           {{--{{$data['items'][0]->inv_id!=null?$data['items'][0]->invoice->invoice_id:'None'}}--}}
                                            {{--</a>--}}
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
                                    </tbody>
                                </table>
                            </div>
                        </li>
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
                                    </tbody>
                                </table>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card" style="overflow: scroll;height: 550px">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-3">
                            <h5 class="font-weight-bold">Order Items</h5>
                        </li>
                        <li class="list-group-item p-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                    <tr class="text-muted">
                                        <th scope="col">Product</th>
                                        <th scope="col" class="text-right">Quantity</th>
                                        <th scope="col" class="text-right">Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data['items'] as $item)
                                    <tr>
                                        <td>
                                            <div class="active-project-1 d-flex align-items-center mt-0 ">
                                                <div class="h-avatar is-medium">
                                                    <img src="{{url(asset('product_picture/'.$item->product->image))}}" class="avatar rounded" alt="">
                                                </div>
                                                <div class="data-content">
                                                    <div>
                                                        <span class="font-weight-bold">{{$item->product->name}}</span>
                                                    </div>
                                                    <p class="m-0 mt-1">
                                                       {{$item->product->description}}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            {{$item->quantity}}
                                        </td>
                                        <td class="text-right">
                                           {{$item->total}}
                                        </td>
                                    </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </li>
                        <li class="list-group-item p-3">
                            <div class="d-flex justify-content-end">
                                Total: <p class="ml-2 mb-0 font-weight-bold">{{$data['Order']->total_amount}}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 card" style="overflow: scroll;height:400px;">
                <div class="chat-contents task-chat-contents">
                    <div class="chat-content-wrap">
                        <div class="chat-wrap-inner">
                            <div class="chat-box">
                                <div class="chats" id="cmt">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chat-footer">
                    <div class="message-bar">
                        <div class="message-inner">
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
            </div>
            <div class="col-md-8 card">
                <h5 class="font-weight-bold mt-3">Billing And Delivery Details</h5>
                <div class="border rounded-sm">
                   <div class="form-group">
                       <label for="" class="form-label text-muted text-uppercase ml-2 mt-1">Billing Address</label>
                       <p class="ml-3 mb-1">{{$data['Order']->billing_address}}</p>
                   </div>
                </div>
                <div class="border rounded-sm my-1">
                    <div class="form-group">
                        <label for="" class="form-label text-muted text-uppercase ml-2 mt-1">Shipment Type</label>
                        <p class="ml-3">{{$data['Order']->shipping_type}}</p>
                    </div>
                </div>
                @if($data['Order']->shipping_address!=null)
                <div class="border rounded-sm my-1">
                    <div class="form-group">
                        <label for="" class="form-label text-muted text-uppercase ml-2 mt-1">Shipping Address</label>
                        <p class="ml-3">{{$data['Order']->shipping_address}}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div id="bs-canvas-left" class="bs-canvas bs-canvas-anim bs-canvas-right position-fixed  h-100 mt-5"
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
            </script>

        </div>
    </div>
    @endsection