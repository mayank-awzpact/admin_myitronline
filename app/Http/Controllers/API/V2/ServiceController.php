<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\V2\API\Service;
use Carbon\Carbon;

use App\Models\V2\API\Category;
use App\Jobs\SendInvoiceEmail;
use App\Jobs\SendOrderConfirmationEmail;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_Id' => 'required|integer|min:1'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()], 400);
        }
    
        $category_Id = $request->input('category_Id');
    
        // Fetch services where categoryIds matches the provided category_Id
        $services = Service::where('categoryIds', $category_Id)->get();
    
        if ($services->isEmpty()) {
            return response()->json(['status' => 404, 'message' => 'No services found for the provided category'], 404);
        }
    
        return response()->json([
            'status' => 1,
            'data' => $services,
            'error' => null,
            'message' => 'Services retrieved successfully',
        ]);
    }
    

    public function show($id)
    {
        
        // Validate service_id as a single integer in the URL
        $validator = Validator::make(['service_id' => $id], [
            'service_id' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()], 400);
        }

        // Find the service by ID
        // $results = Service::find($id);
        $results = DB::table('tbl_service_v2')
            ->join('tbl_category_v2', 'tbl_service_v2.categoryIds', '=', 'tbl_category_v2.uniquid')
            ->where('tbl_category_v2.isTrashed', 0)
            ->where('tbl_service_v2.isTrashed', 0);
    
            $results->where('tbl_service_v2.uniqueId', $id);
      
    
        // Select required columns
        $results = $results->select(
            'tbl_service_v2.*',
            
            'tbl_category_v2.alias',
            'tbl_category_v2.heading',
            'tbl_category_v2.synopsis',
          DB::raw('(tbl_service_v2.servicePrice - (tbl_service_v2.servicePrice * tbl_service_v2.priceDiscount / 100)) as discount_price'),

        )
        ->get() // Make sure to get the results
        ->toArray(); // Convert to array

        if (!$results) {
            return response()->json(['status' => 404, 'message' => 'Service not found'], 404);
        }

        return response()->json([
            'status' => 1,
            'data' => $results,
            'error' => null,
            'message' => 'Service retrieved successfully',
        ]);
    }
    public function eca_package_list(Request $request)
    {
        $p['cat_slug'] = 'e-filing-services'; // Assuming you want to set a default value
        $results = DB::table('tbl_service_v2')
            ->join('tbl_category_v2', 'tbl_service_v2.categoryIds', '=', 'tbl_category_v2.uniquid')
            ->where('tbl_category_v2.isTrashed', 0)
            ->where('tbl_service_v2.isTrashed', 0);
    
        // Apply conditions for the category slug if set
        if (isset($p['cat_slug']) && $p['cat_slug'] != '') {
            $results->where('tbl_category_v2.alias', $p['cat_slug']);
        }
        if (isset($request->cat_slugs) && $request->cat_slugs != '') {
            $results->where('tbl_category_v2.alias', $request->cat_slugs);
        }
    
        // Select required columns
        $results = $results->select(
            'tbl_service_v2.uniqueId',
            'tbl_service_v2.efiling_service_section',
            'tbl_service_v2.serviceName',
            'tbl_service_v2.serviceHeading',
            'tbl_service_v2.serviceAlias',
            'tbl_service_v2.servicePrice',
            'tbl_service_v2.serviceSynopsis',
            'tbl_service_v2.secTitle',
            'tbl_service_v2.secDescrption',
            'tbl_category_v2.alias',
            'tbl_category_v2.heading',
            'tbl_category_v2.synopsis',
          DB::raw('(tbl_service_v2.servicePrice - (tbl_service_v2.servicePrice * tbl_service_v2.priceDiscount / 100)) as discount_price'),

        )
        ->get() // Make sure to get the results
        ->toArray(); // Convert to array
    
        // Return the response as JSON
        return response()->json([
            'status' => 1,
            'data' => $results,
            'error' => null,
            'message' => 'Service retrieved successfully',
        ]);
    }
    public function ServiceCreateOrder(Request $request)
    {
        // Validate request inputs
        $validator = Validator::make($request->all(), [
           
            'amount' => 'required|min:0',
            'discount' => 'required|nullable|min:0',
            // 'tax_amount' => 'required|nullable|min:0',
            // 'cgstAmt' => 'required|nullable|min:0',
            // 'sgstAmt' => 'required|nullable|min:0',
            // 'net_amount' => 'required|min:0',
            'user_id' => 'required',
            'service_name' => 'required',
            'browser' => 'required',
            'browserVersion' => 'required',
            'os' => 'required',
            'device' => 'required',
            'ip' => 'required',
            'serviceUrl' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()], 400);
        }
    
        // Retrieve additional data
        $respo = DB::table('tbl_users_data')->where('id', $request->user_id)->get(); // Replace with actual user fetch logic
        if (!$respo || count($respo) == 0) {
            return response()->json(['status' => 404, 'message' => 'User not found'], 404);
        }
    
        // $price = $request->amount; 
        // $discountPercent = $request->discount ?? 0; 
        
        // $discountAmount = ($price * $discountPercent) / 100;
        
       
        // $cgstAmt = $request->cgstAmt ?? 0;
        // $sgstAmt = $request->sgstAmt ?? 0;
        
      
        // $net_amount = $price - $discountAmount + $cgstAmt + $sgstAmt;
        $price = $request->amount; // Original amount
        $discountPercent = $request->discount ?? 0;

        // Step 1: Apply discount
        $discountAmount = ($price * $discountPercent) / 100;
        $discountedPrice = $price - $discountAmount;

        // Step 2: Calculate CGST and SGST (9% each on discounted price)
        $cgstPercent = 9;
        $sgstPercent = 9;

        $cgstAmt = ($discountedPrice * $cgstPercent) / 100;
        $sgstAmt = ($discountedPrice * $sgstPercent) / 100;

        // Step 3: Calculate net amount
        $netAmount = $discountedPrice + $cgstAmt + $sgstAmt;

        
    
        $orderId = 'ODI' . time() . rand(111, 9999);
        $userId = $request->user_id;
    
        if (!$userId) {
            return response()->json(['status' => 401, 'message' => 'User not authenticated'], 401);
        }
    
        // Insert order into database
        DB::table('tbl_order')->insert([
            'fname' => $respo[0]->fName,
            'lname' => $respo[0]->lName,
            'email' => $respo[0]->email,
            'mobile' => $respo[0]->mobile,
            'form16_id' => 0,
            'orderId' => $orderId,
            'userId' => $userId,
            'createdBy' => $userId,
            'createdOn' => time(),
            'amount' => $discountedPrice,
            'discount' => $discountPercent,
            'tax_amount' => $cgstAmt + $sgstAmt,
            'cgstAmt' => $cgstAmt,
            'sgstAmt' => $sgstAmt,
            'net_amount' => round($netAmount),
            'paymentStatus' => 2,
            'orderFrom' => 'service',
            'orderFromName' => $request->service_name, // Replace with dynamic service name
            'serviceUrl' => $request->serviceUrl,
            'browser' => $request->browser,
            'browserVersion' => $request->browserVersion,
            'os' => $request->os,
            'device' => $request->device,
            'ip' => $request->ip,
        ]);
    
        return response()->json([
            'status' => 1,
            'data' => $orderId,
            'error' => null,
            'message' => 'Order created successfully',
        ]);
    }
   
    public function contact_us(Request $request)
    {
    //    $data = DB::table('tbl_contact_us')->get();
    //    print_r($data);die;
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'message' => 'nullable|string',
        ]);
    
        try {
            $nameParts = explode(' ', $validated['full_name'], 2); 
            $first_name = $nameParts[0];
            $last_name = isset($nameParts[1]) ? $nameParts[1] : ''; 
    
            $device_location = $request->input('device_location', null);
            $device_name = $request->input('device_name', null);
    
            $data = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $validated['email'],
                'contact_details' => $validated['phone_number'],
                'department' => $validated['message'],
                'deviceLocation' => $device_location,
                'deviceName' => $device_name,
                'status' => 1,
                'createdOn' => time(),
            ];
    
            $insertedId = DB::table('tbl_contact_us')->insertGetId($data);
    
            return response()->json([
                'message' => 'Data successfully stored',
                'status' => 200,
                'data' => array_merge($data, ['id' => $insertedId]),
            ], 200);
        } catch (\Exception $e) {
            // Log::error('Error storing clarity record: ' . $e->getMessage());
    
            return response()->json([
                'message' => 'An error occurred while storing the record',
                'error' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }
    public function getTestimonials()
{
    try {
        $testimonials = DB::table('tbl_user_review')
            ->select([
                'userName',
                'uniqueId',
                'userComments',
                'ratingCount',
                'userImagePath',
                DB::raw("DATE(createdOn) as createdOn")
            ])
            ->get();

        if ($testimonials->isEmpty()) {
            return response()->json([
                'message' => 'No testimonials found.',
                'data' => [],
            ], 200);
        }

        return response()->json([
            'message' => 'Testimonials retrieved successfully.',
            'data' => $testimonials,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'An error occurred while fetching testimonials.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
public function job_apply(Request $request)
{
    $messages = [
        'name.required' => 'Name is required.',
        'email.required' => 'Email is required.',
        'email.email' => 'Email must be a valid email address.',
        'mobile_no.required' => 'Mobile number is required.',
        'current_location.required' => 'Current location is required.',
        'total_experience.required' => 'Total experience is required.',
        'latest_qualification.required' => 'Qualification is required.',
        'resume.required' => 'Resume file is required.',
        'resume.file' => 'Resume must be a valid file.',
        'key_skills.required' => 'Key skills are required.',
    ];

    $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'email' => 'required|email',
        'mobile_no' => 'required|string',
        'current_location' => 'required|string',
        'total_experience' => 'required|string',
        'latest_qualification' => 'required|string',
        'resume' => 'required|file|mimes:pdf,doc,docx',
        'key_skills' => 'required|string',
    ], $messages);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Fill in the required field !!',
            'errors' => $validator->errors(),
        ], 422);
    }

    try {
        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $destinationPath = public_path('job/resume');

            if (!file_exists($destinationPath) && !mkdir($destinationPath, 0777, true)) {
                throw new \Exception('Failed to create upload directory.');
            }

            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
            $resumePath = 'job/resume/' . $fileName;
        } else {
            return response()->json([
                'message' => 'An error occurred while processing your request.',
                'error' => 'File upload failed.',
            ], 500);
            // throw new \Exception('File upload failed.');
        }

        // Insert data directly into the database
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'current_location' => $request->current_location,
            'total_experience' => $request->total_experience,
            'latest_qualification' => $request->latest_qualification,
            'resume_path' => $resumePath,
            'key_skills' => $request->key_skills,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('job_applied')->insert($data);

        return response()->json([
            'message' => 'Job applied successfully.',
            'data' => $data,
        ], 200);
    } catch (\Exception $e) {
        // Log::error('Job application failed: ' . $e->getMessage(), [
        //     'stack' => $e->getTraceAsString(),
        // ]);

        return response()->json([
            'message' => 'An error occurred while processing your request.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
public function CallBackRequest(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'number' => ['required', 'string', 'regex:/^\d{10}$/'],
        'name' => 'required|string',
    ]);

    try {
        $nameParts = explode(' ', trim($request->name), 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        DB::table('tbl_contact_us')->insert([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $request->email,
            'contact_details' => $request->number,
            'deviceLocation' => $request->deviceLocation,
            'deviceName' =>$request->deviceName,
        ]);

        return response()->json(['message' => 'Callback request saved successfully.'], 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to save callback request.', 'details' => $e->getMessage()], 500);
    }
}
public function payConsultingFee(Request $request)
{
    // Validation rules
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:100',
        'mobile' => 'required|digits:10|starts_with:6,7,8,9',
        'email' => 'required|email:rfc,dns|max:100',
        'pan' => 'required|alpha_num|size:10',
        'amount' => 'required|numeric|min:1',
        'browser' => 'required|string|max:50',
        'browserVersion' => 'nullable|string|max:20',
        'os' => 'required|string|max:50',
        'device' => 'nullable|string|max:50',
        'ip' => 'required|ip',
        'serviceUrl' => 'required',
    ]);

    // Return validation errors
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation errors occurred.',
            'errors' => $validator->errors(),
        ], 500);
    }

    // Split name into firstname and lastname
    $name = $request->input('name');
    $userId = $request->input('userId');
    $nameParts = explode(' ', trim($name), 2); // Split into two parts
    $firstname = $nameParts[0];
    $lastname = isset($nameParts[1]) ? $nameParts[1] : ''; // Use empty string if no last name

    // Calculate taxes and net amount
    $amount = $request->input('amount');
    $cgstAmt = round($amount * 0.09, 2); // 9% CGST
    $sgstAmt = round($amount * 0.09, 2); // 9% SGST
    $tax_amount = round($amount * 0.18, 2); // Total GST (18%)
    $net_amount = round($amount + $tax_amount, 2); // Total amount after tax

    // Generate unique orderId
    $orderId = 'ODI' . now()->timestamp;

    // Prepare data
    $data = $validator->validated();
    $data['fname'] = $firstname;
    $data['lname'] = $lastname;
    unset($data['name']); // Remove the original 'name' field
    $data['paymentStatus'] = 2;
    $data['orderId'] = $orderId;
    $data['cgstAmt'] = $cgstAmt;
    $data['sgstAmt'] = $sgstAmt;
    $data['userId'] = $userId;
    $data['tax_amount'] = $tax_amount;
    $data['net_amount'] = (int) $net_amount;
    $data['orderFrom'] = 'cleartyefiling';
    $data['orderFromName'] = 'Consultancy Payment';
     $data['serviceUrl'] = $request->serviceUrl;
    $data['createdOn'] = now()->timestamp;

    // Insert into database
    try {
        DB::table('tbl_order')->insert($data);


         
                    

// return response()->json([($orderD)]);die;
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Order created successfully!',
            'orderId' => $orderId,
            'tax_details' => [
                'cgstAmt' => $cgstAmt,
                'sgstAmt' => $sgstAmt,
                'tax_amount' => $tax_amount,
                'net_amount' => (int) $net_amount,
            ],
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 500,
            'success' => false,
            'message' => 'Failed to create order.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

function services_all_package(Request $request){
    try {
    $results = DB::table('tbl_service_v2')
    ->join('tbl_category_v2', 'tbl_service_v2.categoryIds', '=', 'tbl_category_v2.uniquid')
    ->where('tbl_category_v2.isTrashed', 0)
    ->where('tbl_service_v2.isTrashed', 0)
    ->whereNotIn('tbl_category_v2.alias', ['efiling-trending', 'monsoon-offer'])
    ->select(
        'tbl_service_v2.uniqueId',
        'tbl_service_v2.serviceName',
        'tbl_service_v2.serviceHeading',
        'tbl_service_v2.serviceAlias',
        'tbl_service_v2.servicePrice',
        'tbl_service_v2.priceDiscount',
        'tbl_service_v2.serviceSynopsis',
        'tbl_category_v2.alias',
          'tbl_category_v2.uniquid as category_id'
       
    )
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Services fetched successfully.',
            'data' => $results
        ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }

}
function premium_package(Request $request){
    try {
    $results = DB::table('tbl_service_v2')
    ->join('tbl_category_v2', 'tbl_service_v2.categoryIds', '=', 'tbl_category_v2.uniquid')
    ->where('tbl_category_v2.isTrashed', 0)
    ->where('tbl_service_v2.isTrashed', 0)
    ->where('tbl_service_v2.categoryIds', 8)
    // ->whereNotIn('tbl_category_v2.alias', ['efiling-trending', 'monsoon-offer'])
    ->select(
        'tbl_service_v2.uniqueId',
        'tbl_service_v2.serviceName',
        'tbl_service_v2.serviceHeading',
        'tbl_service_v2.serviceAlias',
        'tbl_service_v2.servicePrice',
        'tbl_service_v2.priceDiscount',
        'tbl_service_v2.serviceSynopsis',
        'tbl_category_v2.alias',
          'tbl_category_v2.uniquid as category_id'
       
    )
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Services fetched successfully.',
            'data' => $results
        ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }

}
function top_popular_package(){
    try {
        $results = DB::table('tbl_service_v2')
        ->join('tbl_category_v2', 'tbl_service_v2.categoryIds', '=', 'tbl_category_v2.uniquid')
        ->where('tbl_category_v2.isTrashed', 0)
        ->where('tbl_service_v2.isTrashed', 0)
        ->whereIn('tbl_service_v2.uniqueId', ['31', '34','36','38','60','49','50'])
        ->select(
            'tbl_service_v2.uniqueId',
            'tbl_service_v2.serviceName',
            'tbl_service_v2.serviceHeading',
            'tbl_service_v2.serviceAlias',
            'tbl_service_v2.servicePrice',
            'tbl_service_v2.priceDiscount',
            'tbl_service_v2.serviceSynopsis',
          DB::raw('(tbl_service_v2.servicePrice - (tbl_service_v2.servicePrice * tbl_service_v2.priceDiscount / 100)) as discount_price'),
            'tbl_category_v2.alias',
              'tbl_category_v2.uniquid as category_id'
           
        )
                ->get();
    
            return response()->json([
                'status' => true,
                'message' => 'Services fetched successfully.',
                'data' => $results
            ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong.',
                    'error' => $e->getMessage()
                ], 500);
            }
}
public function email_check_verify(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email:rfc,dns,strict|max:100'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid email address.',
            'errors' => $validator->errors(),
        ], 422);
    }

    $email = $request->input('email');
    $domain = substr(strrchr($email, "@"), 1);

    // Check DNS record for MX (mail exchange)
    if (!checkdnsrr($domain, 'MX')) {
        return response()->json([
            'status' => false,
            'message' => 'Email domain does not exist.',
        ], 422);
    }

    return response()->json([
        'status' => true,
        'message' => 'Email is valid.',
        'email' => $email,
    ], 200);
}



    
}
