<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style type="text/css">

        body {
            width:700px;
            margin:20px auto;
            font-family: arial;
        }

        table {
            border-collapse: collapse;
        }

        table td {
            font-size: 12px;
            padding:10px 0;

        }

        .country_name-cell {
            width:200px;
        }

        .code-cell {
            width:50px;
            color:red;
        }

        .pop96-cell {
            text-align: right;
            width:100px;
        }

        th {
            text-align: left;
        }

    </style>

</head>
<body>
   {!! $body !!}
 <div style="border:1px solid" id="print">
     <table style="margin-left: 20px">
         <tr>
             <td>Request For Quotation</td>
         </tr>
         <tr>
             <th>{{$rfq->purchase_id}}</th>
         </tr>
         <tr>
             <td>Vendor</td>
             <th style="font-size: 14px;width: 300px">{{$rfq->vendor->name}}</th>
             <td>Deadline</td>
             <th style="font-size: 14px;">{{\Carbon\Carbon::parse($rfq->deadline)->toFormattedDateString()}}</th>
             <td></td>
         </tr>
         <tr>
             <td>Vendor Reference</td>
             <th style="font-size: 14px;width: 300px">{{$rfq->vendor_reference}}</th>
             <td>Receipt Date</td>
             <th style="font-size: 14px;">{{\Carbon\Carbon::parse($rfq->receipt_date)->toFormattedDateString()}}</th>
             <td></td>
         </tr>
     </table>
     <h3 style="margin-left: 20px;">Items Table</h3>
     <div style="margin-left: 10px;margin-right: 10px;margin-top: 10px;margin-bottom: 10px;">
         <table style="margin-left: 20px;">
             <thead>
             <tr>
                 <th class="country_name-cell">Product</th>
                 <th class="country_name-cell">Description</th>
                 <th class="pop96-cell">Quantity</th>
                 <th class="pop96-cell">Price</th>
                 <th class="pop96-cell">SubTotal</th>
             </tr>
             </thead>
             <tbody>
             @foreach($items as $item)
                 <tr class="firstRow">
                     <td class="country_name-cell" style="border-bottom:1px solid #ddd;">{{$item->product->name}}</td>
                     <td class="country_name-cell" style="border-bottom:1px solid #ddd;">{{$item->description}}</td>
                     <td class="pop96-cell" style="border-bottom:1px solid #ddd;">{{$item->qty}}</td>
                     <td class="pop96-cell" style="border-bottom:1px solid #ddd;">{{$item->price}}</td>
                     <td class="pop96-cell" style="border-bottom:1px solid #ddd;">{{$item->total}}</td>
                 </tr>
             @endforeach
             </tbody>
         </table>
     </div>
 </div>
</body>
</html>