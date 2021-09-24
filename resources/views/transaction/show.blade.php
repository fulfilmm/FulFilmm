@extends('layout.mainlayout')
@section('title','Account')
@section('content')
    <div class="content container-fluid">
        <button type="button" id="btn" class="btn btn-outline-dark float-right"><i class="fa fa-print mr-2"></i>Print</button>
        <div class="row" style="font-size: inherit !important;">
            <div class="col-4 col-lg-3">
                Account
                <br> <strong><span class="float-left long-texts mwpx-200 transaction-head-text"><a
                                href="https://app.akaunting.com/142258/banking/accounts/188694">
                        {{$transaction->account->name}}
                    </a></span></strong> <br><br></div>
            <div class="col-4 col-lg-3">
                Category
                <br> <strong><span class="float-left long-texts mwpx-300 transaction-head-text">
                    {{$transaction->type=="Revenue"? $transaction->revenue->category:$transaction->expense->category}}
                </span></strong> <br><br></div>
            <div class="col-4 col-lg-2">
                Customer
                <br> <strong><span class="float-left long-texts mwpx-300 transaction-head-text">
                                           {{$customer->name}}
                                    </span></strong> <br><br></div>
            <div class="col-4 col-lg-2">
                Amount
                <br> <strong><span class="float-left long-texts mwpx-100 transaction-head-text">
                  {{$transaction->type=="Revenue"?$transaction->revenue->amount:$transaction->expense->amount}} {{$transaction->account->currency}}           </span></strong> <br><br></div>
            <div class="col-4 col-lg-2">
                Date
                <br> <strong><span class="float-left long-texts mwpx-100 transaction-head-text">
                    {{\Carbon\Carbon::parse($transaction->type=='Revenue'?$transaction->revenue->transaction_date:$transaction->expense->transaction_date)->toFormattedDateString()}}            </span></strong> <br><br></div>
        </div>
        <div class="card show-card"
             style="padding: 0px 15px; border-radius: 0px; box-shadow: rgba(0, 0, 0, 0.2) 0px 4px 16px;">
            <div class="card-body show-card-body my-3" id="printarea" >
                <table class="border-bottom-1">
                    <tbody>
                    <tr>
                        <td valign="top" style="width: 5%;"><img
                                    src="{{$company!=null ? url(asset('/img/profiles/'.$company->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}" width="100px" height="100px"
                                    alt="MyatNoe"></td>
                        <td style="width: 60%;"><h2 class="mb-1" style="font-size: 16px;">
                                {{$receiver->name}}
                            </h2>
                            <p style="margin: 0px; padding: 0px; font-size: 14px;">{{$receiver->phone}}</p>
                            <p style="margin: 0px; padding: 0px; font-size: 14px;"></p>
                            <p style="margin: 0px; padding: 0px; font-size: 14px;">{{$receiver->email}}</p></td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center">

                                <h2 class="text-center text-uppercase" style="font-size: 16px;">
                                   {{$transaction->type=="Revenue"?' Revenue Received':'Payment Made'}}
                                </h2>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <table>
                            <tbody>
                            <tr>
                                <td style="width: 70%; padding-top: 0px; padding-bottom: 0px;">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td style="width: 20%; padding-bottom: 3px; font-size: 14px; font-weight: bold;">
                                                Date:
                                            </td>
                                            <td class="border-bottom-1"
                                                style="width: 80%; padding-bottom: 3px; font-size: 14px;">
                                                {{\Carbon\Carbon::parse($transaction->type=='Revenue'?$transaction->revenue->transaction_date:$transaction->expense->transaction_date)->toFormattedDateString()}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%; padding-bottom: 3px; font-size: 14px; font-weight: bold;">
                                                Account:
                                            </td>
                                            <td class="border-bottom-1"
                                                style="width: 80%; padding-bottom: 3px; font-size: 14px;">
                                                {{$transaction->account->name}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%; padding-bottom: 3px; font-size: 14px; font-weight: bold;">
                                                Category:
                                            </td>
                                            <td class="border-bottom-1"
                                                style="width: 80%; padding-bottom: 3px; font-size: 14px;">
                                                {{$transaction->type=="Revenue"? $transaction->revenue->category:$transaction->expense->category}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%; padding-bottom: 3px; font-size: 14px; font-weight: bold;">
                                                Payment Method:
                                            </td>
                                            <td class="border-bottom-1"
                                                style="width: 80%; padding-bottom: 3px; font-size: 14px;">
                                                {{$transaction->type=="Revenue"?$transaction->revenue->payment_method:$transaction->expense->payment_method}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%; padding-bottom: 3px; font-size: 14px; font-weight: bold;">
                                                Reference:
                                            </td>
                                            <td class="border-bottom-1"
                                                style="width: 80%; padding-bottom: 3px; font-size: 14px;">
                                                {{$transaction->type=="Revenue"?$transaction->revenue->reference:$transaction->expense->refrence}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%; padding-bottom: 3px; font-size: 14px; font-weight: bold;">
                                                Description:
                                            </td>
                                            <td style="width: 80%; padding-bottom: 3px; font-size: 14px;"><p
                                                        style="font-size: 14px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; margin: 0px;">
                                                   {{$transaction->type=="Revenue"?$transaction->revenue->description:$transaction->expense->description}}
                                                </p></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 45px; padding-bottom: 0px;"><h2 style="font-size: 16px;">
                                                    {{$transaction->type=="Revenue"?'Paid By':'Paid To'}}
                                                </h2></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 5px; padding-top: 0px; font-size: 14px;">
                                                <strong>{{$customer->name}}</strong><br></td>
                                        </tr>
                                       @if($transaction->type=="Expense")
                                           <tr>
                                               <td style="padding-bottom: 5px; padding-top: 0px; font-size: 14px;"><p
                                                           style="margin: 0px; padding: 0px; font-size: 14px;">{{$customer->phone}}</p></td>
                                           </tr>
                                           <tr>
                                               <td style="padding-bottom: 5px; padding-top: 0px; font-size: 14px;"><p
                                                           style="margin: 0px; padding: 0px; font-size: 14px;">{{$customer->email}}</p></td>
                                           </tr>
                                           <tr>
                                               <td style="padding-bottom: 0px; padding-top: 0px; font-size: 14px;"><p
                                                           style="margin: 0px; padding: 0px; font-size: 14px;">{{$customer->address}}</p></td>
                                           </tr>
                                           @endif

                                        <tr>
                                            <td style="padding-bottom: 0px; padding-top: 0px; font-size: 14px;"><p
                                                        style="margin: 0px; padding: 0px; font-size: 14px;"></p></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6" style="padding-top: 30px;padding-bottom: 30px;">
                        <div class="col-md-6">
                            <div class="card bg-{{$transaction->type=="Revenue"?'success':'danger'}} border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col"><h5 class="text-uppercase mb-0 text-white">Amount</h5>
                                            <div class="dropdown-divider"></div>
                                            <span class="h2 font-weight-bold mb-0 text-white">{{$transaction->type=="Revenue"?$transaction->revenue->amount:$transaction->expense->amount}} {{$transaction->account->currency}}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        function printData()
        {
            var divToPrint=document.getElementById("printarea");
            newWin= window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }

        $('#btn').on('click',function(){
            printData();
        })
    </script>
@endsection