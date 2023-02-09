<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Invoice </title>

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
            <td colspan="9">
                <table>
                    <tr>
                        <td class="title">
                            <img src="{{$company!=null ? url(asset('/img/profiles/'.$company->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}" width="100" height="100"
                                 style="max-width:100px;max-height: 100px"/>

                        </td>
                        <td>
                            <h3 align="center">{{$company->name??''}}</h3>
                            <h6 align="center">
                                <span style="alignment: center">{{$company->phone??''}}</span><br>
                                <span style="alignment: center">{{$company->address??''}}</span><br>
                                <span style="alignment: center">{{$company->email??''}}</span>
                            </h6>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="9">
                <hr></td>
        </tr>
        <tr>
            <td colspan="9" style="alignment: right">
                <h5 align="right">
                    ID #: {{$quotation->quotation_id}}<br/>
                    Exp Date: {{\Illuminate\Support\Carbon::parse($quotation->exp_date)->toFormattedDateString()}}
                    <br/>
                    Deal ID: {{$quotation->deal->deal_id??'N/A'}}
                    <br>
                    Payment Term: {{$quotation->payment_term}}
                </h5>
            </td>
        </tr>
        <tr class="information">
            <td colspan="9">
                <h5>Invoice To :</h5>
                <strong>{{$quotation->customer->name}}</strong><br/>
                <strong>{{$quotation->customer->email}}</strong><br>
                <strong>{{$quotation->customer->phone}}</strong><br>
                <strong>{{$quotation->customer->address??'Address'}}</strong><br>
                <strong>{{$quotation->customer->company->name}}</strong>
                <br><br>
            </td>
        </tr>

        <tr>
            <td colspan="9"><br><br><h3>Quotation Items</h3></td>

        </tr>
        <tr class="heading" style="border: 1px">
            <th colspan="3">Item</th>
            <th>Quantity</th>
            <th colspan="2">Unit</th>
            <th style="text-align: right" >Price</th>

            <th style="text-align: right">Discount</th>
            <th style="text-align: right">Total</th>
        </tr>
        <tr>
            <td colspan="9">
                <hr>
            </td>
        </tr>
        @foreach($orders as $item)
            <tr class="item">
                <td colspan="3">{{$item->variant->product_name}}</td>
                <td>{{$item->quantity}}</td>
                <td colspan="2">{{$item->unit->unit}}</td>
                <td style="text-align: right">{{$item->price}}</td>
                <td style="text-align: right">{{$item->discount}}</td>
                <td style="text-align: right">{{$item->total_amount}}</td>
            </tr>
        @endforeach
        <tr class="total" style="border:1px">
            <td colspan="6"></td>
            <th colspan="2" style="text-align: left">Total</th>
            <td style="text-align: right;">{{$quotation->total}}</td>
        </tr>
        <tr>
            <td colspan="9">
                <hr>
            </td>
        </tr>
        <tr class="total" style="border: 1px">
            <td colspan="6"></td>
            <th colspan="2" style="text-align: left">Discount</th>
            <td style="text-align: right">{{$quotation->discount}}</td>
        </tr>
        <tr>
            <td colspan="9">
                <hr>
            </td>
        </tr>
        <tr class="total" style="border: 1px">
            <td colspan="6"></td>
            <th colspan="2" style="text-align: left">Tax ({{$quotation->tax->rate}} %)</th>
            <td style="text-align: right">{{$quotation->tax_amount}}</td>
        </tr>
        <tr>
            <td colspan="9">
                <hr>
            </td>
        </tr>
        <tr class="total" style="border: 1px">
            <td colspan="6"></td>
            <th colspan="2" style="text-align: left">Grand Total</th>
            <td style="text-align: right">{{$quotation->grand_total}}</td>
        </tr>
        <tr>
            <td colspan="9">
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="9">
                Terms and Conditions:
            </td>
        </tr>
        <tr>
            <td colspan="9">
                {{$quotation->terms_conditions}}
            </td>
        </tr>
        <tr>
            <td colspan="6">
            </td>
            <td colspan="3">
                <h5 align="center">
                    <strong style="text-align:right">Quotation Issue By,</strong><br>
                    <strong>{{$quotation->sale_person->name}}</strong><br/>
                    <strong>{{$quotation->sale_person->phone}}</strong><br/>
                    <strong>{{$quotation->sale_person->email}}</strong><br/>

                </h5>

            </td>
        </tr>
    </table>
    <table style="alignment: left" class="footer">
        <tr>
            <td><span>Website : {{$company->web_link??'https://....'}}</span> |
                <span>Email : {{$company->email??'@gmail.com'}}</span> <br>
                <span>Phone :{{$company->phone??'09*********'}}</span> |
                <span>Address : {{$company->address??'......'}}</span>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
