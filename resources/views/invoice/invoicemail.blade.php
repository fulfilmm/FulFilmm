<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>A simple, clean, and responsive HTML invoice template</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }

        .footer {
            padding-left: 200px;
            padding-top: 100px;
            font-size: 10px;
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="6">
                <table>
                    <tr>
                        <td class="title">
                            <img src="{{$company!=null ? url(asset('/img/profiles/'.$company->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}"
                                 style="max-width:200px;max-height: 200px"/>

                        </td>
                        <td>
                            <span>{{$company->name??''}}</span><br>
                            <span>{{$company->phone??''}}</span><br>
                            <span>{{$company->address??''}}</span><br>
                            <span>{{$company->email??''}}</span>
                        </td>
                        <td style="float: right">
                            Invoice #: {{$invoice->invoice_id}}<br/>
                            Created: {{\Illuminate\Support\Carbon::parse($invoice->invoice_date)->toFormattedDateString()}}
                            <br/>
                            Due: {{\Illuminate\Support\Carbon::parse($invoice->due_date)->toFormattedDateString()}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="information">
            <td colspan="9">
                <table>
                    <tr>
                        <td colspan="9">
                            <h5>Invoice From :</h5>
                            <span style="margin-right: 20px;"> Name :</span><strong>{{$invoice->employee->name}}</strong><br/>
                            <span style="margin-right: 20px;"> Email :</span><strong>{{$invoice->employee->email}}</strong><br/>
                            <span style="margin-right: 20px;"> Phone :</span><strong>{{$invoice->employee->phone}}</strong><br/>
                            <span style="margin-right: 20px;">Address :</span><strong>{{$invoice->employee->address}}</strong><br/>
                        </td>
                        <td style="float: right;">
                            <h5>Invoice To :</h5>
                            <span style="margin-right: 20px;">Company:</span><strong>{{$invoice->customer->company->name}}</strong>
                            <br/>
                            <span style="margin-right: 20px;">Name :</span><strong>{{$invoice->customer->name}}</strong><br/>
                            <span style="margin-right: 20px;">Email : </span><strong>{{$invoice->customer->email}}</strong><br>
                            <span style="margin-right: 20px;">Phone :</span><strong>{{$invoice->customer->phone}}</strong><br>
                            <span style="margin-right: 20px;">Address :</span><strong>{{$invoice->customer->address}}</strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td style="min-width: 200px;">Payment Method</td>
            <td></td>
            <td>:</td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{$invoice->payment_method}}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr class="heading">
            <th>Item</th>
            <th>Quantity</th>
            <th style="min-width: 80px;">Price</th>
            <th>Unit</th>
            <th>Discount</th>
            <th>Total</th>
        </tr>
        @foreach($orderItem as $item)
            <tr class="item">
                <td>{{$item->variant->product_name}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->unit_price}}</td>
                <td>{{$item->unit->unit}}</td>
                <td>{{$item->discount_promotion}}%</td>
                <td>{{$item->total}}</td>
            </tr>
        @endforeach
        <tr class="total">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <th>Total:</th>
            <td>{{$invoice->grand_total}}</td>
        </tr>
    </table>
    <table style="alignment: left" class="footer">
        <tr>
            <td><span>Website : {{$company->web_link??'https://....'}}</span> |
                <span>Email : {{$company->email??'@gmail.com'}}</span> <br>
                <span>Facebook Page : {{$company->facebook_page??'www.facebook.com/...'}}</span> |
                <span>Linkedin : {{$company->linkedin??'www.linkedin.com/...'}}</span> <br>
                <span>Phone :{{$company->phone??'09*********'}}</span> |
                <span>Address : {{$company->address??'......'}}</span> <br>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
