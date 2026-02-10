<!DOCTYPE html>
<html>
  <head>
    <title></title>
  </head>
  <body>
    <style>
      .rent-receipt {
          background-size: cover;
          display: block;
          padding: 0;
          position: relative;
          page-break-inside: avoid;
      }
      .cut-line {
        border-bottom: 1px dashed #766e6e;
        clear: both;
        display: block;
        height: 1px;
        margin-bottom: 75px;
        padding-top: 75px;
    }
      .rent-heading {
          color: #a6c100;
          font-size: 30px;
          margin-bottom: 20px;
      }
      .rent-heading .month-rent {
          color: #222 !important;
          font-size: 26px;
          font-weight: 400;
      }
      .valign-bottom {
          vertical-align: bottom;
          line-height: 1.5;
      }
      .date-rent-receipt {
          font-size: 18px;
          margin-top: 40px;
          position: relative;
      }
      .footer-content {
          color: #231f20;
          margin-top: 30px;
          position: relative;
      }
      a {
          margin: 0;
          padding: 0;
          font-size: 100%;
          vertical-align: baseline;
          background: transparent;
      }
      .valign-bottom {
          vertical-align: bottom;
          line-height: 1.5;
      }
      .bg-rent-logo {
        bottom: 15px;
        position: absolute;
        width: 80%;
        text-align: center;
        left: 10%;
        opacity: 0.2;
    }
    </style>
    <div class="cut-line"></div>
    <div class="rent-receipt">
      <table width="100%">
        <tbody>
          <tr>
            <td>
              <h1 class="rent-heading">RENT&nbsp;RECEIPT <span class="month-rent">( <?php echo date('F, Y'); ?> )</span></h1>
            </td>
            <td></td>
          </tr>
          <tr>
          <?php print_r($SaveRentReceiptData); ?>
            <td class="valign-bottom" width="70%">
              <p class="content-rent-receipt">Received a sum of
                <strong>Rs. <?php if(isset($SaveRentReceiptData->monthlyRent)){ echo $SaveRentReceiptData->monthlyRent;} ?>/-</strong> from
                <strong><?php if(isset($SaveRentReceiptData->name)){ echo $SaveRentReceiptData->name;} ?></strong> towards the rent of property situated at
                <strong><?php if(isset($SaveRentReceiptData->houseAddress)){ echo $SaveRentReceiptData->houseAddress;} ?></strong> for the period
                <strong><?php if(isset($SaveRentReceiptData->generateDate)){ echo $SaveRentReceiptData->generateDate;} ?> to <?php if(isset($SaveRentReceiptData->generateToDate)){ echo $SaveRentReceiptData->generateToDate;} ?></strong>
              </p>
              <p class="date-rent-receipt">Date: <strong><?php if(isset($SaveRentReceiptData->generateToDate)){ echo $SaveRentReceiptData->generateToDate;} ?></strong></p>
              <p class="footer-content"><em>Rent Receipt Generator by
                <a href="https://www.myitronline.com" title="www.myitronline.com" target="_blank">Myitronline.com</a></em>
              </p>
            </td>
            <td align="center" class="valign-bottom">
              <div>
                <img src="data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAABGAAD/4QMvaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjAtYzA2MCA2MS4xMzQ3NzcsIDIwMTAvMDIvMTItMTc6MzI6MDAgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkY1REMxOUIzRTBGMjExRTZCNTVDOTE1MDIxNkFBNTI0IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkY1REMxOUIyRTBGMjExRTZCNTVDOTE1MDIxNkFBNTI0IiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE1IChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjM5N0VDQThCREQ2NTExRTZCRkNBRDdGRjlGMUQ4NjYxIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjM5N0VDQThDREQ2NTExRTZCRkNBRDdGRjlGMUQ4NjYxIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+/+4ADkFkb2JlAGTAAAAAAf/bAIQABAMDAwMDBAMDBAYEAwQG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" width="61" height="71">
                <p>Signature (Landlord)</p>
                <p><?php if(isset($SaveRentReceiptData->ownerName)){ echo $SaveRentReceiptData->ownerName;} ?></p>
                <p><?php if(isset($SaveRentReceiptData->ownerPAN)){ echo $SaveRentReceiptData->ownerPAN;} ?></p>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="bg-rent-logo">
        <img src="https://myitronline.com/app/views/themes/myitronline/desktop/assets/img/logo.png" alt="">
      </div>
    </div>
    <div class="cut-line"></div>
  </body>
</html>