<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\AuthController;

use App\Http\Controllers\API\V2\EfilingController;
use App\Http\Controllers\API\V2\TaxToolsController;
use App\Http\Controllers\API\V2\OrderController;
use App\Http\Controllers\API\V2\OrderPayment;
use App\Http\Controllers\API\V2\PaymentSettingController;
use App\Http\Controllers\API\V2\AuthOldController;
use App\Http\Controllers\API\V2\BankController;
use App\Http\Controllers\API\V2\GstController;
use App\Http\Controllers\API\V2\PinCodeController;
use App\Http\Controllers\API\V2\ServiceController;
use App\Http\Controllers\API\MyitrWorks\HRMController;

// Route::get('/test-api', function () {
//     return response()->json(['message' => 'OKkk'], 200);
// });
Route::middleware('check.token')->get('/v1/test-api', function () {
    return response()->json(['message' => 'Token is valid']);
});




Route::get('/posts', [ApiController::class, 'bigpost']);
Route::get('/mini-posts', [ApiController::class, 'mini_post']);     
Route::get('/categories', [ApiController::class, 'getCategories']);
Route::get('/trending-highlight', [ApiController::class, 'trending_highlight']); 
Route::get('/trending_highlight_posts', [ApiController::class, 'trending_highlight_posts']);
Route::get('/posts/{id}', [ApiController::class, 'getPosts']);
Route::get('/getGst', [ApiController::class, 'getGst']);



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

Route::middleware('check.token')->group(function () {

Route::post('/v1/signup', [AuthOldController::class, 'signup'])->name('v2.signup');
Route::post('/v1/login', [AuthOldController::class, 'login'])->name('v2.login');
Route::post('/v1/verify-otp', [AuthOldController::class, 'verifyOtp']);
Route::post('/v1/resend-otp', [AuthOldController::class, 'resendOtp']);
Route::post('/v1/forgetPassword', [AuthOldController::class, 'forgetPassword'])->name('v2.forgetPassword');
Route::post('/v1/reset-password', [AuthOldController::class, 'resetPassword'])->name('v2.reset-password');
Route::post('/v1/change-password', [AuthOldController::class, 'changePassword'])->name('v2.change-password');
Route::post('/v1/update-profile', [AuthOldController::class, 'updateProfile'])->name('v2.update-profile');
Route::get('/v1/get-profile', [AuthOldController::class, 'getUserProfile'])->name('v2.get-profile');
Route::post('/v1/user-logout', [AuthOldController::class, 'userLogout'])->name('v2.user-logout');


Route::post('/v1/create-rent-receipt', [TaxToolsController::class, 'createRentReceipt'])->name('v2.create-rent-receipt');
Route::post('/v1/create-from12bb', [TaxToolsController::class, 'createFrom12bb'])->name('v2.create-from12bb');
Route::post('/v1/validate-pincode', [EfilingController::class, 'ValidatePincode'])->name('v2.validate.pincode');
Route::post('/v1/efile-income-tax-return', [EfilingController::class, 'efileIncomeTaxReturn'])->name('v2.efile.tax.return');
Route::get('/v1/order_summary/{orderId}', [OrderController::class, 'getOrderDetails'])->name('v2.order_summary');

Route::post('/v1/ServiceCreateOrder', [ServiceController::class, 'ServiceCreateOrder'])->name('v2.ServiceCreateOrder');
Route::post('/v1/create_payment', [OrderPayment::class, 'createOrderPayment'])->name('v2.create_payment');
Route::post('/v1/capture/razorpay-order', [OrderPayment::class, 'paymentCapture'])->name('v2.capture_payment');

Route::get('/v1/get-order', [OrderController::class, 'getUserOrder'])->name('v2.get-order');

// Route::get('/v1/payment-settings/{getawayName}/{key_mode}', [PaymentSettingController::class, 'getPaymentSettings'])->name('v2.payment_settings');

Route::get('/v1/get-ifsc-code-search', [BankController::class, 'ifscSearch'])->name('v2.get-ifsc-search');
Route::get('/v1/gst-number-search', [GstController::class, 'gstSearch'])->name('v2.gst-number-search');

//Pin Code Service 
Route::post('/v1/validate-pincode', [EfilingController::class, 'ValidatePincode'])->name('v2.validate.pincode');
Route::get('/v1/find-pincode', [PinCodeController::class, 'index'])->name('v2.find.pincode');

//Service 
Route::get('/v1/services', [ServiceController::class, 'index']);
Route::get('/v1/services/{id}', [ServiceController::class, 'show']);
// Route::get('/v1/service/eca', [ServiceController::class, 'eca_package_list']);
Route::get('/v1/service/eca', [ServiceController::class, 'eca_package_list']);
Route::post('/v1/contact_us', [ServiceController::class, 'contact_us']);
Route::post('/v1/jobApply', [ServiceController::class, 'job_apply']);
Route::get('/v1/testimonials', [ServiceController::class, 'getTestimonials']);
Route::post('/v1/callbackrequest', [ServiceController::class, 'CallBackRequest']);
Route::post('/v1/softlogin', [AuthOldController::class, 'softlogin']);
Route::post('/v1/payConsultingFee', [ServiceController::class, 'payConsultingFee']);
Route::get('/v1/services-all-package', [ServiceController::class, 'services_all_package']);
Route::get('/v1/premium-package', [ServiceController::class, 'premium_package']);
Route::get('/v1/top-popular-package', [ServiceController::class, 'top_popular_package']);
Route::get('/v1/email-check-verify', [ServiceController::class, 'email_check_verify']);





















});






