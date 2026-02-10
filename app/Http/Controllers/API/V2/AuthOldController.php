<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\V2\API\UserModal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Notifications\ResetPasswordNotification;




class AuthOldController extends Controller
{
    /**
     * User signup
     */
    public function signup(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'fName' => 'required|string|max:255',
        'lName' => 'required|string|max:255',
        'email' => 'required|email:rfc,dns',
        'password' => 'required|min:6',
        'browser' => 'nullable|string|max:100',
        'browserVersion' => 'nullable|string|max:100',
        'os' => 'nullable|string|max:100',
        'device' => 'nullable|string|max:100',
        'ip' => 'nullable|string|max:100',
        'domain_source' => 'required|string|max:100',
        'domain' => 'required|string|max:100',
        'mobile' => 'required|digits:10|numeric',
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => 400, 'errors' => $validator->errors()], 400);
    }

    $existingUser = UserModal::where('email', $request->email)->first();

    if ($existingUser) {
        if ($existingUser->active == 1) {
            return response()->json([
                'status' => 409,
                'message' => 'User already registered and active. Please login.'
            ]);
        } else {
            // ✅ Update user details for inactive user
            $existingUser->fName = $request->fName;
            $existingUser->lName = $request->lName;
            $existingUser->password = Hash::make($request->password);
            $existingUser->browser = $request->browser;
            $existingUser->browserVersion = $request->browserVersion;
            $existingUser->os = $request->os;
            $existingUser->device = $request->device;
            $existingUser->ip = $request->ip;
            $existingUser->domain_source = $request->domain_source;
            $existingUser->domain = $request->domain;
            $existingUser->mobile = $request->mobile;
            $existingUser->updatedOn = now();
            $existingUser->login_at = now();
            $existingUser->save();

            $userId = $existingUser->id;
        }
    } else {
        // ✅ Create new user
        $user = new UserModal();
        $user->fName = $request->fName;
        $user->lName = $request->lName;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->browser = $request->browser;
        $user->browserVersion = $request->browserVersion;
        $user->os = $request->os;
        $user->device = $request->device;
        $user->ip = $request->ip;
        $user->domain_source = $request->domain_source;
        $user->domain = $request->domain;
        $user->mobile = $request->mobile;
        $user->active = 0;
        $user->createdOn = now();
        $user->updatedOn = now();
        $user->login_at = now();
        $user->save();

        $userId = $user->id;
    }

    // ✅ Send/Resend OTP
    $otp = rand(1000, 9999);
      $token = Str::random(30);
        $email = $request->email;
            

                $data["email"]= $email;
                $data["otp"]= $otp;
                $data["title"]='Register successful for MYITRONLINE Admin and OTP is ' . $otp;
                $data["subject"]='Thank you for choosing Service on MyITROnline';
                $messages = 'the otp is '.$otp;
               $mail_sent = Mail::send('mailer.otp_tpl', $data, function ($message) use ($data, $email) {
                    $message->to($data["email"], $data["email"])
                    ->subject($data["title"]);
                });


    DB::table('tbl_otp')->insert(
      
        [
            'mobile' => $request->mobile,
            'email' => $request->email,
            'countryCode' => $request->countryCode ?? '+91',
            'otp' => $otp,
            'accessToken' => $token,
            'createdOn'    => now()->timestamp, // <- store as INT
    'validUpto'    => now()->addMinutes(5)->timestamp, // <- store as INT
            'otpVerified' => 0,
        ]
    );

    // Log::info("OTP for user {$request->email} is $otp");

    return response()->json([
        'status' => 201,
        'message' => 'OTP sent. Please verify to complete registration.',
        'email' => $request->email,
        'accessToken'   => $token,

    ]);
}
public function verifyOtp(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'otp' => 'required|digits:4',
        'accessToken' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => 400, 'errors' => $validator->errors()], 400);
    }

    // ✅ Check user first
    $user = UserModal::where('email', $request->email)->first();

    if (!$user) {
        return response()->json([
            'status' => 404,
            'message' => 'User not found.',
        ]);
    }

    // ✅ Only allow if user is INACTIVE
    if ($user->active == 1) {
        return response()->json([
            'status' => 409,
            'message' => 'User already active. Please login.',
        ]);
    }

    // ✅ Proceed with OTP check
    $otpRecord = DB::table('tbl_otp')
        ->where('email', $request->email)
        ->where('otp', $request->otp)
        ->where('accessToken', $request->accessToken)
        ->where('otpVerified', 0)
       ->where('validUpto', '>=', now()->timestamp) 
        ->first();

    if (!$otpRecord) {
        return response()->json([
            'status' => 401,
            'message' => 'Invalid or expired OTP or access token.',
        ]);
    }

    // ✅ Mark OTP as verified
    DB::table('tbl_otp')
        ->where('uniqueId', $otpRecord->uniqueId)
        ->update([
            'otpVerified' => 1,
        ]);

    // ✅ Activate the user
    $user->active = 1;
    $user->save();

    return response()->json([
        'status' => 200,
        'message' => 'OTP verified successfully. User activated.',
    ]);
}

public function resendOtp(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => 400, 'errors' => $validator->errors()], 400);
    }

    $user = UserModal::where('email', $request->email)->first();

    if (!$user) {
        return response()->json([
            'status' => 404,
            'message' => 'User not found.',
        ]);
    }

    // ✅ Allow only if user is inactive
    if ($user->active == 1) {
        return response()->json([
            'status' => 409,
            'message' => 'User already active. Please login.',
        ]);
    }

    // ✅ Generate new OTP and token
    $otp = rand(1000, 9999);
    $token = Str::random(60);

    DB::table('tbl_otp')->insert([
        'email' => $request->email,
        'otp' => $otp,
        'accessToken' => $token,
        'otpVerified' => 0,
        'createdOn' => now(),
        'validUpto' => now()->addMinutes(10),
    ]);

    // ✅ Send email
    $data = [
        "email" => $request->email,
        "otp" => $otp,
        "title" => "Your OTP is $otp",
        "subject" => "Resend OTP - MyITRONLINE",
    ];

    Mail::send('mailer.otp_tpl', $data, function ($message) use ($data) {
        $message->to($data["email"])->subject($data["title"]);
    });

    return response()->json([
        'status' => 200,
        'message' => 'OTP resent successfully.',
        'accessToken' => $token,
    ]);
}



    public function signup_bkp(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'fName' => 'required|string|max:255',
            'lName' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:tbl_users_data,email',
            'password' => 'required|min:6',
            'browser' => 'nullable|string|max:100',
            'browserVersion' => 'nullable|string|max:100',
            'os' => 'nullable|string|max:100',
            'device' => 'nullable|string|max:100',
            'ip' => 'nullable|string|max:100',
            'domain_source' => 'required|string|max:100',
            'domain' => 'required|string|max:100',
          'mobile' => 'required|digits:10|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()], 400);
        }

        
        // Create new user
        $user = new UserModal();
        $user->fName = $request->fName;
        $user->lName = $request->lName;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->createdOn = Carbon::now()->format('Y-m-d H:i:s'); // Set createdOn field with correct format
        $user->updatedOn = Carbon::now()->format('Y-m-d H:i:s'); // Set updatedOn field with correct format

        $user->browser = $request->browser;
        $user->browserVersion = $request->browserVersion;
        $user->os = $request->os;
        $user->device = $request->device;
        $user->ip = $request->ip;
        $user->domain_source = $request->domain_source;
        $user->domain = $request->domain;
        $user->mobile = $request->mobile;
        $user->active = 0;

        $user->login_at = Carbon::now();

        $user->save();

        return response()->json(['status' => 201, 'message' => 'User registered successfully', 'id' => $user->id]);
    }

    /**
     * User login
     */

    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email:rfc,dns'],
            'password' => 'required|min:6',
            'browser' => 'nullable|string|max:100',
            'browserVersion' => 'nullable|string|max:100',
            'os' => 'nullable|string|max:100',
            'device' => 'nullable|string|max:100',
            'ip' => 'nullable|string|max:100',
            'domain_source' => 'required|string|max:100',
            'domain' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()], 400);
        }

        // Check if the user exists
        $user = UserModal::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 404, 'message' => 'User not registered'], 404);
        }
        if ($user->active == 0) {
            return response()->json(['status' => 403, 'message' => 'User not activated please registere again.'], 403);
        }
        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['status' => 401, 'message' => 'Invalid credentials'], 401);
        }

        // Update the login_at field
        $user->browser = $request->browser;
        $user->browserVersion = $request->browserVersion;
        $user->os = $request->os;
        $user->device = $request->device;
        $user->ip = $request->ip;
        $user->domain_source = $request->domain_source;
        $user->domain = $request->domain;

        $user->login_at = Carbon::now();
        $user->save();

        // Generate a token or session for the user (optional)
        // $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['status' => 200, 'message' => 'User login successful', 'id' => $user->id,'email'=>$user->email,'fname' => $user->fName,'lName'=>$user->lName,'mobile'=>$user->mobile]);
    }

    /**
     * User Forget Password
     */

    public function forgetPassword(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
            'callback_url' => 'nullable|string|max:150',
            'browser' => 'nullable|string|max:100',
            'browserVersion' => 'nullable|string|max:100',
            'os' => 'nullable|string|max:100',
            'device' => 'nullable|string|max:100',
            'ip' => 'nullable|string|max:100',
            'domain_source' => 'required|string|max:100',
            'domain' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()], 400);
        }

        // Check if the user exists
        $user = UserModal::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 404, 'message' => 'User not found'], 404);
        }

        // Generate a password reset token
        $token = Str::random(60);

        // Store the token in the database
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        // Generate the password reset URL
        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // Send the password reset email
        $user->notify(new ResetPasswordNotification($token, $request->email, $request->callback_url, $request->domain));

        return response()->json(['status' => 200, 'message' => 'Password reset email sent']);
    }
    /**
     * User Reset Password
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()], 400);
        }

        $passwordReset = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset || !Hash::check($request->token, $passwordReset->token)) {
            return response()->json(['status' => 400, 'message' => 'Invalid token'], 400);
        }

        $user = UserModal::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 404, 'message' => 'User not found'], 404);
        }
        $user->password = Hash::make($request->password);
        $user->isPasswordChange = '1';
        $user->PasswordChangeTime = Carbon::now();
        $user->updatedOn = Carbon::now();
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return response()->json(['status' => 200, 'message' => 'Password reset successfully']);
    }
    /**
     * User Change Password
     */
    public function changePassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id' => 'required|integer',
        'email' => 'required|email:rfc,dns',
        'password' => 'required|min:6', // Confirmed field ensures 'password_confirmation' matches 'password'
        'old_password' => 'required|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => 400, 'errors' => $validator->errors()], 400);
    }

    // Find the user by ID and email
    $user = UserModal::where('id', $request->id)
        ->where('email', $request->email)
        ->first();

    if (!$user) {
        return response()->json(['status' => 404, 'message' => 'User not found'], 404);
    }

    // Verify the old password
    if (!Hash::check($request->old_password, $user->password)) {
        return response()->json(['status' => 401, 'message' => 'Old password is incorrect'], 401);
    }

    // Update password and other details
    $user->password = Hash::make($request->password);
    $user->isPasswordChange = '1';
    $user->PasswordChangeTime = Carbon::now();
    $user->updatedOn = Carbon::now();
    $user->save();

    return response()->json(['status' => 200, 'message' => 'Password reset successfully']);
}

    /**
     * User User logout
     */
    public function userLogout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
            'browser' => 'nullable|string|max:100',
            'browserVersion' => 'nullable|string|max:100',
            'os' => 'nullable|string|max:100',
            'device' => 'nullable|string|max:100',
            'ip' => 'nullable|string|max:100',
            'domain_source' => 'required|string|max:100',
            'domain' => 'required|string|max:100',

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()], 400);
        }

        // Check if the user exists
        $user = UserModal::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 404, 'message' => 'User not found'], 404);
        }

        $user->browser = $request->browser;
        $user->browserVersion = $request->browserVersion;
        $user->os = $request->os;
        $user->device = $request->device;
        $user->ip = $request->ip;
        $user->domain_source = $request->domain_source;
        $user->domain = $request->domain;
        $user->logout_at = Carbon::now();

        $user->save();

        return response()->json(['status' => 200, 'message' => 'User Logout successfully']);
    }
    /**
     * User Update Profile
     */
    public function updateProfile(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1',
            'email' => 'required|email:rfc,dns',
            'mobile' => 'required|string|max:10',
            'birthdate' => 'required|date',
            'fName' => 'required|string|max:255',
            'lName' => 'required|string|max:255',
            'gender' => 'required|integer',
            'aadhaar' => 'nullable|string|max:100',
            'pan' => 'nullable|string|max:100',
            'areaLocality' => 'required|string|max:100',
            'Pincode' => 'required|string|max:6',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()], 400);
        }

        // Check if the user exists
        $user = UserModal::where('id', $request->id)->where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 404, 'message' => 'User not found'], 404);
        }

        // Update user profile information
        $user->mobile = $request->mobile;
        $user->birthdate = $request->birthdate;
        $user->fName = $request->fName;
        $user->lName = $request->lName;
        $user->gender = $request->gender;
        $user->aadhaar = $request->aadhaar;
        $user->pan = $request->pan;
        $user->areaLocality = $request->areaLocality;
        $user->Pincode = $request->Pincode;
        $user->state = $request->state;
        $user->city = $request->city;

        $user->save();

        return response()->json(['status' => 200, 'message' => 'Profile updated successfully']);
    }

    /**
     * User get Profile
     */

    public function getUserProfile(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1',
            'email' => 'required|email:rfc,dns',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()], 400);
        }

        // Check if the user exists
        $user = UserModal::where('id', $request->id)->where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 404, 'message' => 'User not found'], 404);
        }

        // Retrieve user profile information
        $userProfile = [
            'id' => $user->id,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'birthdate' => $user->birthdate,
            'fName' => $user->fName,
            'lName' => $user->lName,
            'gender' => $user->gender,
            'aadhaar' => $user->aadhaar,
            'pan' => $user->pan,
            'areaLocality' => $user->areaLocality,
            'Pincode' => $user->Pincode,
            'state'  => $user->state,
            'city'  => $user->city,
            'login_at' => $user->login_at,
            'logout_at' => $user->logout_at,
        ];

        return response()->json(['status' => 200, 'message' => 'User profile retrieved successfully', 'data' => $userProfile]);
    }
    function softlogin(Request $request)
{
    // Validate the incoming request
    $validatedData = $request->validate([
        'fName' => 'required|string|max:255',
        'lName' => 'required|string|max:255',
        'email' => 'required|email:rfc,dns|max:255',
        'phone' => 'required|string|max:15',
    ], [
        'fName.required' => 'First Name is required.',
        'lName.required' => 'Last Name is required.',
        'email.required' => 'Email is required.',
        'email.email' => 'Please provide a valid email address.',
        'phone.required' => 'Phone number is required.',
    ]);

    // Extract user details from the request
    $fName = $request->input('fName');
    $lName = $request->input('lName');
    $email = $request->input('email');
    $phone = $request->input('phone');

    // Check if the email exists in the database
    $user = DB::table('tbl_users_data')->where('email', $email)->first();

    if ($user) {
        // If the email exists, return a success message
        return response()->json([
          'status' => 200, 
            'message' => 'User already exists. Login successful.',
            'id' => $user->id,
            'email' => $email
        ], 200);
    } else {
        // If the email doesn't exist, create a new entry
        $randomPassword = Str::random(10); // Generate a random password
        $hashedPassword = Hash::make($randomPassword); // Hash the password

        // Insert the new user into the database
     $insertedId =   DB::table('tbl_users_data')->insertGetId([
            'fName' => $fName,
            'lName' => $lName,
            'email' => $email,
            'mobile' => $phone,
            'password' => $hashedPassword,
            'createdOn' => now(),
            'updatedOn' => now(),
        ]);

        // Return a success message
        return response()->json([
           'status' => 200, 
            'message' => 'User registered successfully.',
            'id' => $insertedId,
            'email' => $email
        ], 200);
    }
}
}
