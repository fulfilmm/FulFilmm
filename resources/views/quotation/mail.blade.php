<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <title>
    </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        #outlook a{padding: 0;}
        .ReadMsgBody{width: 100%;}
        .ExternalClass{width: 100%;}
        .ExternalClass *{line-height: 100%;}
        body{margin: 0; padding: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;}
        table, td{border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;}
        img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
        p{display: block; margin: 13px 0;}
    </style>
    <!--[if !mso]><!-->
    <style type="text/css">
        @media only screen and (max-width:480px) {
            @-ms-viewport {width: 320px;}
            @viewport {	width: 320px; }
        }
    </style>
    <!--<![endif]-->
    <!--[if mso]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <!--[if lte mso 11]>
    <style type="text/css">
        .outlook-group-fix{width:100% !important;}
    </style>
    <![endif]-->
    <style type="text/css">
        @media only screen and (min-width:480px) {
            .dys-column-per-100 {
                width: 100.000000% !important;
                max-width: 100.000000%;
            }
        }
        @media only screen and (max-width:480px) {

            table.full-width-mobile { width: 100% !important; }
            td.full-width-mobile { width: auto !important; }

        }
        @media only screen and (min-width:480px) {
            .dys-column-per-100 {
                width: 100.000000% !important;
                max-width: 100.000000%;
            }
        }
        @media only screen and (min-width:480px) {
            .dys-column-per-100 {
                width: 100.000000% !important;
                max-width: 100.000000%;
            }
        }
    </style>
</head>
<body>
@php $company=\App\Models\MainCompany::where('ismaincompany',true)->first(); @endphp
<div>
    Hello,<br>
    {{$clientname}}<br>
    Your quotation <strong>{{$id}}</strong> amounting in <strong>{{$total}}</strong> is ready for review.<br>
    <table align='center' background='https://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:url(https://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) top center / auto repeat;width:100%;'>
        <tbody>
        <tr>
            <td>
                <!--[if mso | IE]>
                <v:rect style="mso-width-percent:1000;" xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false"><v:fill src="https://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" origin="0.5, 0" position="0.5, 0" type="tile" /><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0">
                <![endif]-->
                <div style='margin:0px auto;max-width:600px;'>
                    <div style='font-size:0;line-height:0;'>
                        <table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='width:100%;'>
                            <tbody>
                            <tr>
                                <td style='direction:ltr;font-size:0px;padding:20px 0px 30px 0px;text-align:center;vertical-align:top;'>
                                    <!--[if mso | IE]>
                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:600px;">
                                    <![endif]-->
                                    <div class='dys-column-per-100 outlook-group-fix' style='direction:ltr;display:inline-block;font-size:13px;text-align:left;vertical-align:top;width:100%;'>
                                        <table border='0' cellpadding='0' cellspacing='0' role='presentation' width='100%'>
                                            <tbody>
                                            <tr>
                                                <td style='padding:0px 20px;vertical-align:top;'>
                                                    <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='' width='100%'>
                                                        <tr>
                                                            <td align='left' style='font-size:0px;padding:0px;word-break:break-word;'>
                                                                <table border='0' cellpadding='0' cellspacing='0' style='cellpadding:0;cellspacing:0;color:#000000;font-family:Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;' width='100%'>
                                                                    <tr>
                                                                        <td align='left'>
                                                                            <a href='#'>
                                                                                <img align='left' alt='{{$company->logo}}' height='40' padding='5px' src="{{asset('/img/profiles'.$company->logo)}}" width='40' />
                                                                            </a>
                                                                            <h4 style="margin-left: 50px">
                                                                                {{$company->name}}
                                                                            </h4>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--[if mso | IE]>
                                    </td></tr></table>
                                    <![endif]-->
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--[if mso | IE]>
                </v:textbox></v:rect>
                <![endif]-->
            </td>
        </tr>
        </tbody>
    </table>
    <!--[if mso | IE]>
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:600px;" width="600"><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
    <![endif]-->
    <div style='background:#FFFFFF;background-color:#FFFFFF;margin:0px auto;max-width:600px;'>
        <table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#FFFFFF;background-color:#FFFFFF;width:100%;'>
            <tbody>
            <tr>
                <td style='direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;'>
                    <!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:600px;">
                    <![endif]-->
                    <div class='dys-column-per-100 outlook-group-fix' style='direction:ltr;display:inline-block;font-size:13px;text-align:left;vertical-align:top;width:100%;'>
                        <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'>
                            <tr></tr>
                            <tr>
                                <th style="font-size: 20px" >Items</th></tr>
                            <tr>
                                <td align='left' style='font-size:0px;padding:10px 25px;word-break:break-word;'>
                                    <table border='0' cellpadding='0' cellspacing='0' style="cellpadding:0;cellspacing:0;color:#777777;font-family:'Oxygen', 'Helvetica Neue', helvetica, sans-serif;font-size:14px;line-height:21px;table-layout:auto;width:100%;" width='100%'>
                                        <tr>
                                            <th style='text-align: left; border-bottom: 1px solid #cccccc; color: #4d4d4d; font-weight: 700; padding-bottom: 5px;' width='25%'>
                                                Products
                                            </th>
                                            <th style='text-align: right; border-bottom: 1px solid #cccccc; color: #4d4d4d; font-weight: 700; padding-bottom: 5px;' width='15%'>
                                                Description
                                            </th>
                                            <th style='text-align: right; border-bottom: 1px solid #cccccc; color: #4d4d4d; font-weight: 700; padding-bottom: 5px; ' width='15%'>
                                                Quantity
                                            </th>
                                            <th style='text-align: right; border-bottom: 1px solid #cccccc; color: #4d4d4d; font-weight: 700; padding-bottom: 5px; ' width='15%'>
                                                Unit Price
                                            </th>
                                            <th style='text-align: right; border-bottom: 1px solid #cccccc; color: #4d4d4d; font-weight: 700; padding-bottom: 5px; ' width='15%'>
                                                Taxes(%)
                                            </th>
                                            <th style='text-align: right; border-bottom: 1px solid #cccccc; color: #4d4d4d; font-weight: 700; padding-bottom: 5px; ' width='15%'>
                                                Total(Include Tax)
                                            </th>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align='left' style='font-size:0px;padding:10px 25px;word-break:break-word;'>
                                    <table border='0' cellpadding='0' cellspacing='0' style='cellpadding:0;cellspacing:0;color:#000000;font-family:Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;' width='100%'>
                                        @foreach($orders as $order)
                                            <tr style="font-size:14px; line-height:19px; font-family: 'Oxygen', 'Helvetica Neue', helvetica, sans-serif; color:#777777">
                                                <td width='25%'>
                                                    <table cellpadding='0' cellspacing='0' width='100%'>
                                                        <tbody>
                                                        <tr>
                                                            <td style="text-align:left; font-size:14px; line-height:19px; font-family: ' oxygen', 'helvetica neue', helvetica, sans-serif; color: #777777;">
                                      <span style='color: #4d4d4d; font-weight:bold;'>
                                       {{$order->product->name}}
                                      </span>

                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td style='text-align:center; ' width='15%'>
                                                    {{$order->description}}
                                                </td>
                                                <td style='text-align:right; ' width='15%'>
                                                    {{$order->quantity}}
                                                </td>
                                                <td style='text-align:right; ' width='15%'>
                                                    {{$order->price}}
                                                </td>
                                                <td style='text-align:right; ' width='15%'>
                                                    {{$order->tax}}%
                                                </td>
                                                <td style='text-align:right; ' width='15%'>
                                                    {{$order->total_amount}}
                                                    <input type="hidden" class="total" value="{{$order->total_amount}}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align='left' style='font-size:0px;padding:10px 25px;word-break:break-word;'>
                                    <table border='0' cellpadding='0' cellspacing='0' style='cellpadding:0;cellspacing:0;color:#000000;font-family:Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;' width='100%'>
                                        <tr style="font-size:14px; line-height:19px; font-family: 'Oxygen', 'Helvetica Neue', helvetica, sans-serif; color:#777777">
                                            <td width='50%'></td>
                                            <td style='text-align:right; padding-right: 10px; border-top: 1px solid #cccccc;'>
                                                <span style='display: inline-block;font-weight: bold; color: #4d4d4d'>Total</span>
                                            </td>
                                            <td style='text-align: right; border-top: 1px solid #cccccc;'>
                                                <span style='display: inline-block;font-weight: bold; color: #4d4d4d'>{{$total}}
                                <input type="hidden" name="grand_total" value="{{$total}}"></span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!--[if mso | IE]>
                    </td></tr></table>
                    <![endif]-->
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <!--[if mso | IE]>
    </td>
    </tr>
    </table>
    <![endif]-->
    <table border='0' cellpadding='0' cellspacing='0' style='cellpadding:0;cellspacing:0;color:#000000;font-family:Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;' width='100%'>
        <tr style="font-size:14px; line-height:19px; font-family: 'Oxygen', 'Helvetica Neue', helvetica, sans-serif; color:#777777">
            <td width='30%'></td>
            <td style='text-align:right; padding-right: 10px; '>
                <span style='display: inline-block;font-weight: bold; color: #4d4d4d'>Experation</span>
            </td>
            <td style='text-align: left; '>
                <span style='display: inline-block;font-weight: bold; color: #4d4d4d'>{{$exp}}</span>

            </td>
        </tr>
        <tr style="font-size:14px; line-height:19px; font-family: 'Oxygen', 'Helvetica Neue', helvetica, sans-serif; color:#777777">
            <td width='30%'></td>
            <td style='text-align:right; padding-right: 10px; '>
                <span style='display: inline-block;font-weight: bold; color: #4d4d4d'>Payment Terms:</span>
            </td>
            <td style='text-align: left; '>
                <span style='display: inline-block;font-weight: bold; color: #4d4d4d'>{{$payterm}}</span>

            </td>
        </tr>
    </table>
    <div style='background:#FFFFFF;background-color:#FFFFFF;margin:0px auto;max-width:600px;'>
        <table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#FFFFFF;background-color:#FFFFFF;width:100%;'>
            <tbody>
            <tr>
                <td style='direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;'>
                    <!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:600px;">
                    <![endif]-->
                    <div class='dys-column-per-100 outlook-group-fix' style='direction:ltr;display:inline-block;font-size:13px;text-align:left;vertical-align:top;width:100%;'>
                        <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'>
                            <tr>
                                <td align='center' style='font-size:0px;padding:10px 25px;padding-bottom:5px;word-break:break-word;'>
                                    <div style='color:#4d4d4d;font-family:Oxygen, Helvetica neue, sans-serif;font-size:24px;font-weight:700;line-height:30px;text-align:center;'>
                                       Terms and Condition
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td align='center' style='font-size:0px;padding:10px 25px;padding-top:0px;word-break:break-word;'>
                                    <div style='color:#777777;font-family:Oxygen, Helvetica neue, sans-serif;font-size:14px;line-height:21px;text-align:center;'>
                                        {{$term_and_con}}
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!--[if mso | IE]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    </td>
    </tr>
    </table>
    <![endif]-->
</div>
</body>
</html>