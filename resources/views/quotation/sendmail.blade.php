<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Send Email</title>
    <link rel="stylesheet" href="{{url(asset("css/bootstrap.min.css"))}}">
    <style>
        body{
            padding-top: 20px;
            height: 1000px;
            /*width: 800px;*/
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
<form action="{{route('quotations.mail')}}" enctype="multipart/form-data" method="post" >
    {{csrf_field()}}
    <div class="col-md-8 offset-md-2 col-12">
    <div class="border-dark card ">
        <div class="col-12">
            <h3 align="center" class="mt-3">{{$company}}</h3>
            <input type="hidden" value="{{$company}}" name="company">
            <input type="hidden" name="client_name" value="{{$quotation->customer->name}}">
            <div class="text-center">
                <strong class="ml-5">ID :{{$quotation->quotation_id}} </strong>
                <input type="hidden" value="{{$quotation->quotation_id}}" name="id">
            </div>
            <div class=" mt-5 row">
                <label for="" class="col-4 col-md-2 ml-3">To</label>
                <input class="form-control col-6 col-md-4" type="text" value="{{$quotation->customer->email}}" name="email">
            </div>
            <div class="mt-3 row">
                <label for="" class="col-4 col-md-2 ml-3">cc</label>
                <input class="form-control col-6 col-md-4" type="text"  name="email_cc">
            </div>
            <div class="row mt-3">
                <label for="" class="col-4 col-md-2 ml-3">Subject</label>
                <input class="form-control col-6 col-md-4" type="text"  name="subject">
            </div>
            <div class="row mt-3">
                <label for="" class="col-4 col-md-2 ml-3">Attach File</label>
                <input class="col-6 col-md-4" type="file"  name="attch">
            </div>
            <div class="row  mt-3">
                <div class="col-md-2 col-3 offset-md-6  ">
                    <label for="">Expiration </label>
                </div>
                <div class="col-md-4 col-9">
                    <div class="form-group">
                        <span>: {{$quotation->exp_date}}</span>
                        <input type="hidden" value="{{$quotation->exp_date}}" name="exp">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2 col-4 offset-md-6 ">
                    <label for="">PaymentTerms</label>
                </div>
                <div class="col-md-4 col-6" >
                    <span> : {{$quotation->payment_term}}</span>
                    <input type="hidden" value="{{$quotation->payment_term}}" name="pay_term">
                </div>
            </div>
        </div>
        <div class="col-md-12 col-12" style="overflow-x: auto">
            <h4>Order Line</h4>
        <table class="table" >
            <thead>
            <th scope="col">Product</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Taxes(%)</th>
            <th>Total(Include Tax)</th>
            </thead>
            <tbody id="tbody">
            @foreach($orderline as $order)
                <tr>
                    <td>
                        {{$order->product->name}}
                    </td>
                    <td>{{$order->description}}</td>
                    <td>{{$order->quantity}}</td>
                    <td>{{$order->price}}</td>
                    <td>{{$order->tax}}%</td>
                    <td>{{$order->total_amount}}
                        <input type="hidden" class="total" value="{{$order->total_amount}}">
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <th>Grand Total</th>
                <td>{{$grand_total}}
                    <input type="hidden" name="grand_total" value="{{$grand_total}}"></td>
            </tr>
        </table>
       </div>
        <div class="form-group ml-3 mb-5">
        <h4>Terms and Conditions</h4>
            <p class="ml-5">{{$quotation->terms_conditions}}</p>
            <input type="hidden" name="term_condition" class="form-control" style="width: 90%" value="{{$quotation->terms_conditions}}">
        </div>
        <div class="form-group text-center">
        <button type="submit"  class="btn btn-primary float-right mr-5 "> Send</button>
        </div>
</div>
    </div>
</form>
<script src="{{url(asset("js/bootstrap.min.js"))}}"></script>
</body>
</html>
