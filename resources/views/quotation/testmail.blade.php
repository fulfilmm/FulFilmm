

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
<form action="{{url("/send/mail")}}" method="post" >
    {{csrf_field()}}
    <div class="col-md-8 offset-md-2 col-12">
        <div class="border-dark card ">
            <div class="col-12">
                <h3 align="center" class="mt-3">{{$company}}</h3>
                <strong>Dear, {{$clientname}}</strong><br>
                <div class="text-center">
                    <strong class="ml-5">ID:#{{$id}} </strong>
                </div>
                <span>Payment term :{{$payterm}}</span><br>
                <span>Experation Date:{{$exp}}</span><br><br>
            </div>
            <div class="col-md-12 col-12" style="overflow-x: auto">
                <h4>Order Line</h4>
                @php
                    $orderline=\App\Models\Orderline::with('product')->where("quotation_id",$id)->get();
                @endphp
                <table class="table">
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
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <th>Grand Total : </th>
                        <td> {{$total}} </td>
                    </tr>
                </table>
            </div>
            <div class="form-group ml-3 mb-5">
                <h4>Terms and Conditions</h4>
                <p class="ml-5">{{$term_and_con}}</p>
            </div>
        </div>
    </div>
</form>
<script src="{{url(asset("js/bootstrap.min.js"))}}"></script>
</body>
</html>

