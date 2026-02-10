<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Models\V2\API\EfilingModel;
use App\Models\V2\API\UserPan;
use App\Models\V2\API\UserAddress;
use App\Models\V2\API\Form16;
use App\Models\V2\API\Order;

class EfilingController extends Controller
{
    protected $efilingModel;
    protected $metaData;

    public function __construct(EfilingModel $efilingModel)
    {
        $this->efilingModel = $efilingModel;

        $currentYear = date('Y');
        $currentMonth = date('n');

        $preYear = $currentYear - 2; // Adjusted to show FY year as one year prior
        $nextYear = $currentYear - 1; // Adjusted to show AY year as the current year

        // If the current month is after March, update the fiscal year data
        if ($currentMonth >= 3) {
            $preYear = $currentYear - 1;
            $nextYear = $currentYear; // Adjusted to show AY year as the next year
        }

        // Generate the fiscal year strings
        $fyString = "FY $preYear-" . substr($currentYear, 2); // Adjusted to show FY year as one year prior
        $ayString = "AY $currentYear-" . substr($nextYear + 1, 2);

        // Assign fiscal year strings to metaData array
        $this->metaData = [
            'fyString' => $fyString,
            'ayString' => $ayString,
        ];
    }

    /**
     * Validate and get data based on the pincode.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validatePincode(Request $request)
    {
        // Log request data
        \Log::info('Request received for validatePincode', $request->all());

        // Validate the pincode input
        $validatedData = $request->validate([
            'pincode' => 'required|string|max:6|min:6',
        ]);

        $pincode = $validatedData['pincode'];
        \Log::info('Validated Pincode: ' . $pincode);

        $apiKey = '579b464db66ec23bdd000001507837160c8c4ce3663bce61db019da5';
        $url = 'https://api.data.gov.in/catalog/709e9d78-bf11-487d-93fd-d547d24cc0ef?api-key=' . $apiKey . '&format=json&filters[pincode]=' . $pincode;

        \Log::info('API URL: ' . $url);

        $client = new Client();
        try {
            // Make the API request
            $response = $client->get($url);
            $data = json_decode($response->getBody()->getContents());

            // Log the API response
            \Log::info('API Response: ', (array) $data);

            // Check if records are returned
            if (!empty($data->records)) {
                return response()->json([
                    'message' => 'Data retrieved successfully',
                    'status' => 1,
                    'data' => $data->records[0],
                ]);
            } else {
                return response()->json([
                    'message' => 'No data found for the given pincode',
                    'status' => 0,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('API Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
                'status' => 0,
            ]);
        }
    }

    // public function efileIncomeTaxReturn(Request $request)
    // {
    //     $validatedData = Validator::make($request->all(), [
    //         'userId' => 'required|string|max:100',
    //         'pan_number' => 'required|string|max:10',
    //         'aadhar_number' => ['required', 'regex:/^\d{12}$/'],
    //         'dob_data' => 'required|date',
    //         'first_Name' => 'required|string|max:100',
    //         'middle_Name' => 'nullable|string|max:100',
    //         'last_Name' => 'required|string|max:100',
    //         'father_Name' => 'required|string|max:100',
    //         'phone_number' => 'required|string|min:10|max:11',
    //         'email_address' => ['required', 'email:rfc,dns'],
    //         'full_address' => 'required|string|max:255',
    //         'district' => 'required|string|max:100',
    //         'a_State' => 'required|string|max:100',
    //         'pin_code' => 'required|string|max:7',
    //         'account_Number' => 'required|string|min:9|max:18',
    //         'ifsc_Code' => 'required|string|max:100',
    //         'bank_Name' => 'required|string|max:100',
    //         'account_type' => 'required|string|in:saving,current|max:100',
    //         'browser' => 'nullable|string|max:100',
    //         'browserVersion' => 'nullable|string|max:100',
    //         'os' => 'nullable|string|max:100',
    //         'device' => 'nullable|string|max:100',
    //         'ip' => 'nullable|string|max:100',
    //         'source' => 'required|string|max:100',
    //         'domain' => 'required|string|max:100',
    //     ]);

    //     if ($validatedData->fails()) {
    //         return response()->json([
    //             'message' => 'Validation failed',
    //             'status' => 0,
    //             'errors' => $validatedData->errors()
    //         ], 422);
    //     }

    //     $validatedData = $validatedData->validated();

    //     try {
    //         DB::beginTransaction();

    //         $referenceId = 'ref_' . Carbon::now()->timestamp;

    //         // Insert into tbl_user_pan
    //         $userPan = UserPan::create([
    //             'pan' => strtoupper($validatedData['pan_number']),
    //             'AssessmentYear' =>  $this->metaData['ayString'],
    //             'aadhaar' => $validatedData['aadhar_number'],
    //             'dob' => $validatedData['dob_data'],
    //             'createdOn' => Carbon::now()->timestamp,
    //             'userId' => $validatedData['userId'],
    //             'refrence_id' => $referenceId,
    //         ]);
    //         // Insert into tbl_user_address
    //         $userAddress = UserAddress::create([
    //             'full_address' => $validatedData['full_address'],
    //             'address_manual_autometic' => '3',
    //             'district' => $validatedData['district'],
    //             'state' => $validatedData['a_State'],
    //             'pinCode' => $validatedData['pin_code'],
    //             'refrence_id' => $referenceId,
    //         ]);

    //         // Insert into tbl_form16
    //         $form16 = Form16::create([
    //             'first_name' => $validatedData['first_Name'],
    //             'last_name' => $validatedData['last_Name'],
    //             'email' => $validatedData['email_address'],
    //             'phone' => $validatedData['phone_number'],
    //             'father_name' => $validatedData['father_Name'],
    //             'dob' => $validatedData['dob_data'],
    //             'refrence_id' => $referenceId,
    //             'account_number' => $validatedData['account_Number'],
    //             'pan_number' => $validatedData['pan_number'],
    //             'pan_id' => $userPan->id,
    //             'address_id' => $userAddress->id,
    //             'AssessmentYear' => $this->metaData['ayString'],
    //             'form16_source' => '3',
    //             'source' => 'API',
    //             'full_address' => $validatedData['full_address'],
    //             'createdOn' => Carbon::now()->timestamp,
    //         ]);

    //         // Calculate GST and total amount
    //         $amount = 500;
    //         $gstRate = 18;
    //         $totalGst = ($amount * $gstRate) / 100;
    //         $cgst = $totalGst / 2;
    //         $sgst = $totalGst / 2;
    //         $net_amount = $amount + $totalGst;
    //         $orderId = 'ODI' . time() . rand(111,  9999);

    //         // Insert into tbl_order
    //         $order = Order::create([
    //             'fname' => $validatedData['first_Name'],
    //             'lname' => $validatedData['last_Name'],
    //             'form16_id' => $form16->id,
    //             'userId' => $validatedData['userId'],
    //             'email' => $validatedData['email_address'],
    //             'mobile' => $validatedData['phone_number'],
    //             'pan' => strtoupper($validatedData['pan_number']),
    //             'pinCode' => $validatedData['pin_code'],
    //             'orderFromName' => 'eitrfiling',
    //             'createdBy' => $validatedData['userId'],
    //             'createdOn' => Carbon::now()->timestamp,
    //             'amount' => $amount,
    //             'cgstAmt' => $cgst,
    //             'sgstAmt' => $sgst,
    //             'net_amount' => round($net_amount),
    //             'tax_amount' => $totalGst,
    //             'orderFrom' => 'APP-API',
    //             'orderId' => $orderId,
    //             'browser' => $validatedData['browser'],
    //             'browserVersion' => $validatedData['browserVersion'],
    //             'os' => $validatedData['os'],
    //             'device' => $validatedData['device'],
    //             'ip' => $validatedData['ip'],
    //             'source' => $validatedData['source'],
    //             'domain' => $validatedData['domain'],
    //         ]);

    //         DB::commit();

    //         $encryptedOrderId = Crypt::decryptString($orderId);

    //         return response()->json([
    //             'message' => 'Form 16 Data Added',
    //             'status' => 1,
    //             'data' => [
    //                 'response' => $order->id,
    //                 'orderId' => $encryptedOrderId,
    //             ],
    //         ]);

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'message' => 'An error occurred',
    //             'status' => 0,
    //             'errors' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    function efileIncomeTaxReturn(Request $request)
    {
      try {
        $validatedData = $request->validate([
            'userId' => 'required|string|max:100',
          'full_Name' => 'required|string|max:255',
          'pan_number' => 'nullable|string|max:255',
          'dob_data' => 'required|date',
          'user_email' => 'required|email:rfc,dns',
          'user_phone' => 'required|string|min:10|max:11',
          'father_Name' => 'required|string|max:255',
          'full_address' => 'required|string|max:255',
          'account_Number' => 'required|string|min:9|max:18',
          'ifsc_Code' => 'required|string|max:255',
          'bank_Name' => 'required|string|max:255',
          'browser' => 'nullable|string|max:100',
            'browserVersion' => 'nullable|string|max:100',
            'os' => 'nullable|string|max:100',
            'device' => 'nullable|string|max:100',
            'ip' => 'nullable|string|max:100',
            'source' => 'required|string|max:100',
            'domain' => 'required|string|max:100',
            'serviceUrl' => 'required',
            'pdfFile' => 'required|file|mimes:pdf|max:5048',
        //   'pdfFiles.*' => 'required|file|mimes:pdf|max:5048', // Ensure each file is a PDF and limit file size
        ]);
  
        $file = $request->file('pdfFile');

      
        if (!$file) {
            return response()->json(['error' => 'File not uploaded'], 400);
        }
        
        $destinationPath = public_path('uploads/form16');
        $filename = 'ref_' . time() . '_' . uniqid() . '.pdf';
        
        $file->move($destinationPath, $filename);
        
        $fileUrl = asset('uploads/form16/' . $filename);
        
// // print_r($fileUrl); die;
// // Optional: store $fileUrl in database or return it

//         $filePaths = [];
  
//         foreach ($files as $file) {
//           $directory = 'uploads/form16';
//           $filename = 'ref_' . Carbon::now()->timestamp . '_' . uniqid() . '.pdf';
//           $path = $file->storeAs($directory, $filename, 'public'); // Use Laravel's storage
//           $filePaths[] = asset('storage/' . $path); // Generate the URL
//         }
  
  
      
//         $filePathsJson = json_encode($filePaths); Print_r($filePathsJson); die;
  
        $form16Data = [
          'first_name' => $validatedData['full_Name'],
          'email' => $validatedData['user_email'],
          'phone' => $validatedData['user_phone'],
          'father_name' => $validatedData['father_Name'],
          'refrence_id' => 0,
          'full_address' => $validatedData['full_address'],
          'account_number' => $validatedData['account_Number'],
          'ifsc_code' => $validatedData['ifsc_Code'],
          'bank_name' => $validatedData['bank_Name'],
          'createdOn' => Carbon::now()->timestamp,
          'form16_source' => 3,
          'pan_number' => $validatedData['pan_number'],
          'dob' => $validatedData['dob_data'],
          
          'pdfPassword' => $request->input('e_filing_pass'),
          'pdfFilePath' => $fileUrl,
        ];
  
        // Calculate amounts
        $amount = 1000;
        $gstRate = 18;
        $totalGst = ($amount * $gstRate) / 100;
        $cgst = $totalGst / 2;
        $sgst = $totalGst / 2;
        $net_amount = $amount + $totalGst;
  
        // Start transaction
        DB::beginTransaction();
  
        // Insert form16 data
        $form16Id = DB::table('tbl_form16')->insertGetId($form16Data);
  
        // Generate order ID
        $orderId = 'ODI' . time() . rand(111, 9999);
  
        // Insert order data
        $order = DB::table('tbl_order')->insert([
          'fname' => $validatedData['full_Name'],
          'email' => $validatedData['user_email'],
          'mobile' => $validatedData['user_phone'],
          'pan' => $validatedData['pan_number'],
          'form16_id' => $form16Id,
          'orderId' => $orderId,
          'userId' => $validatedData['userId'],
         
          'createdBy' => $validatedData['userId'],
          'createdOn' => Carbon::now()->timestamp,
          'amount' => $amount,
          'cgstAmt' => $cgst,
          'sgstAmt' => $sgst,
          'net_amount' => round($net_amount),
          'tax_amount' => $totalGst,
          'paymentStatus' => 2,
          'serviceUrl' => $request->serviceUrl,
          'orderFromName' => 'Application-Form16',
          'orderFrom' => 'APP-API',
          'orderId' => $orderId,
          'browser' => $validatedData['browser'],
                'browserVersion' => $validatedData['browserVersion'],
                'os' => $validatedData['os'],
                'device' => $validatedData['device'],
                'ip' => $validatedData['ip'],
        ]);
  
        // Commit transaction
        DB::commit();
  
        // $data['message'] = 'Form16 added';
        // $data['status'] = 1;
        // $data['data'] = $form16Id . "_" . Carbon::now()->timestamp;
        // $key = env('APP_KEY');
        $decryptedOrderId = Crypt::encryptString($orderId);

        // $data['orderId'] = $encrypt_orderId;
  
        // return response()->json($data);
        return response()->json([
            'message' => 'Form 16 Data Added',
            'status' => 1,
            'data' => [
                // 'response' => $order->id,
                'orderId' => $decryptedOrderId,
                'order' => $orderId,
            ],
        ]);
      } catch (ValidationException $e) {
        return response()->json([
            'message' => 'An error occurred',
            'status' => 0,
            'errors' => $e->getMessage()
        ], 500);
      } catch (\Exception $e) {
        // Rollback transaction if any error occurs
        DB::rollBack();
        return response()->json([
            'message' => 'An error occurred',
            'status' => 0,
            'errors' => $e->getMessage()
        ], 500);
      }
    }
    public function efileIncomeTaxReturn_bkp(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'userId' => 'required|string|max:100',
            'pan_number' => 'required|string|max:10',
            'aadhar_number' => ['required', 'regex:/^\d{12}$/'],
            'dob_data' => 'required|date',
            'first_Name' => 'required|string|max:100',
            'middle_Name' => 'nullable|string|max:100',
            'last_Name' => 'required|string|max:100',
            'father_Name' => 'required|string|max:100',
            'phone_number' => 'required|string|min:10|max:11',
            'email_address' => ['required', 'email:rfc,dns'],
            'full_address' => 'required|string|max:255',
            'district' => 'required|string|max:100',
            'a_State' => 'required|string|max:100',
            'pin_code' => 'required|string|max:7',
            'account_Number' => 'required|string|min:9|max:18',
            'ifsc_Code' => 'required|string|max:100',
            'bank_Name' => 'required|string|max:100',
            'account_type' => 'required|string|in:saving,current|max:100',
            'browser' => 'nullable|string|max:100',
            'browserVersion' => 'nullable|string|max:100',
            'os' => 'nullable|string|max:100',
            'device' => 'nullable|string|max:100',
            'ip' => 'nullable|string|max:100',
            'source' => 'required|string|max:100',
            'domain' => 'required|string|max:100',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status' => 0,
                'errors' => $validatedData->errors()
            ], 422);
        }

        $validatedData = $validatedData->validated();

        try {
            DB::beginTransaction();

            $referenceId = 'ref_' . Carbon::now()->timestamp;

            // Insert into tbl_user_pan
            $userPan = UserPan::create([
                'pan' => strtoupper($validatedData['pan_number']),
                'AssessmentYear' =>  $this->metaData['ayString'],
                'aadhaar' => $validatedData['aadhar_number'],
                'dob' => $validatedData['dob_data'],
                'createdOn' => Carbon::now()->timestamp,
                'userId' => $validatedData['userId'],
                'refrence_id' => $referenceId,
            ]);

            // Insert into tbl_user_address
            $userAddress = UserAddress::create([
                'full_address' => $validatedData['full_address'],
                'address_manual_autometic' => '3',
                'district' => $validatedData['district'],
                'state' => $validatedData['a_State'],
                'pinCode' => $validatedData['pin_code'],
                'refrence_id' => $referenceId,
            ]);

            // Insert into tbl_form16
            $form16 = Form16::create([
                'first_name' => $validatedData['first_Name'],
                'last_name' => $validatedData['last_Name'],
                'email' => $validatedData['email_address'],
                'phone' => $validatedData['phone_number'],
                'father_name' => $validatedData['father_Name'],
                'dob' => $validatedData['dob_data'],
                'refrence_id' => $referenceId,
                'account_number' => $validatedData['account_Number'],
                'pan_number' => $validatedData['pan_number'],
                'pan_id' => $userPan->id,
                'address_id' => $userAddress->id,
                'AssessmentYear' => $this->metaData['ayString'],
                'form16_source' => '3',
                'source' => 'API',
                'full_address' => $validatedData['full_address'],
                'createdOn' => Carbon::now()->timestamp,
            ]);

            // Calculate GST and total amount
            $amount = 500;
            $gstRate = 18;
            $totalGst = ($amount * $gstRate) / 100;
            $cgst = $totalGst / 2;
            $sgst = $totalGst / 2;
            $net_amount = $amount + $totalGst;
            $orderId = 'ODI' . time() . rand(111,  9999);

            // Encrypt the orderId before storing
            $encryptedOrderId = Crypt::encryptString($orderId);

            // Insert into tbl_order
            $order = Order::create([
                'fname' => $validatedData['first_Name'],
                'lname' => $validatedData['last_Name'],
                'form16_id' => $form16->id,
                'userId' => $validatedData['userId'],
                'email' => $validatedData['email_address'],
                'mobile' => $validatedData['phone_number'],
                'pan' => strtoupper($validatedData['pan_number']),
                'pinCode' => $validatedData['pin_code'],
                'orderFromName' => 'eitrfiling',
                'createdBy' => $validatedData['userId'],
                'createdOn' => Carbon::now()->timestamp,
                'amount' => $amount,
                'cgstAmt' => $cgst,
                'sgstAmt' => $sgst,
                'net_amount' => round($net_amount),
                'tax_amount' => $totalGst,
                'orderFrom' => 'APP-API',
                'orderId' => $orderId,
                'browser' => $validatedData['browser'],
                'browserVersion' => $validatedData['browserVersion'],
                'os' => $validatedData['os'],
                'device' => $validatedData['device'],
                'ip' => $validatedData['ip'],
                'source' => $validatedData['source'],
                'domain' => $validatedData['domain'],
            ]);

            DB::commit();

            // Decrypt the orderId before returning it
            $decryptedOrderId = Crypt::encryptString($order->orderId);

            return response()->json([
                'message' => 'Form 16 Data Added',
                'status' => 1,
                'data' => [
                    'response' => $order->id,
                    'orderId' => $decryptedOrderId,
                    'order' => $orderId,
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred',
                'status' => 0,
                'errors' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Generate a JSON response.
     *
     * @param string $message
     * @param int $status
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse($message, $status, $data = null)
    {
        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ]);
    }
}
