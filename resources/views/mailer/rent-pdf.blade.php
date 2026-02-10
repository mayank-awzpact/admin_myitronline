<!DOCTYPE html>
<html>
<head>
    <title>RENT RECEIPT</title>
</head>
<body>
<?php use Illuminate\Support\Facades\Crypt; ?>
  <style> .rent-receipt { background-size: cover; display: block; padding: 0; position: relative; page-break-inside: avoid; } .cut-line { border-bottom: 1px dashed #766e6e; clear: both; display: block; height: 1px; margin-bottom: 75px; padding-top: 75px; } .rent-heading { color: #a6c100; font-size: 30px; margin-bottom: 20px; } .rent-heading .month-rent { color: #222 !important; font-size: 26px; font-weight: 400; } .valign-bottom { vertical-align: bottom; line-height: 1.5; } .date-rent-receipt { font-size: 18px; margin-top: 40px; position: relative; } .footer-content { color: #231f20; margin-top: 30px; position: relative; } a { margin: 0; padding: 0; font-size: 100%; vertical-align: baseline; background: transparent; } .valign-bottom { vertical-align: bottom; line-height: 1.5; } .bg-rent-logo { bottom: 15px; position: absolute; width: 80%; text-align: center; left: 10%; opacity: 0.2; }</style> 
<div class="cut-line"></div>
<div class="rent-receipt">
    <table width="100%">
        <tbody>
        <tr>
            <td>
                <h1 class="rent-heading">RENT RECEIPT <span class="month-rent">( {{ date('F, Y') }} )</span></h1>
            </td>
            <td></td>
        </tr>
        <tr>
            <td class="valign-bottom" width="70%">
                <p class="content-rent-receipt">Received a sum of
                    <strong>RS. {{ isset($SaveRentReceiptData['monthlyRent']) ? strtoupper($SaveRentReceiptData['monthlyRent']) : '' }}/-</strong> from
                    <strong>{{ isset($SaveRentReceiptData['name']) ? strtoupper($SaveRentReceiptData['name']) : '' }}</strong> towards the rent of
                    property situated at <strong>{{ isset($SaveRentReceiptData['houseAddress']) ? strtoupper($SaveRentReceiptData['houseAddress']) : '' }}</strong> for the period
                    <strong>{{ isset($SaveRentReceiptData['generateDate']) ? strtoupper($SaveRentReceiptData['generateDate']) : '' }} TO {{ isset($SaveRentReceiptData['generateToDate']) ? strtoupper($SaveRentReceiptData['generateToDate']) : '' }}</strong>
                </p>
                <p class="date-rent-receipt">Date: <strong>{{ isset($SaveRentReceiptData['generateToDate']) ? strtoupper($SaveRentReceiptData['generateToDate']) : '' }}</strong></p>
                <p class="footer-content"><em>Rent Receipt Generator by
                        <a href="https://www.myitronline.com" title="www.myitronline.com" target="_blank">Myitronline.com</a></em>
                </p>
            </td>
            <td align="center" class="valign-bottom">
                <div>
                    <img src="https://myitronline.com/images/stamp-paper.jpeg" width="61" height="71">
                    <p>SIGNATURE (LANDLORD)</p>
                    <p>{{ isset($SaveRentReceiptData['ownerName']) ? strtoupper(($SaveRentReceiptData['ownerName'])) : '' }}.</p>
<p>{{ isset($SaveRentReceiptData['ownerPAN']) ? strtoupper(Crypt::decrypt($SaveRentReceiptData['ownerPAN'])) : '' }}</p>

                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="bg-rent-logo">
        <img src="https://myitronline.com/images/myitronline-logo.jpg" alt="MYITRONLINE">
    </div>
</div>
<div class="cut-line"></div>
</body>
</html>
