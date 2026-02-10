<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVOICE</title>
</head>
<body>
    <table style="width:520px;color:rgb(51,51,51);margin:0px auto;border-collapse:collapse;border: 1px solid #190390;">
        <tbody>
            <tr>
                <td style="padding:10px 10px 20px;vertical-align:top;font-size:12px;line-height:16px;">
                    <table style="width:100%;border-collapse:collapse">
                        <tbody>
                            <tr>
                                <td style="vertical-align:top;font-size:12px;line-height:16px;">
                                    <table style="width:100%;border-collapse:collapse">
                                        <tbody>
                                            <tr>
                                                <td style="border-bottom:1px solid;">
                                                    <h1 style="font-weight: bold;color: #190390;text-align: left;">
                                                        INVOICE</h1>
                                                </td>
                                                <td
                                                    style="border-bottom: 1px solid;width: 29%;padding:18px 0px 0px;vertical-align:top;text-align: right;">
                                                    <a href="https://www.myitronline.com/" title="Visit myitronline.com"
                                                        style="text-decoration:none;color:rgb(0,102,153);"
                                                        rel="noreferrer" target="_blank">
                                                        <img alt="myitronline.com"
                                                            src="https://myitronline.com/images/myitronline-logo.jpg"
                                                            style="margin-top: -20px;width: 130px;" class="CToWUd"></a>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top;font-size:12px;line-height:16px;">
                                    <table style="width:100%;border-collapse:collapse">
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="border-bottom: 3px solid #190390;vertical-align:top;color: #190390;line-height:10px;">
                                                    <div
                                                        style="font-size: 12px;font-weight: 900;text-transform: uppercase;line-height: 1.5;">
                                                        Myitronline Global Services Private Limited</div>
                                                    <p style="font-size:12px;line-height: 1.5;margin:0;">305 3RD FLOOR
                                                        PLOT NO 51 HASANPUR, IP Extension,<br> Patparganj, Delhi, 110092
                                                    </p>
                                                    <p style="font-size:16px;line-height: 1.2;">Ph No.:+91 -
                                                        9971055886&nbsp;<br>Email : <a
                                                            href="mailto:info@myitronline.com"
                                                            style="text-decoration:none;">info@myitronline.com</a>
                                                    <h2 style="font-size:13px;">GST No.: 07AAMCM1869L1ZU</h2>
                                                </td>
                                                <td
                                                    style="border-bottom: 3px solid #190390;width: 29%;padding:18px 0px 0px;vertical-align:top;text-align: right;">
                                                    <h3>Invoice No. #{{ $invoiceNo }}</h3>
                                                    <h3>{{ \Carbon\Carbon::now('Asia/Kolkata')->format('d/m/Y H:i:s') }}
                                                    </h3>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top;font-size:12px;line-height:16px;">
                                    <table style="width:100%;border-collapse:collapse">
                                        <tbody>
                                            <tr>
                                                <td style="vertical-align:top;font-size:12px;line-height:15px;">
                                                    <h3
                                                        style="font-size:18px;color:#190390;margin:15px 0px 8px;font-weight:normal;text-transform: capitalize;">
                                                        Hello
                                                        @if (isset($userDetail->fname))
                                                            {{ $userDetail->fname }} {{ $userDetail->lname }}
                                                        @endif
                                                        @if (isset($userDetail->name))
                                                            {{ $userDetail->name }}
                                                        @endif
                                                        ,
                                                    </h3>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <?php if(isset($userDetail->userGstNumber) && ($userDetail->userGstNumber != Null)){ ?>
                            <tr>
                                <td style="vertical-align:top;font-size:12px;line-height:16px;">
                                    <table style="width:100%;border-collapse:collapse">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div
                                                        style="font-size:12px;font-weight: 900;text-transform: uppercase;line-height: 1.5;">
                                                        {{ $userDetail->companyName }}</div>
                                                    <p style="font-size:12px;line-height: 1.5;margin:0;">
                                                        {{ $userDetail->companyAddress }},<br>
                                                        {{ $userDetail->state }}<br>
                                                    <h2 style="font-size:13px; color: #190390;">GST No.:
                                                        {{ $userDetail->userGstNumber }}</h2>
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td
                                    style="border-top:1px solid #190390;vertical-align:top;font-size:12px;line-height:20px;">
                                    <table style="width:100%;border-collapse:collapse">
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="color:#000;padding:5px 0px 0px;font-size:14px;text-transform: capitalize;">
                                                    <strong>
                                                        {{ $userDetail->orderFromName }}
                                                    </strong>
                                                </td>
                                                <td
                                                    style="text-align:right;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:25px;">
                                                    <strong>Rs. {{ number_format($userDetail->amount, 2) }}</strong>
                                                    <br>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="border-bottom:1px solid #190390;border-top:3px solid #190390;vertical-align:top;font-size:12px;line-height:16px;">
                                    <h3
                                        style="font-size:18px;color:#190390;margin:10px 0px 10px;font-weight:normal;text-align: center;text-transform: uppercase;">
                                        Invoice Summary</h3>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top;font-size:12px;line-height:16px;">
                                    <table class="table-bordered" style="width:100%;border-collapse:collapse">
                                        <tbody>
                                            <tr>
                                                <td colspan="2"
                                                    style="border-top:1px solid #190390;padding:0px 0px 16px;text-align:right;line-height:18px;vertical-align:top;font-size:12px;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="text-align:right;line-height:20px;padding:0px 10px 5px 0px;vertical-align:top;font-size:20px;">
                                                    Subtotal: </td>
                                                <td
                                                    style="width:150px;text-align:right;line-height:20px;padding:0px 10px 5px 0px;vertical-align:top;font-size:20px;">
                                                    Rs. {{ number_format($userDetail->amount, 2) }} </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"
                                                    style="text-align:right;line-height:20px;padding:0px 10px 0px 0px;vertical-align:top;font-size:20px;">
                                                    <p style="margin:4px 0px 0px;"></p>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td colspan="2"
                                                    style="text-align:right;line-height:20px;padding:0px 10px 0px 0px;vertical-align:top;font-size:20px;">
                                                    <p style="margin:4px 0px 0px;"></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="text-align:right;line-height:20px;padding:0px 10px 5px 0px;vertical-align:top;font-size:20px;">
                                                    CGST (9%): </td>
                                                <td
                                                    style="width:150px;text-align:right;line-height:20px;padding:0px 10px 5px 0px;vertical-align:top;font-size:20px;">
                                                    Rs. {{ number_format($userDetail->cgstAmt, 2) }} </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="text-align:right;line-height:20px;padding:0px 10px 5px 0px;vertical-align:top;font-size:20px;">
                                                    SGST (9%): </td>
                                                <td
                                                    style="width:150px;text-align:right;line-height:20px;padding:0px 10px 5px 0px;vertical-align:top;font-size:20px;">
                                                    Rs. {{ number_format($userDetail->sgstAmt, 2) }} </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="font-size:20px;text-align:right;padding:0px 10px 0px 0px;vertical-align:top;line-height: 20px;">
                                                    <strong>Grand Total: </strong> </td>
                                                <td
                                                    style="font-size:20px;text-align:right;padding:0px 10px 0px 0px;vertical-align:top;line-height: 20px;;">
                                                    <strong>Rs. {{ number_format($userDetail->net_amount, 2) }}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top;font-size:12px;line-height:16px;">
                                    <table style="width:100%;border-collapse:collapse">
                                        <tbody>
                                            <tr>
                                                <td align="center" style="border-top: 3px solid #190390;padding:18px 0px 0px;vertical-align:top;font-size:15px;line-height:10px;">
                                                    <p style="margin:0 0;">Thank you for showing interest to Myitronline
                                                        Global Services Pvt. Ltd.</p>
                                                    <p>See you at:
                                                    <p> <a href="www.myitronline.com"
                                                            target="_blank">www.myitronline.com</a></p>
                                                    <p style="font-size:15px;">Thanks & Regards,</p>
                                                    <p
                                                        style="font-size:17px;font-weight:bold;color:#190390;line-height:1;">
                                                        Team Myitronline</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
