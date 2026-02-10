<?php
namespace App\Models;
// use DB;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use PDF;
class APIV1Model extends Authenticatable
{
    public function userLogin_check($data)
    {
        if (isset($data['email'])) {
            $query = DB::table('tbl_users_data')->select('surName', 'email', 'pan', 'mobile', 'fName', 'lName', 'id','gender', 'password');
            if (isset($data['email'])) {
                $query->where('email', $data['email']);
            }
            $resp = $query->get()->toArray();
            if (count($resp) > 0) {
                if (isset($data['password']) && ($data['password'] != '')) {
                    if (Hash::check($data['password'], $resp[0]->password)) {
                        return $resp;
                    } else {
                        return 2;
                    }
                } else {
                    return $resp;
                }
            } else {
                return 3;
            }
        } else {
            return 0;
        }
    }
    public function userRegister($data)
    {
        if (isset($data['email'])) {
            $save['email'] = $data['email'];
        }
        $query = DB::table('tbl_users_data')->select('email');
        if (isset($data['email'])) {
            $query->where('email', $data['email']);
            $query->orWhere('mobile', $data['mobile']);
        }
        $resp = $query->get();
        if (count($resp) > 0) {
            return $retrun = 2;
        } else {
            if (isset($data['name'])) {
                $save['surName'] = $data['name'];
                $save['fName'] = $data['name'];
            }
            if (isset($data['mobile'])) {
                $save['mobile'] = $data['mobile'];
            }
            if (isset($data['gender'])) {
                $save['gender'] = $data['gender'];
            }
            if (isset($data['password'])) {
                $save['password'] = Hash::make($data['password']);
            }
            $save['createdOn'] =  time();
            $save['domain_source'] =  'Mobile';
            DB::table('tbl_users_data')->insert($save);
            $query = DB::table('tbl_users_data')->select('surName', 'email', 'pan', 'mobile', 'fName', 'lName', 'id');
            $query->where('email', $data['email']);
            return $resp = $query->get()->toArray();
        }
    }
    public function getBloglist()
    {
        $query = DB::table('tbl_blog')->select('uniqueId', 'title', 'title_alias', 'synopsis', 'introImage');
        return $resp = $query->get()->toArray();
    }
    public function guideList($cat)
    {
        $query = DB::table('tbl_guide_article')->select('uniqueId', 'urlTitle', 'urlSlug', 'synposis');
        if ($cat) {
            // $query->where('category', $cat);
        }
        return $resp = $query->get()->toArray();
    }
    public function guideUniqueData($uniqueId)
    {
        $query = DB::table('tbl_guide_article')->select('uniqueId', 'urlTitle', 'urlSlug', 'synposis');
        if ($uniqueId) {
            $query->where('uniqueId', $uniqueId);
        }
        return $resp = $query->get()->toArray();
    }
    public function getBlogdata($uniqueId)
    {
        $query = DB::table('tbl_blog')->select('uniqueId', 'title', 'description');
        if ($uniqueId) {
            $query->where('uniqueId', $uniqueId);
        }
        return $resp = $query->get()->toArray();
    }
    public function getblogReview($uniqueId)
    {
        $query = DB::table('tbl_blog_review')->select('*');
        if ($uniqueId) {
            $query->where('blogUniqueId', $uniqueId);
        }
        return $resp = $query->get()->toArray();
    }
    public function insertBlogReview($data)
    {
        if (isset($data['name'])) {
            $save['name'] = $data['name'];
        }
        if (isset($data['rating'])) {
            $save['rating'] = $data['rating'];
        }
        if (isset($data['email'])) {
            $save['email'] = $data['email'];
        }
        if (isset($data['review'])) {
            $save['review'] = $data['review'];
        }
        if (isset($data['title'])) {
            $save['title'] = $data['title'];
        }
        if (isset($data['blogUniqueId'])) {
            $save['blogUniqueId'] = $data['blogUniqueId'];
        }
        $save['domain_source'] =  'Mobile';
        $save['creadedOn'] =   time();
        if ($save) {
            return $resp =   DB::table('tbl_blog_review')->insert($save);
        } else {
            return  $resp = 0;
        }
    }
    public function insertForm16($data)
    {
        // print_r($data);die;
        if (isset($data['full_name'])) {
            $save['Name'] = $data['full_name'];
        }
        if (isset($data['mobile'])) {
            $save['mobile'] = $data['mobile'];
        }
        if (isset($data['email'])) {
            $save['email'] = $data['email'];
        }
        if (isset($data['pan'])) {
            $save['pan'] = $data['pan'];
        }
        if (isset($data['aadhar_no'])) {
            $save['aadhar_no'] = $data['aadhar_no'];
        }
        if (isset($data['birthdate'])) {
            $save['birthdate'] = $data['birthdate'];
        }
        if (isset($data['father_name'])) {
            $save['father_name'] = $data['father_name'];
        }
        if (isset($data['address'])) {
            $save['address'] = $data['address'];
        }
        if (isset($data['bank_name'])) {
            $save['bank_name'] = $data['bank_name'];
        }
        if (isset($data['bank_ifsc'])) {
            $save['bank_ifsc'] = $data['bank_ifsc'];
        }
        if (isset($data['bank_ac_no'])) {
            $save['bank_ac_no'] = $data['bank_ac_no'];
        }
        if (isset($data['efilingPassword'])) {
            $save['efilingPassword'] = $data['efilingPassword'];
        }
        if (isset($data['form16'])) {
            $save['form16'] = $data['form16'];
        }
        $save['form_category'] = 'Mobile';
        $save['domain_source'] = '1';
        $save['deviceSource'] = 'Mobile';
        $save['referFrom'] = '2';
        // $save['amount'] = 500;
        $save['amount'] = 500;
        $gst = $save['amount'] /18;
        $save['tax'] = $gst;
        $save['netAmt'] = $gst + $save['amount'];
        $save['createdOn'] = time();
        $save['orderId'] = 'ODI'.time();
        if (isset($data['fomr16pwd'])) {
            $save['form16pwd'] = $data['fomr16pwd'];
        }
        if (isset($data['userIPaddress'])) {
            $save['userIPaddress'] = $data['userIPaddress'];
        }
        if ($save) {
             DB::table('tbl_user_application')->insert($save);
           return  $save['orderId'];
        } else {
            return  $resp = 0;
        }
    }
    public function insertRentReceipt($data)
    {
        if (isset($data['name_of_tenant'])) {
            $save['name'] = $data['name_of_tenant'];
        }
        if (isset($data['token'])) {
            $save['userId'] = $data['token'];
        }
        if (isset($data['email'])) {
            $save['email'] = $data['email'];
        }
        if (isset($data['mobile'])) {
            $save['phoneNumber'] = $data['mobile'];
        }
        if (isset($data['tenant_pan'])) {
            $save['tenant_pan'] = $data['tenant_pan'];
        }
        if (isset($data['monthly_rent'])) {
            $save['monthlyRent'] = $data['monthly_rent'];
        }
        if (isset($data['full_address'])) {
            $save['houseAddress'] = $data['full_address'];
        }
        if (isset($data['ownerName'])) {
            $save['ownerName'] = $data['ownerName'];
        }
        if (isset($data['ownerPAN'])) {
            $save['ownerPAN'] = $data['ownerPAN'];
        }
        if (isset($data['tenant_pan'])) {
            $save['tenant_pan'] = $data['tenant_pan'];
        }
        if (isset($data['generateDate'])) {
            $save['generateDate'] = $data['generateDate'];
        }
        if (isset($data['generateToDate'])) {
            $save['generateToDate'] = $data['generateToDate'];
        }
        if (isset($data['userIPaddress'])) {
            $save['userIPaddress'] = $data['userIPaddress'];
        }
        if (isset($data['deviceType'])) {
            $save['deviceType'] = $data['deviceType'];
        }
        $save['createdOn'] =  time();
        // print_r($save);die;
        if ($save) {
            return $resp =   DB::table('tbl_rent_receipt')->insertGetId($save);
        } else {
            return  $resp = 0;
        }
    }
    public function getRentReceipt($id,$from)
    {
        $query = DB::table('tbl_rent_receipt')->select('*');
        if (($id) && ($from == 'uniqueId')) {
            $query->where('uniqueId', $id);
        }
        if (($id) && ($from == 'userId')) {
            $query->where('userId', $id);
        }
        $query->orderByDesc('tbl_rent_receipt.uniqueId');
        return $resp = $query->get()->toArray();
    }
    function forgetPassword($data)
    {
        if ((isset($data['email'])) && (isset($data['password'])) && (($data['email'] != '')) && (($data['password']) != '')) {
            $save['email'] = $data['email'];
            $query = DB::table('tbl_users_data')->select('email');
            if ($data['email']) {
                $query->where('email', $data['email']);
            }
            $resp = $query->get()->toArray();
            if (count($resp) > 0) {
                $arr['password']  = Hash::make($data['password']);
                return $resp = DB::table('tbl_users_data')
                    ->where('email', $data['email'])
                    ->update($arr);
            } else {
                return $retrun = 2;
            }
        } else {
            return $retrun = 3;
        }
    }
    function save_GoogleLogin_details($data)
    {
        if ((isset($data['email'])) && ($data['email'] != '')) {
            $save['email'] = $data['email'];
            $query = DB::table('tbl_users_data')->select('*');
            $query->where('email', $data['email']);
            $resp = $query->get()->toArray();
            // print_r($resp);die;
            if (count($resp) > 0) {
                return $resp[0]->id;
            } else {
                if (isset($data['name'])) {
                    $save['fName'] = $data['name'];
                }
                if (isset($data['profile'])) {
                    $save['userPic'] = $data['profile'];
                }
                    $save['password'] = Hash::make('myitronline');

                $save['createdOn'] = time();
                return  $resp = DB::table('tbl_users_data')->insertGetId($save);
            }
        } else {
            return 0;
        }
    }
    function forgetPasswordSaveOTP($data)
    {
        if (isset($data['email'])) {
            $save['email'] = $data['email'];
        }
        $query = DB::table('tbl_users_data')->select('email');
        if (isset($data['email'])) {
            $query->where('email', $data['email']);
        }
        $res = $query->get()->toArray();
        if (count($res) > 0) {
            if (isset($data['otp'])) {
                $save['otp'] = $data['otp'];
            }
            $authCode = $this->generateRandomString(20);
            $save['accesstoken'] = $authCode;
            $save['createdOn'] = time();
            $save['validUpto'] = strtotime('+3 minutes', time());
            $resp = DB::table('tbl_apk_otp')->insert($save);
            if ($resp) {
                return $authCode;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function VerifyOTP($data)
    {
        $query = DB::table('tbl_apk_otp')->select('email', 'mobile', 'validUpto');
        if ($data['email']) {
            $query->where('email', $data['email']);
        }
        if ($data['otp']) {
            $query->where('otp', $data['otp']);
        }
        if ($data['token']) {
            $query->where('accesstoken', $data['token']);
        }
        $resp = $query->get()->toArray();
        if (count($resp) > 0) {
            if ($resp[0]->validUpto < Carbon::now()->timestamp) {
                return $return = 2;
            } else {
                DB::table('tbl_apk_otp')
                        ->where('email', $data['email'])
                        ->where('otp', $data['otp'])
                        ->update(['otp_verified' => 1]);
                return $return = 1;
            }
        } else {
            return $return = 3;
        }
    }
    function updateUserprofile($data,$img = ''){
        if (isset($data['firstname'])) {
            $save['fName'] = $data['firstname'];
        }
        if (isset($data['lastname'])) {
            $save['lName'] = $data['lastname'];
        }
        if (isset($data['phonenumber'])) {
            $save['mobile'] = $data['phonenumber'];
        }
        if (isset($data['dob'])) {
            $save['birthdate'] = $data['dob'];
        }
        if (isset($data['gender'])) {
            $save['gender'] = $data['gender'];
        }
        if (isset($data['pan'])) {
            $save['pan'] = $data['pan'];
        }
        if (isset($data['aadhar'])) {
            $save['aadhaar'] = $data['aadhar'];
        }
        if ((isset($img)) && ($img != '')) {
            $save['userPic'] = $img;
        }
        if (isset($data['email'])) {
            $email = $data['email'];
            $save['updatedOn'] =  time();
        }
            // print_r($save);die;
        if ($save) {
            if($data['from_where_login'] == 'google_login'){
               return  $resp = DB::table('tbl_users_data')
                ->where('email', $email)
                ->update($save);
            }else if($data['from_where_login'] == 'web_login'){
                return $resp = DB::table('tbl_users_data')
                ->where('email', $email)
                ->update($save);
        } else {
            return  $resp = 0;
    }
    }
    }
    function getUserprofile($id=''){
        // echo $id;die;
        if($id != ''){
            $query = DB::table('tbl_users_data')->select('userPic','surName','email', 'id', 'pan', 'mobile', 'fName', 'lName', 'id','gender', 'aadhaar','birthdate','createdOn','updatedOn');
        if ($id) {
            $query->where('id', $id);
        }
       return $resp = $query->get()->toArray();
        // print_r($resp);die;
        }else{
            return false;
        }
    }
    function getForm16Order($orderId = '') {
        if($orderId != ''){
            $query = DB::table('tbl_user_application')->select('*');
            $query->where('orderId', $orderId);
            return $resp = $query->get()->toArray();
        // print_r($resp);die;
        }else{
            return false;
        }
    }
    function getEmpProfile($id = '') {
        if ($id) {
            $query = DB::table('tbl_users')
                ->select([
                    'userId',
                    'userName',
                    'phone',
                    'firstName',
                    'lastName',
                    'emp_id',
                    'emp_Joining_Date',
                    'dob',
                    'gender',
                    'biography',
                    'website',
                    'Twitter',
                    'Facebook',
                    'linkedin',
                    'instagram',
                    'other_link',
                    'location',
                    'job_title',
                    'profile_picture',
                    'status',
                    'createdOn',
                ])
                ->where('userId', $id)
                ->first();

            return $query ? (array) $query : false;
        } else {
            return false;
        }
    }

    function payConsultingFee($data){
        if (isset($data['fname'])) {
            $save['fname'] = $data['fname'];
        }
        if (isset($data['fname']) || isset($data['lname'])) {
            $save['Name'] = $data['fname'].' '.$data['lname'];
        }
        if (isset($data['lname'])) {
            $save['lname'] = $data['lname'];
        }
        if (isset($data['phonenumber'])) {
            $save['mobile'] = $data['phonenumber'];
        }
        if (isset($data['email'])) {
            $save['email'] = $data['email'];
        }
        if (isset($data['pan'])) {
            $save['pan'] = $data['pan'];
        }
        if (isset($data['amount'])) {
            $save['referFrom'] = '3';
            $save['amount'] = $data['amount'];
            $amount = $data['amount'];
            // $save['amount'] = 0;
            // $amount = 0;

            $gst_percentage = 18;
            $gst_amount = $amount * ($gst_percentage / 100);
            $save['cgstAmt'] = $gst_amount / 2;
            $save['sgstAmt'] = $gst_amount / 2;
            $save['tax'] = $gst_amount;
            $save['netAmt'] = $amount + $gst_amount;
        }
        $save['domain_source'] = '1';
        if (isset($data['email'])) {
            $email = $data['email'];
            $createdOn =  time();
            $save['createdOn'] =  $createdOn;
            $save['orderId'] =  'ODI'.$createdOn;
        }
        if ($save) {
                  $respo = DB::table('tbl_user_application')->insert($save);
               $authCode = $this->generateRandomString(20);
            //    $otpInsert['email'] = $data['email'];
            //    $otpInsert['otp'] =  mt_rand(111111,999999);;
            //    $otpInsert['accesstoken'] = $authCode;
            //    $otpInsert['createdOn'] = time();
            //    $otpInsert['validUpto'] = strtotime('+3 minutes', time());
            //    $resp = DB::table('tbl_apk_otp')->insert($otpInsert);
            //    $data1["email"] = $_POST['email'];
            //    $data1["otp"] = $otpInsert['otp'];
            //    $data1["title"] = ' MYITRONLINE App Verify number';
            //    $data1["subject"] = 'Thank you for Choose Service on MyITROnline';
            //    Mail::send('mailer.common_mail_tpl', $data1, function ($message) use ($data1) {
            //        $message->to($data1["email"], $data1["email"])
            //            ->subject($data1["title"]);
            //        // ->attachData($pdf->output(), "invoice.pdf");
            //    });
               $aarr['orderId'] = $save['orderId'];
               $aarr['authCode'] = $authCode;
               return $aarr;
        } else {
            return  $resp = 0;
    }
    }
    public function sendEmail($data2,$getUserD)
    {
        // print_r($data);die;
        $receiptId = 'inv-' . $getUserD[0]->orderId;
        $data = [
            'userD' => $getUserD[0],
        ];
        $pdf = PDF::loadView('mailer.invoice_tpl', $data);
        $path = public_path('upload/consultancyInvoiceAPI/V1/');
        $fileName = 'MYITRAPK' . $receiptId . '.pdf';
        $invoicePath = 'https://admin1.myitronline.com/public/upload/consultancyInvoiceAPI/V1/' . $fileName;
        $pdf->save($path . '/' . $fileName);
            $respSummary = DB::table('tbl_user_application')
            ->where('orderId', $getUserD[0]->orderId)
            ->update([
                'invoicePath' => $invoicePath,
            ]);
            $data1["email"] = $getUserD[0]->email;
            $data1["title"] = ' MYITRONLINE App';
            $data1["subject"] = $data2['subject'];
            $data1["userDetail"] = $getUserD;
            // print_r($data1);die;
          $resp =  Mail::send('mailer.email_tpl', $data1, function ($message) use ($data1, $pdf) {
                $message->to($data1["email"], $data1["email"])
                    ->subject($data1["title"])
                ->attachData($pdf->output(), "invoice.pdf");
            });
    if($resp){
            $data1['message'] = 'Mail Sent successfully';
            $data1['status'] = 1;
        } else {
            $data1['message'] = 'Something went wrong';
            $data1['status'] = 0;
        }
        return response()->json($data1);
    }
    public function all_orders($id){
        if($id != ''){
            return $results = DB::table('tbl_users_data')
                ->join('tbl_user_application', 'tbl_users_data.email', '=', 'tbl_user_application.email')
                ->select('tbl_user_application.orderId','tbl_user_application.createdOn','tbl_user_application.paymentStatus','tbl_user_application.referFrom')
                ->where('tbl_users_data.id', $id)
                ->orderByDesc('tbl_user_application.uniqueId')
                ->get()->toArray();
        }else{
            return false;
        }
    }
    public function single_order($orderId){
        if($orderId != ''){
               $query = DB::table('tbl_user_application')->select('invoicePath','paymentStatus','invoiceNo','Name','email','address','amount','tax','netAmt','companyName','pan','mobile','createdOn');
            $query->where('orderId', $orderId);
            return $resp = $query->get()->toArray();
        }else{
            return false;
        }
    }

    function manageForm16BB($p) {
        $arrData = [];

        if(isset($p['fullName']))
            $arrData["fullName"] = $p['fullName'];

        if(isset($p['pan']))
            $arrData["pan"] = $p['pan'];

        if(isset($p['fathersName']))
            $arrData["fathersName"] = $p['fathersName'];

        if(isset($p['place']))
            $arrData["place"] = $p['place'];

        if(isset($p['mobileNo']))
            $arrData["mobileNo"] = $p['mobileNo'];

        if(isset($p['emailId']))
            $arrData["emailId"] = $p['emailId'];

        if(isset($p['houseAddress']))
            $arrData["houseAddress"] = $p['houseAddress'];

        if(isset($p['employeeID']))
            $arrData["employeeID"] = $p['employeeID'];

        if(isset($p['designationEmp']))
            $arrData["designationEmp"] = $p['designationEmp'];

        if(isset($p['nameOfOrganisation']))
            $arrData["nameOfOrganisation"] = $p['nameOfOrganisation'];

        if(isset($p['organisationEmailId']))
            $arrData["organisationEmailId"] = $p['organisationEmailId'];

        if(isset($p['hraRentPaidToLandlord']))
            $arrData["hraRentPaidToLandlord"] = $p['hraRentPaidToLandlord'];

        if(isset($p['hraEvidence']))
            $arrData["hraEvidence"] = $p['hraEvidence'];

        if(isset($p['typeofLender']))
            $arrData["typeofLender"] = $p['typeofLender'];

        if(isset($p['hraLandlordName']))
            $arrData["hraLandlordName"] = $p['hraLandlordName'];

        if(isset($p['hraLandlordPan']))
            $arrData["hraLandlordPan"] = $p['hraLandlordPan'];

        if(isset($p['hraLandlordAddress']))
            $arrData["hraLandlordAddress"] = $p['hraLandlordAddress'];

        if(isset($p['itaAmount']))
            $arrData["itaAmount"] = $p['itaAmount'];

        if(isset($p['itaEvidence']))
            $arrData["itaEvidence"] = $p['itaEvidence'];

        if(isset($p['homeLoanInterestPayable']))
            $arrData["homeLoanInterestPayable"] = $p['homeLoanInterestPayable'];

        if(isset($p['homeLoanLenderName']))
            $arrData["homeLoanLenderName"] = $p['homeLoanLenderName'];

        if(isset($p['homeLoanLenderPan']))
            $arrData["homeLoanLenderPan"] = $p['homeLoanLenderPan'];

        if(isset($p['homeLoanLenderAddress']))
            $arrData["homeLoanLenderAddress"] = $p['homeLoanLenderAddress'];

        if(isset($p['homeLoanLenderEvidence']))
            $arrData["homeLoanLenderEvidence"] = $p['homeLoanLenderEvidence'];

        if(isset($p['dednEightyC']))
            $arrData["dednEightyC"] = $p['dednEightyC'];

        if(isset($p['dednEightyCAmount']))
            $arrData["dednEightyCAmount"] = $p['dednEightyCAmount'];

        if(isset($p['dednEightyCEvidence']))
            $arrData["dednEightyCEvidence"] = $p['dednEightyCEvidence'];

        if(isset($p['eightyCCCAmount']))
            $arrData["eightyCCCAmount"] = $p['eightyCCCAmount'];

        if(isset($p['eightyCCCProff']))
            $arrData["eightyCCCProff"] = $p['eightyCCCProff'];

        if(isset($p['eightyCCDAmount']))
            $arrData["eightyCCDAmount"] = $p['eightyCCDAmount'];

        if(isset($p['eightyCCDProff']))
            $arrData["eightyCCDProff"] = $p['eightyCCDProff'];

        if(isset($p['dednOther']))
            $arrData["dednOther"] = $p['dednOther'];

        if(isset($p['dednOtherAmount']))
            $arrData["dednOtherAmount"] = $p['dednOtherAmount'];

        if(isset($p['dednOtherEvidence']))
            $arrData["dednOtherEvidence"] = $p['dednOtherEvidence'];

        $arrData["createdOn"] = time();

        // Use query builder to insert data
        return DB::table('tbl_form12_bb')->insert($arrData);
    }
    public function check_emp_data($emp_id)
{
    $existingData = DB::table('tbl_users')
        ->where('emp_id', $emp_id)
        ->where('isTrashed', 0)
        ->exists();
    return $existingData;
}
function checkIn_checkdata($emp_id){
        $existingData = DB::table('tbl_emp_attendance')
        ->where('emp_id', $emp_id)
        ->whereDate('date', Carbon::now()->toDateString())
        ->where('isTrashed', 0)
        ->exists();
        return $existingData;
}
public function employeeCheck_In_out($data)
{
    // echo 'hi';die;
    $empId = $data['emp_id'] ?? null;
    $currentDate = Carbon::now()->toDateString();
    $existingRecord = DB::table('tbl_emp_attendance')
        ->where('emp_id', $empId)
        ->whereDate('date', $currentDate)
        ->where('isTrashed', 0)
        ->first();
    if ($existingRecord) {
        if ($existingRecord->check_out != '') {
              return 2;
        } else {
              $resp = DB::table('tbl_emp_attendance')
                ->where('emp_id', $empId)
                ->whereDate('date', $currentDate)
                ->where('isTrashed', 0)
                ->update([
                    'check_out' => $data['time'],
                    'latitude_out' => $data['latitude'] ?? null,
                    'longitude_out' => $data['longitude'] ?? null,
                    'updatedOn' => Carbon::now()->timestamp,
                    'full_address_checkOut' => $data['full_address'] ?? null,
                ]);
            return $resp ? $resp : 0;
        }
    } else {
        $save = [

            'emp_id' => $empId,
            'emp_unique_id' => $data['emp_unique_id'] ?? null,
            'check_in' => $data['time'],
            'full_address' => $data['full_address'] ?? null,
            'latitude_in' => $data['latitude'] ?? null,
            'longitude_in' => $data['longitude'] ?? null,
            'date' => $currentDate,
            'createdOn' => Carbon::now()->timestamp,
        ];
        if (isset($data['image'])) {
            $imageData = str_replace(' ', '+', $data['image']);
            $save['userPic'] = $imageData;
        }
        $resp = DB::table('tbl_emp_attendance')->insert($save);
        return $resp ? $resp : 0;
    }
}
    function employeeTodayCheck($data){
        $emp_unique_id = $data['emp_unique_id'];
        $currentDate = Carbon::now()->toDateString();

        $existingRecord = DB::table('tbl_emp_attendance as attendance')
        ->select(
            'attendance.check_in',
            'attendance.check_out',
            DB::raw("CONCAT(users.firstName, ' ', users.lastName) as name")
        )
        ->join('tbl_users as users', 'attendance.emp_unique_id', '=', 'users.userId')
        ->where('users.userId', $emp_unique_id)
        ->whereDate('attendance.date', $currentDate)
        ->where('attendance.isTrashed', 0)
        ->first();
        return $existingRecord ? $existingRecord :0;

    }
    function totalWorkingDaysInMonth() {
        // Get the current month and year
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Calculate the total number of days in the current month
        $totalDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

        // Initialize a variable to store the total working days
        $totalWorkingDays = 0;

        // Loop through each day of the month
        for ($day = 1; $day <= $totalDaysInMonth; $day++) {
            $date = "$currentYear-$currentMonth-$day";
            $dayOfWeek = date('N', strtotime($date)); // Get the day of the week (1 for Monday, 7 for Sunday)
            // Check if the day is not Sunday (dayOfWeek != 7)
            if ($dayOfWeek != 7) {
                // If it's not Sunday, increment the total working days
                $totalWorkingDays++;
            }
        }

        return $totalWorkingDays;
    }
    function employeeTotalAttendanse($data){
        $emp_unique_id = $data['emp_unique_id'];
        // Get the current month and year
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Calculate the total number of days in the current month
        $totalDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

        // Initialize a variable to store the total present days
        $totalPresentDays = 0;

        // Loop through each day of the month
        for ($day = 1; $day <= $totalDaysInMonth; $day++) {
            $date = "$currentYear-$currentMonth-$day";
            $dayOfWeek = date('N', strtotime($date)); // Get the day of the week (1 for Monday, 7 for Sunday)
            // Check if the day is not Sunday (dayOfWeek != 7)
            if ($dayOfWeek != 7) {
                // Check if there is an existing record for the employee and day
                $existingRecord = DB::table('tbl_emp_attendance')
                    ->where('emp_unique_id', $emp_unique_id)
                    ->whereDate('date', $date)
                    ->where('isTrashed', 0)
                    ->first();
                // If record exists, increment the total present days
                if ($existingRecord) {
                    $totalPresentDays++;
                }
            }
        }

        return $totalPresentDays;
    }
    function employeeMonthRecord($data){
        $emp_unique_id = $data['emp_unique_id'];
        $currentMonth = date('m');
        $currentYear = date('Y');
        $startDate = "$currentYear-$currentMonth-01";
        $endDate = date('Y-m-t', strtotime($startDate)); // Get the last day of the current month

        $existingRecords = DB::table('tbl_emp_attendance')
            ->where('emp_unique_id', $emp_unique_id)
            ->where('isTrashed', 0)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        return $existingRecords->isEmpty() ? [] : $existingRecords->toArray();
    }
    function EmployeeforgetPasswordSaveOTP($data)
    {
        if (isset($data['email'])) {
            $save['email'] = $data['email'];
        }
        $query = DB::table('tbl_users')->select('userName');
        if (isset($data['email'])) {
            $query->where('userName', $data['email']);
        }
        $res = $query->get()->toArray();
        if (count($res) > 0) {
            if (isset($data['otp'])) {
                $save['otp'] = $data['otp'];
            }
            $authCode = $this->generateRandomString(20);
            $save['accesstoken'] = $authCode;
            $save['createdOn'] = time();
            $save['validUpto'] = strtotime('+3 minutes', time());
            $resp = DB::table('tbl_apk_otp')->insert($save);
            if ($resp) {
                return $authCode;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    function employeeverifyOTP($data)
    {
        $query = DB::table('tbl_apk_otp')->select('email', 'mobile', 'validUpto');
        if ($data['email']) {
            $query->where('email', $data['email']);
        }
        if ($data['otp']) {
            $query->where('otp', $data['otp']);
        }
        if ($data['token']) {
            $query->where('accesstoken', $data['token']);
        }
        $resp = $query->get()->toArray();
        if (count($resp) > 0) {
            if ($resp[0]->validUpto < Carbon::now()->timestamp) {
                return $return = 2;
            } else {
                    DB::table('tbl_apk_otp')
                        ->where('email', $data['email'])
                        ->where('otp', $data['otp'])
                        ->update(['otp_verified' => 1]);

                return $return = 1;
            }
        } else {
            return $return = 3;
        }
    }


}
