<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Form 16</title>
</head>
<?php use Illuminate\Support\Facades\Crypt; ?>
<body>
    <table
        style="width:640px;color:rgb(51,51,51);margin:0px auto;border-collapse:collapse;border: 1px solid #190390;background-image: url(app/views/themes/myitronline/desktop/assets/img/bookmark.png);background-size: 101% 165%;font-family: -apple-system, system-ui, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, sans-seri f;">
        <tbody>
           

            <tr>
                <td style="padding:10px 35px 20px;vertical-align:top;font-size:12px;line-height:16px;">
                    <table style="width:100%;border-collapse:collapse">
                        <tbody>
                            <tr>
                                <td style="vertical-align:top;font-size:12px;line-height:16px;">
                                    <table style="width:100%;border-collapse:collapse">
                                        <tbody>
                                            <tr>
                                                <td style="vertical-align:top;font-size:12px;line-height:16px;">
                                                    <h3
                                                        style="font-size:18px;color:#190390;margin:15px 0px 8px;font-weight:normal">
                                                        Dear Sir/Madam,</h3>
                                                    <p style="margin:0 0;">Thank you for writing to Myitronline Global
                                                        Services Pvt. Ltd.</p>
                                                </td>
                                                <td rowspan="2"
                                                    style="padding:18px 0px 0px;vertical-align:top;float: right;font-size:12px;line-height:16px;">
                                                    <a href="https://www.myitronline.com/" title="Visit myitronline.com"
                                                        style="text-decoration:none;color:rgb(0,102,153);"
                                                        rel="noreferrer" target="_blank"> <img alt="myitronline.com"
                                                        src="{{ asset('images/myitronline-logo.jpg') }}"
                                                            style="border:0px;top: -22px;position: relative;width: 125px;"
                                                            class="CToWUd"> </a> </td>
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
                                            </tr>
                                            <tr>
                                                <td style="vertical-align:top;font-size:12px;line-height:16px;"> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="border-bottom:1px solid #190390;border-top:3px solid #190390;vertical-align:top;font-size:12px;line-height:16px;">
                                    <h3 style="font-size:18px;color:#190390;margin:10px 0px 10px;font-weight:normal;text-align: center;text-transform: uppercase;">
                                        User Detail</h3>
                                </td>
                               
                            </tr>
                            <tr>
                                <td style="vertical-align:top;font-size:12px;line-height:16px;white-space: nowrap;">
                                    <table style="width:100%;border-collapse:collapse">
                                        <tbody>
                                            <?php if(isset($userDetail)) { //print_r($userDetail);exit; ?>
                                            <tr>
                                                <?php if(isset($userDetail->fname) ){ ?>
                                                <td style="padding: 7px 0;"><b>Name</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $userDetail->fname.' '.$userDetail->lname; ?></td>
                                                <?php }elseif (isset($userDetail->Name)) { ?>
                                                    <td style="padding: 7px 0;"><b>Name</b></td>
                                                    <td
                                                        style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                        <?php echo $userDetail->Name; ?></td>
                                               <?php } ?>
                                                <?php if(isset($userDetail->father_name)){ ?>
                                                <td style="padding: 7px 0;"><b>Father Name</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $userDetail->father_name; ?></td>
                                                <?php } ?>
                                            </tr>
                                            <tr style="border-top: 1px solid #ddd;">
                                                <?php if(isset($userDetail->mobile) || isset($userDetail->phone)){ ?>
                                                <td style="padding: 7px 0;"><b>Mobile No.</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">

                                                    <?php if(isset($userDetail->mobile) ){
                                                        echo $userDetail->mobile;
                                                    }else if(isset($userDetail->phone) ){
                                                        echo $userDetail->phone;
                                                    }?></td>
                                                <?php } ?>
                                                <?php if(isset($userDetail->email) || isset($userDetail->mail)){ ?>
                                                <td style="padding: 7px 0;"><b>Email Id</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php if(isset($userDetail->email) ){
                                                        echo $userDetail->email;
                                                    }else if(isset($userDetail->mail) ){
                                                        echo $userDetail->mail;
                                                    }?>
                                                <?php } ?>
                                            </tr>
                                            
                                            <tr style="border-top: 1px solid #ddd;">
                                                <?php if(isset($userDetail->pan)){ ?>
                                                <td style="padding: 7px 0;"><b>PAN Number</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo ($userDetail->pan); ?>
                                                <?php } ?>
                                                <?php if(isset($userDetail->aadhar_no)){ ?>
                                                <td style="padding: 7px 0;"><b>Aadhaar Number</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $userDetail->aadhar_no; ?></td>
                                                <?php } ?>
                                            </tr>
                                            <tr style="border-top: 1px solid #ddd;">
                                                <?php if(isset($userDetail->companyName)){ ?>
                                                <td style="padding: 7px 0;"><b>Company Name</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $userDetail->companyName; ?></td>
                                                <?php } ?>
                                                <?php if(isset($userDetail->gstin)){ ?>
                                                <td style="padding: 7px 0;"><b>GST Number</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $userDetail->gstin; ?></td>
                                                <?php } ?>
                                            </tr>

                                            <tr style="border-top: 1px solid #ddd;">
                                                <?php if(isset($userDetail->dob)){ ?>
                                                <td style="padding: 7px 0;"><b>DOB</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $userDetail->dob; ?></td>
                                                <?php } ?>
                                                <?php if(isset($userDetail->full_address)){ ?>
                                                <td style="padding: 7px 0;"><b>Address</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $userDetail->full_address; ?></td>
                                                <?php } ?>
                                            </tr>
                                            <tr style="border-top: 1px solid #ddd;">
                                                <?php if(isset($userDetail->bank_name)){ ?>
                                                <td style="padding: 7px 0;"><b>Bank Name</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $userDetail->bank_name; ?></td>
                                                <?php } ?>
                                                <?php if(isset($userDetail->account_number)){ ?>
                                                <td style="padding: 7px 0;"><b>Account No.</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $userDetail->account_number; ?></td>
                                                <?php } ?>
                                            </tr>
                                            <tr style="border-top: 1px solid #ddd;">
                                                <?php if(isset($userDetail->ifsc_code)){ ?>
                                                <td style="padding: 7px 0;"><b>IFSC Code</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $userDetail->ifsc_code; ?></td>
                                                <?php } ?>
                                                <?php if(isset($userDetail->pdfPassword)){ ?>
                                                <td style="padding: 7px 0;"><b>E-filing Password</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $userDetail->pdfPassword; ?></td>
                                                <?php } ?>
                                            </tr>
                                            <tr style="border-top: 1px solid #ddd;">
                                                <?php if(isset($userDetail->net_amount)){ ?>
                                                <td style="padding: 7px 0;"><b>Amount Paid</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    ₹ <?php echo $userDetail->net_amount; ?>.00</td>
                                                <?php } ?>
                                                <?php if(isset($userDetail->createdOn)){ ?>
                                                <td style="padding: 7px 0;"><b>Submission Date</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo Date('d-M-Y', $userDetail->createdOn); ?></td>
                                                <?php } ?>
                                            </tr>
                                          
                                            <?php } ?>
                                            <?php if(isset($expertDetail)) { //print_r($expertDetail);exit; ?>
                                            <?php if(isset($expertDetail['userName'])) { ?>
                                            <tr>
                                                <td style="padding: 7px 0;"><b>Name</b></td>
                                                <td
                                                    style="width:30%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $expertDetail['userName']; ?></td>
                                            </tr>
                                            <?php } ?>
                                            <tr style="border-top: 1px solid #ddd;">
                                                <td style="padding: 7px 0;"><b>Mobile No.</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $expertDetail['userPhone']; ?></td>
                                                <td style="padding: 7px 0;"><b>Email Id</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $expertDetail['userEmail']; ?></td>
                                            </tr>
                                            <tr style="border-top: 1px solid #ddd;">
                                                <td style="padding: 7px 0;"><b>State</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $expertDetail['userState']; ?></td>
                                                <td style="padding: 7px 0;"><b>Service</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $expertDetail['services']; ?></td>
                                            </tr>
                                            <?php } ?>
                                            <?php if(isset($companyLeadDetail)) { //print_r($companyLeadDetail);exit; ?>
                                            <tr>
                                                <td style="padding: 7px 0;"><b>Customer says</b></td>
                                                <td><b>Assist find the same Compnay Name</b></td>
                                            </tr>
                                            <tr style="border-top: 1px solid #ddd;">
                                                <td style="padding: 7px 0;"><b>Name-</b></td>
                                                <td><?php echo $companyLeadDetail['comLeadName']; ?></td>
                                            </tr>
                                            <tr style="border-top: 1px solid #ddd;">
                                                <td style="padding: 7px 0;"><b>Mobile No-</b></td>
                                                <td><?php echo $companyLeadDetail['comLeadNumber']; ?></td>
                                                <td style="padding: 7px 0;"><b>Email Id-</b></td>
                                                <td><?php echo $companyLeadDetail['comLeadEmail']; ?></td>
                                            </tr>
                                            <tr style="border-top: 1px solid #ddd;">
                                                <td style="padding: 7px 0;"><b>City-</b></td>
                                                <td><?php echo $companyLeadDetail['comLeadCity']; ?></td>
                                                <td style="padding: 7px 0;"><b>Company Name</b></td>
                                                <td><?php echo $companyLeadDetail['comLeadCname']; ?></td>
                                            </tr>
                                            <?php } ?>
                                            <?php if(isset($assistDetail)) { //print_r($assistDetail);exit; ?>
                                            <tr>
                                                <td style="padding: 7px 0;"><b>Customer says</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <b>Assist find the same Compnay Name</b></td>
                                            </tr>
                                            <tr style="border-top: 1px solid #ddd;">
                                                <td style="padding: 7px 0;"><b>Mobile No.</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $assistDetail['userMobile']; ?></td>
                                                <td style="padding: 7px 0;"><b>Email Id</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $assistDetail['userEmail']; ?></td>
                                            </tr>
                                            <tr style="border-top: 1px solid #ddd;">
                                                <td style="padding: 7px 0;"><b>Company Name</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;text-transform: uppercase;">
                                                    <?php echo $assistDetail['detailsFor']; ?></td>
                                                <td style="padding: 7px 0;"><b>Company CIN</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;text-transform: uppercase;">
                                                    <?php echo $assistDetail['copmanyCIN']; ?></td>
                                            </tr>
                                            <?php } ?>
                                            <?php if(isset($SaveMcaQData)) { //print_r($SaveMcaQData);exit; ?>
                                            <tr>
                                                <td style="padding: 7px 0;"><b>Customer says</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <b>Unlock complete MCA Data queries?</b></td>
                                            </tr>
                                            <tr style="border-top: 1px solid #ddd;">
                                                <td style="padding: 7px 0;"><b>Mobile No.</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $SaveMcaQData['m2Mobile']; ?></td>
                                                <td style="padding: 7px 0;"><b>Email Id</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $SaveMcaQData['m2Email']; ?></td>
                                            </tr>
                                            <tr style="border-top: 1px solid #ddd;">
                                                <td style="padding: 7px 0;"><b>Company Name</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $SaveMcaQData['detailsFor']; ?></td>
                                                <td style="padding: 7px 0;"><b>Company CIN</b></td>
                                                <td
                                                    style="width:15%;width:1%;font-size:14px;padding:5px 10px 0px;white-space:nowrap;vertical-align:top;line-height:16px;">
                                                    <?php echo $SaveMcaQData['copmanyCIN']; ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top;font-size:12px;line-height:16px;border-top: 1px solid;">
                                    <table style="width:100%;border-collapse:collapse">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p
                                                        style="font-size:17px;font-weight:bold;color:#190390;line-height:1.2;">
                                                        Myitronline is a India's leading tax filing website Registered
                                                        with the Income-tax Department as an e-Return intermediary</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="border-top: 3px solid #190390;padding:18px 0px 15px;color:#190390;vertical-align:top;font-size:18px;line-height:10px;">
                                                    <strong>File your <span style="color:#a6c100">INCOME TAX
                                                            RETURN</span> by using link below:</strong></td>
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
                                                    style="display: inline-block;background: #a6c100;padding: 10px 15px;font-size: 14px;line-height: 1em;font-weight: 600;border-radius: 4px;text-transform: uppercase;margin: 19px 2px 19px 0;">
                                                    <a href="https://myitronline.com/application-form16" target="_blank"
                                                        style="color:#fff;text-decoration: none;">Start your tax
                                                        return</a></td>
                                                <td
                                                    style="display: inline-block;background: #190390;padding: 10px 15px;font-size: 14px;line-height: 1em;font-weight: 600;border-radius: 4px;text-transform: uppercase;margin: 19px 2px 19px 0;">
                                                    <a href="https://myitronline.com/upload-form16" target="_blank"
                                                        style="color:#fff;text-decoration: none;">Upload your
                                                        Form-16</a></td>
                                                <td
                                                    style="display: inline-block;background: #25d366;padding: 10px 15px;font-size: 14px;line-height: 1em;font-weight: 600;border-radius: 4px;text-transform: uppercase;margin: 19px 7px 19px 0;">
                                                    <a href="https://myitronline.com/services/e-filing-services" target="_blank"
                                                        style="color:#fff;text-decoration: none;">Ask An Expert</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="color:#190390;padding:10px 0;border-top:3px solid #190390;vertical-align:top;font-size:12px;line-height:16px;">
                                    This is an automated acknowledgement to your recent e-mail and your e-mail is
                                    important to us.</td>
                            </tr>
                            <tr>
                                <td
                                    style="color:#190390;padding:10px 0;vertical-align:top;font-size:12px;line-height:16px;">
                                    We will revert with the requested details within 24h to 48h. If your query requires
                                    detailed investigation, we will keep you updated with an interim reply sharing the
                                    status. We request you to resend your concern, if you have missed mentioning your
                                    pan no/ efiling password/ mobile no /written from unregistered email ID or any other
                                    detail relevant to your query.</td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top;font-size:12px;line-height:16px;">
                                    <table style="width:100%;border-collapse:collapse">
                                        <tbody>
                                            <tr>
                                                <td align="center"
                                                    style="border-top: 3px solid #190390;padding:18px 0px 0px;vertical-align:top;font-size:12px;line-height:10px;">
                                                    See you at:<p> <a href="www.myitronline.com" target="_blank"
                                                            style="text-decoration:none;">www.myitronline.com</a></p>
                                                    <p style="font-weight:bold;">Thanks & Regards,</p>
                                                    <p
                                                        style="font-size:17px;font-weight:bold;color:#190390;line-height:0;">
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
