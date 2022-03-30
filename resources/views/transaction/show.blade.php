@extends('layout.mainlayout')
@section('title','Account')
@section('content')
    <div class="content container-fluid">


        <div class="card show-card"
             style="padding: 0px 15px; border-radius: 0px; box-shadow: rgba(0, 0, 0, 0.2) 0px 4px 16px;">
            <div class="card-body show-card-body my-3 mx-5" id="print_me">
                <table class="border-bottom-1">
                    <tbody>
                    <tr>
                        <td valign="top" style="width: 5%;"><img
                                    src="{{$company!=null ? url(asset('/img/profiles/'.$company->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}"
                                    width="100px" height="100px"
                                    alt="MyatNoe"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center">

                    <h2 class="text-center text-uppercase" style="font-size: 16px;">
                        {{$transaction->type=="Revenue"?' Revenue Received':'Payment Made'}}
                    </h2>
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="row my-1">
                            <div class="col-2">Date</div>
                            <div class="col-8">
                                : {{\Carbon\Carbon::parse($transaction->type=='Revenue'?$transaction->revenue->transaction_date:$transaction->expense->transaction_date)->toFormattedDateString()}}</div>
                        </div>
                        <div class="row my-1">
                            <div class="col-2">Bank Account</div>
                            <div class="col-8">
                                : {{$transaction->account->name??'N/A'}}</div>
                        </div>
                        <div class="row my-1">
                            <div class="col-2">Amount</div>
                            <div class="col-8">
                                : {{$transaction->type=="Revenue"? $transaction->revenue->amount:$transaction->expense->amount}} MMK</div>
                        </div>
                        <div class="row my-1">
                            <div class="col-2">Category</div>
                            <div class="col-8">

                                : @if($transaction->type=="Revenue")
                                    @foreach ($category as $cat)
                                        @if($cat->id==$transaction->revenue->category)
                                            {{$cat->name}}
                                            @endif
                                        @endforeach
                                      @else
                                    @foreach ($category as $cat)
                                        @if($cat->id==$transaction->expense->category)
                                            {{$cat->name}}
                                        @endif
                                    @endforeach
                                        @endif
                        </div>
                        </div>
                        <div class="row my-1">
                            <div class="col-2">Account</div>
                            <div class="col-8">

                                : @if($transaction->type=="Revenue")
                                    @foreach ($coas as $coa)
                                        @if($coa->id==$transaction->revenue->coa_id)
                                            {{$coa->code.'-'.$coa->name}}
                                        @endif
                                    @endforeach
                                @else
                                    @foreach ($coas as $coa)
                                        @if($coa->id==$transaction->expense->coa_id)
                                            {{$coa->code.'-'.$coa->name}}
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="row my-1">
                            <div class="col-2">Payment Method</div>
                            <div class="col-8">
                                : {{$transaction->type=="Revenue"?$transaction->revenue->payment_method:$transaction->expense->payment_method}}</div>
                        </div>
                        <div class="row my-1">
                            <div class="col-2">Reference</div>
                            <div class="col-8">
                                : {{$transaction->type=="Revenue"?$transaction->revenue->reference:$transaction->expense->refrence}}</div>
                        </div>
                        <div class="row mb-5 mt-2">
                            <div class="col-12">Description</div>
                            <div class="col-12 border rounded mt-2" style="min-height: 50px">
                            <div class="my-2">
                                {!!$transaction->type=="Revenue"?$transaction->revenue->description:$transaction->expense->description!!}
                            </div>
                            </div>
                        </div>
                        <div class="row mt-3 mb-1">
                            <div class="col-md-4 offset-1">
                                <h5>{{$transaction->type=="Revenue"?'Receiver':'Paid From'}}</h5>
                            </div>
                            <div class="col-md-4 offset-md-3">
                                <h5>{{$transaction->type=="Revenue"?'Customer':'Supplier'}}</h5>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-4 offset-1">
                                <span>{{$receiver->name??''}}</span>
                            </div>
                            <div class="col-md-4 offset-1 offset-md-3">
                                <span>{{$customer->name??''}}</span>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-4 offset-1">
                                <span>{{$receiver->phone??''}}</span>
                            </div>
                            <div class="col-md-4 offset-1 offset-md-3">
                                <span>{{$customer->phone??''}}</span>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-4 offset-1">
                                <span>{{$receiver->email??''}}</span>
                            </div>
                            <div class="col-md-4 offset-1 offset-md-3">
                                <span>{{$customer->email??''}}</span>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-4 offset-1">
                                <span>{{$receiver->address??''}}</span>
                            </div>
                            <div class="col-md-4 offset-1 offset-md-3">
                                <span>{{$customer->address??''}}</span>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div id="print_me" style="visibility: hidden">
            </div>

        </div>
        <div class="card shadow">
            <div class="card-header">
                Attach File
            </div>
            <div class="card-body">
                <div class="row">
                   @if($transaction->type=='Revenue')
                        @if($transaction->revenue->attachment!=null)
                            <div class="card-body">
                                <div class="row row-sm">
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                        <div class="card card-file" style="min-width: 100px;">
                                            @php

                                                $infoPath = pathinfo(public_path('attach_file/'.$transaction->revenue->attachment));
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
                                                <h6><a href="{{url(asset('attach_file/'.$transaction->revenue->attachment))}}" download>{{$transaction->revenue->attachment}}</a></h6>
                                            </div>
                                            <div class="card-footer">{{$transaction->created_at->toFormattedDateString()}}
                                                <a href="{{url(asset('attach_file/'.$transaction->revenue->attachment))}}" class="float-right" ><i class="fa fa-download" style="font-size: 16px;"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                       @else
                        @if($transaction->expense->attachment!=null)
                            <div class="card-body">
                                <div class="row row-sm">
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                        <div class="card card-file" style="min-width: 100px;">
                                            @php

                                                $infoPath = pathinfo(public_path('attach_file/'.$transaction->expense->attachment));
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
                                                <h6><a href="{{url(asset('attach_file/'.$transaction->expense->attachment))}}" download>{{$transaction->expense->attachment}}</a></h6>
                                            </div>
                                            <div class="card-footer">{{$transaction->created_at->toFormattedDateString()}}
                                                <a href="{{url(asset('attach_file/'.$transaction->expense->attachment))}}" class="float-right" ><i class="fa fa-download" style="font-size: 16px;"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="" id="print" onclick="printContent('print_me');" class="btn btn-outline-dark float-right"><i
                            class="fa fa-print mr-2"></i>Print</a>
            </div>
        </div>
        <script>
            function printContent(el) {
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
        </script>
@endsection