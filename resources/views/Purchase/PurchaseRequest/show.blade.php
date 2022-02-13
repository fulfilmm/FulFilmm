@extends('layout.mainlayout')
@section('title','Purchase Request')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Purchase Request View</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('purchase_request.index')}}">Purchase Request</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <div class="col-12">
                      @if($prs->status=='Approved')
                        <a href="{{route('rfq.prepare',$prs->id)}}" class="btn btn-success btn-sm rounded-pill shadow-sm">Prepare For RFQs</a>
                        <a href="{{route('purchaseorders.create')}}" class="btn btn-white btn-sm rounded-pill shadow-sm">Create Order</a>
                        @endif
                          <a href="{{route('purchase_request.edit',$prs->id)}}" class="btn btn-secondary btn-sm rounded-pill"><i class="fa fa-edit mr-2 ml-2"></i>Edit</a>
                        <div class="dropdown action-label" id="status_div">
                            <a class="btn btn-white btn-sm btn-rounded " href="#"
                               data-toggle="dropdown" aria-expanded="false" id="status"><i
                                        class="fa fa-dot-circle-o mr-1"
                                        style="color:{{$prs->status=='New'?'#909396':($prs->status=='Approved'?'#81E886':($prs->status=='Pending'?'#36D8FF':'Red'))}}"></i>{{$prs->status}}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="status">

                                @foreach($statuses as $key=>$val)
                                    <a class="dropdown-item" href="#" id="status_{{$key}}" role="button" ><i
                                                class="fa fa-dot-circle-o mr-1"
                                                style="color:{{$val=='New'?'#909396':($val=='Approved'?'#81E886':($val=='Pending'?'#36D8FF':'Red'))}}"></i>{{$val}}
                                    </a>
                                    <script>
                                        $(document).on('click', '#status_{{$key}}', function () {
                                            @if(\Illuminate\Support\Facades\Auth::guard('employee')->user()->id==$prs->approver_id)
                                            $.ajax({
                                                data: {
                                                    status:"{{$val}}"

                                                },
                                                type: 'POST',
                                                url: "{{url('pr/status/'.$prs->id)}}",
                                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                success: function (data) {
                                                    console.log(data);
                                                    location.reload();

                                                }
                                            });
                                            @else
                                            swal('Your Are Not Approver', 'You can not change status in this Purchase Request', 'error');
                                            @endif
                                        });
                                    </script>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-md-8">
                <div class="card ">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="" class="text-muted">Approver : </label>
                                {{$prs->approver->name}}</div>
                            <div class="col-md-4">
                                <label for="" class="text-muted">Purchasing Type :</label>
                                {{$prs->type}}
                            </div>
                            <div class="col-md-4"><label for="" class="text-muted">Vendor :</label>
                                {{$prs->Vendor->name}}</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4>Items</h4>
                        <table class="table">
                            <thead>
                            <th scope="col" style="min-width: 200px;">Product</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            </thead>
                            <tbody id="tbody">
                            @foreach($items as $item)

                                <tr>
                                    <td>{{$item->product->name}}</td>
                                    <td>{{$item->description??''}}</td>
                                    <td>{{$item->qty??''}}</td>
                                    <td>{{$item->price??''}}</td>
                                    <td>{{$item->total??''}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tr>
                                <td></td>
                                <td></td>

                                <th>Grand Total</th>

                                <td id="" colspan="2">{{$grand_total}}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                    <div class="card">
                        <div class="card-header">
                            Attachment File
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($attach as $key=>$val)
                                    <ul class="files-list">
                                        @if($prs->attach!=null)
                                            <li>
                                                <div class="files-cont">
                                                    <div class="file-type">
                                                                    <span class="files-icon"><i
                                                                                class="fa fa-file-pdf-o"></i></span>
                                                    </div>
                                                    <div class="files-info">
                                                                    <span class="file-name text-ellipsis"><a
                                                                                href="">{{$val}}</a></span>
                                                        <span class="file-date">{{$prs->created_at}}</span>
                                                        <div class="file-size"></div>
                                                    </div>
                                                    <a class="dropdown-item"
                                                       href="{{url(asset("/attach_file/$val"))}}"><i class="fa fa-download mr-1"></i>Download</a>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                    @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                <div class="card" style="height: 400px;">
                    <div class="card-header">Comment</div>
                    <div class="chat-contents task-chat-contents">
                        <div class="chat-content-wrap">
                            <div class="chat-wrap-inner">
                                <div class="chat-box">
                                    <div class="chats" id="cmt">
                                        @foreach($comments as $cmt)
                                            <div class="chat chat-left">
                                                <div class="nav float-right custom-menu">
                                                    <a href="{{route('pr_comment.delete',$cmt->id)}}"
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
                                                            <span class="task-chat-user">{{$cmt->emp->name}}</span>
                                                            <span class="chat-time">{{$cmt->created_at->toFormattedDateString()}} at {{date('h:i a', strtotime($cmt->created_at))}}</span>
                                                            <p>{{$cmt->comment}}</p>
                                                        </div>
                                                    </div>
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
                                <form action="{{url("/pr/comment")}}" method="POST" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="message-area">

                                        <div class="input-group">
                                            <input type="hidden" name="pr_id" value="{{$prs->id}}">
                                            <input type="text" class="form-control" name="comment"
                                                   placeholder="Add Note...">
                                            <span class="input-group-append">
                                        <button class="btn btn-primary btn-sm" type="submit">Add</button>
                                    </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection