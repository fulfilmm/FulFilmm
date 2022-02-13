@extends('layout.mainlayout')
@section('title','Expense Claim')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Expense Claim</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item float-right">Expense Claim</li>
                        <li class="breadcrumb-item float-right">Show</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="">
            <div class="card-header">
                <div class="row">
                    <div class="col-12">
                        <span>Approver :</span><span>{{$exp_claim->approver->name}}</span>
                        <span class="ml-5">Finical Approver :</span><span>{{$exp_claim->finance_approver->name}}</span>
                        <div class="dropdown action-label float-right">
                            <a class="btn btn-white btn-sm btn-rounded {{\Illuminate\Support\Facades\Auth::guard('employee')->user()->id==$exp_claim->approver_id?'dropdown-toggle':''}}" href="#" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-square{{$exp_claim->is_claim?'check':'close'}}"></i> {{$exp_claim->is_claim?'Claimed':'UnClaim'}}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                @if(\Illuminate\Support\Facades\Auth::guard('employee')->user()->id==$exp_claim->financial_approver && $exp_claim->status=='Approve')
                                    <a class="dropdown-item" href="{{route('cash.claim',$exp_claim->id)}}"><i class="fa fa-dot-circle-o text-success"></i>Cash Claim</a>
                                @else
                                    <a class="dropdown-item text-danger" href="#">Financial Approver only can change this status!</a>
                                @endif
                            </div>

                        </div>
                        <div class="dropdown action-label float-right">
                            <a class="btn btn-white btn-sm btn-rounded {{\Illuminate\Support\Facades\Auth::guard('employee')->user()->id==$exp_claim->approver_id?'dropdown-toggle':''}}" href="#" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-dot-circle-o text-{{$exp_claim->status=='New'?'secondary':($exp_claim->status=='Approve'?'success':($exp_claim->status=='Pending'?'info':'danger'))}}"></i> {{$exp_claim->status}}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                @if(\Illuminate\Support\Facades\Auth::guard('employee')->user()->id==$exp_claim->approver_id)
                                <a class="dropdown-item" href="{{route('exp_claim.status',['Approve',$exp_claim->id])}}"><i class="fa fa-dot-circle-o text-success"></i> Approve</a>
                                <a class="dropdown-item" href="{{route('exp_claim.status',['Pending',$exp_claim->id])}}"><i class="fa fa-dot-circle-o text-info"></i> Pending</a>
                                <a class="dropdown-item" href="{{route('exp_claim.status',['Reject',$exp_claim->id])}}"><i class="fa fa-dot-circle-o text-danger"></i> Reject</a>
                                @else
                                    <a class="dropdown-item text-danger" href="#">Approver only can change this status!</a>

                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-md-8 card">
                        <div class="form-group my-3 border-bottom">
                            <h4>Description</h4>
                            <div class="col-12" style="height: 100px;">
                                <p>{!! $exp_claim->description !!}</p>
                            </div>
                        </div>

                        <div class="table-responsive mt-3">
                            <table class=" table border">
                                <thead>
                                <tr>
                                    <th colspan="2">Title</th>
                                    <th colspan="2">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td colspan="2">{{$item->title}}</td>
                                        <td colspan="2">{{$item->amount}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2" class="text-right">Total</td>
                                    <td>{{$exp_claim->total}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div style="height: 300px;" class="border-bottom">
                            <h4>Attach File</h4>
                            <div class="row">
                                @if($attach!=null)
                                    <div class="card-body">
                                        <div class="row row-sm">
                                            @foreach($attach as $key=>$val)
                                                <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                    <div class="card card-file" style="min-width: 100px;">

                                                        @php

                                                            $infoPath = pathinfo(public_path('approval_doc/'.$val));
                                                             $extension = $infoPath['extension'];

                                                        @endphp
                                                        <div class="card-file-thumb">
                                                            @if($extension=='xlsx')
                                                                <i class="fa fa-file-excel-o"></i>
                                                            @elseif($extension=='pdf')
                                                                <i class="fa fa-file-pdf-o"></i>
                                                            @else
                                                                <i class="fa fa-file-word-o"></i>
                                                            @endif
                                                        </div>
                                                        <div class="card-body">
                                                            <h6><a href="{{url(asset('approval_doc/'.$val))}}" download>{{$val}}</a></h6>
                                                        </div>
                                                        <div class="card-footer">{{$exp_claim->created_at->toFormattedDateString()}}
                                                            <a href="{{url(asset('approval_doc/'.$val))}}" class="float-right" ><i class="fa fa-download" style="font-size: 16px;"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 card">
                        <div class="chat-contents task-chat-contents">
                            <div class="chat-content-wrap">
                                <div class="chat-wrap-inner">
                                    <div class="chat-box">
                                        <div class="chats" id="cmt">
                                            @foreach($comment as $cmt)
                                                <div class="chat chat-left">
                                                    <div class="nav float-right custom-menu">
                                                        <a href="{{route('exp_claim.comment_delete',$cmt->id)}}"
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
                                                                <span class="task-chat-user">{{$cmt->comment_user->name}}</span>
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
                                    <form action="{{route('exp_claim.comment',$exp_claim->id)}}" method="POST" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="message-area">
                                            <div class="input-group">
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
