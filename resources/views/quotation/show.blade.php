@extends("layout.mainlayout")
@section("title",$quotation->quotation_id)
@section("content")
    <style>
        @media print {
            title {
                font-size:24px;
            }
        }
    </style>
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">{{$quotation->quotation_id}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('quotations.index')}}">Quotation</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <!-- Content Starts -->


            <a href="{{route('quotations.create')}}" class="btn btn-outline-success" id="discard">Create</a>
            <button id="print" class="btn btn-outline-danger float-right ml-2" onclick="printContent('print_me');" ><i class="fa fa-print"></i> Print</button>
            <a href="{{route('quotations.edit',$quotation->id)}}" class="btn btn-outline-primary float-right" >Edit</a>
            <a href="{{url("/quotations/sendemail/$quotation->quotation_id")}}" class="btn btn-outline-primary" id="send_email">SendByEmail</a>
            @if(!$quotation->is_confirm)<a href="{{url('quotations/confirm/'.$quotation->id)}}" class="btn btn-outline-primary" id="confirm">Confirm</a>@else <button class="btn btn-success">Status :Confirmed</button>@endif
            <hr>
            <div class="card" >
                <div class="col-12" id="print_me">
               <div class="row">
                   <div class="col-md-4 my-5 mx-5">
                       <img src="{{$company!=null ? url(asset('/img/profiles/'.$company->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}" width="40" height="40" alt="">

                       <span>{{$company->name??''}}</span><br><br>
                       <span>{{$company->email??''}}</span><br>
                       <span>{{$company->phone??''}}</span><br>
                       <span>{{$company->address??''}}</span>
                   </div>
                   <div class="col-md-2 my-5">
                       <input type="hidden" id="quotation_id" name="quotation_id" value="{{$quotation->id}}">
                       <span>Quotation Number</span>
                       <strong class="text-center">{{$quotation->quotation_id}}</strong>
                   </div>
                   <div class="col-md-4 my-5 text-right">
                       <span class="text-muted">Expiration :</span><span> {{\Carbon\Carbon::parse($quotation->exp_date)->toFormattedDateString()}}</span><br>
                       <span class="text-muted">Payment Terms : </span><span>{{$quotation->payment_term}}</span>
                   </div>
               </div>
                <div class="col-md-12 text-left  mb-4 ml-4">
                    <span>Customer Information</span><br>
                   <span class="text-muted">Name :</span><span>{{$quotation->customer->name}}</span><br>
                    <span class="text-muted">Email :</span><span>{{$quotation->customer->email}}</span><br>
                    <span class="text-muted">Phone :</span><span>{{$quotation->customer->phone}}</span>
                    </div>
                <div class="col-12" id="home" role="tabpanel" aria-labelledby="home-tab" style="overflow-x: auto">
                        <table class="table" >
                            <thead>
                            <th scope="col">Product Name</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            </thead>
                            <tbody id="tbody">
                            @foreach($orderline as $order)
                                <tr>
                                    <td style="min-width: 400px">
                                       <div class="row">
                                           <div class="col-md-2">
                                               <img src="{{url(asset('product_picture/'.$order->variant->image))}}"  alt="" width="40px" height="40px">
                                           </div>
                                           <div class="col-md-10">
                                               <h4>{{$order->product->name}}</h4>
                                               <p>{{$order->variant->size??''}}{{$order->variant->color?','.$order->variant->color:''}}{{$order->variant->other?','.$order->variant->other:''}}</p>
                                           </div>
                                       </div>
                                    </td>
                                    <td>{{$order->description}}</td>
                                    <td>{{$order->quantity}}</td>
                                    <td>{{$order->price}}</td>
                                    <td>{{$order->total_amount}}
                                        <input type="hidden" class="total" value="{{$order->total_amount}}">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <th colspan="2">Total</th>

                                <td>{{$quotation->total}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <th colspan="2">Discount</th>

                                <td>{{$quotation->discount}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <th colspan="2">Tax (Rate %)</th>
                                <td>{{$quotation->tax_amount}} ({{$quotation->tax->rate}} %)</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <th colspan="2">Grand Total</th>

                                <td>{{$quotation->grand_total}}</td>
                            </tr>
                        </table>
                    </div>
                <div class="col-12 " style="padding-top: 100px;height: 400px;padding-bottom: 500px">
                    <strong>Terms And Conditions</strong><br>
                    {{$quotation->terms_conditions}}
                </div>
                </div>
            </div>
        <!-- /Content End -->

    </div>
    <!-- /Page Content -->

    <div id="print_me"  style="visibility: hidden">

    </div>
    <script>
        function printContent(el){
            // document.title = ;
            var restorepage = $('body').html();
            $('#myTab').remove();
            var printcontent = $('#' + el).clone();
            printcontent.append('<div class="row" style="position: fixed;bottom: 110px; left: 50px" ><div class="row justify-content-between"> <div class="col-12 text-center"><span>{{$company->web_link??''}}</span></div></div></div>');
            printcontent.append('<div class="row" style="position: fixed;bottom: 90px; left: 50px" ><div class="row justify-content-between"> <div class="col-12 text-center"><span>{{$company->email??""}}</span></div></div></div>');
            printcontent.append('<div class="row" style="position: fixed;bottom: 70px; left: 50px" ><div class="row justify-content-between"> <div class="col-12 text-center"><span>{{$company->phone??''}}</span></div></div></div>');
            printcontent.append('<div class="row" style="position: fixed;bottom: 50px; left: 50px" ><div class="row justify-content-between"> <div class="col-12 text-center"><span>{{$company->address??""}}</span></div></div></div>');
            $('body').empty().html(printcontent);
            window.print();
            $('body').html(restorepage);
        }
    </script>
    <!-- /Page Wrapper -->
@endsection
