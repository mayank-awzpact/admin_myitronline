<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\V2\API\Order;
use App\Models\V2\API\Payment;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendInvoiceEmail;
use App\Jobs\SendOrderConfirmationEmail;

class OrderPayment extends Controller
{
    protected $key_id;
    protected $key_secret;
    protected $callBackUrl = '/V2/capture/razorpay-order';
    protected $api;
    protected $payment;
    protected $order;
    protected $paymentSettingController;

    public function __construct(Payment $payment, Order $order, PaymentSettingController $paymentSettingController)
    {
        $this->payment = $payment;
        $this->order = $order;
        $this->paymentSettingController = $paymentSettingController;
    }


    private function initializeApi($getawayName, $key_mode)
    {
        $settingsResponse = $this->paymentSettingController->getPaymentSettings($getawayName, $key_mode);
        $settingsData = json_decode($settingsResponse->getContent(), true);

        if ($settingsData['status'] == 200) {
            $gatewayKey = $settingsData['data'];
            $this->key_id = $gatewayKey['key_id'];
            $this->key_secret = $gatewayKey['key_secret'];
            $this->api = new Api($this->key_id, $this->key_secret);
        } else {
            throw new \Exception('Unable to initialize payment gateway. Settings not found.');
        }
    }

    public function createOrderPayment(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'orderId' => 'required|string|max:100',
            'getawayName' => 'required|string',
            'key_mode' => 'required|integer|in:1,2',
            'userId' => 'nullable|integer',
        ]);
        

        // Initialize Razorpay API
        try {
            $this->initializeApi($validatedData['getawayName'], $validatedData['key_mode']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 0,
            ], 500);
        }

        // Retrieve the order using the validated orderId
        $order = Order::where('orderId', $validatedData['orderId'])->first();

        // Check if the order was found
        if (!$order) {
            return response()->json([
                'message' => 'Unable to retrieve order details.',
                'status' => 0,
            ], 404);
        }

        // Calculate service amount, user details, and receipt
        $serviceAmount = round($order->net_amount) * 100;
        $userName = $order->fname . ' ' . $order->lname;
        $userEmail = $order->email;
        $userContact = $order->mobile;
        $receiptId = '000' . $validatedData['orderId'];

        // Create order data array for Razorpay
        $orderData = [
            'amount' => $serviceAmount,
            'currency' => 'INR',
            'receipt' => $receiptId
        ];

        // Create order using Razorpay API
        $response = $this->api->order->create($orderData);

        if ($response) {
            $data = $response->toArray();
            $responseData = [
                'keyId' => $this->key_id,
                'id' => $data['id'],
                'amount' => $data['amount'],
                'amount_paid' => $data['amount_paid'],
                'currency' => $data['currency'],
                'invoiceNo' => $receiptId,
                'orderId' => $validatedData['orderId'],
                'created_at' => $data['created_at'],
                'userName' => $userName,
                'userEmail' => $userEmail,
                'userContact' => $userContact,
                'website' => 'https://myitronline.com',
                'companyName' => 'MYITRONLINE',
                'callbackUrl' => $this->callBackUrl,
            ];

            return response()->json([
                'status' => '1',
                'response' => 'SUCCESS',
                'data' => $responseData,
                'rs_reason' => 'GREEN'
            ]);
        } else {
            return response()->json([
                'status' => '0',
                'response' => 'FAILED',
                'rs_reason' => 'RED'
            ]);
        }
    }

    public function paymentCapture(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'razorpay_payment_id' => 'required|filled',
            'orderId' => 'required|string|max:100',
        ]);
        // print_r($request->input('razorpay_payment_id'));
        // echo 'hi';die;
        $razorpayKeyId = 'rzp_live_qnGTivBsqrmopX';
            $razorpayKeySecret = 'K1pVua1IJlA2McisTpt6SVev';
            $api = new Api($razorpayKeyId, $razorpayKeySecret);
            $paymentId = $request->input('razorpay_payment_id');
        // try {
          
            // Fetch payment details from Razorpay using the payment ID
            // $response = $api->payment->fetch($request->input('razorpay_payment_id'));
            $response = $api->payment->fetch($paymentId);
            // print_r($response);die;
            // Check if the response was successfully fetched
            if ($response) {
                $data = $response->toArray();

                // Check if the payment status is 'captured'
                if ($data['status'] == 'authorized') {
                    // Process the successful payment
                   
                    $this->processSuccessfulPayment($request, $data);

                    
                    // Return success response
                    return response()->json(['status' => '1', 'response' => 'SUCCESS', 'data' => $data, 'rs_reason' => 'GREEN']);
                } else {
                    // Return failure response if payment status is not 'captured'
                    return response()->json(['status' => '0', 'response' => 'FAILED', 'rs_reason' => 'RED']);
                }
            } else {
                // Return error response if the API response is not valid
                return response()->json(['error' => 'Razorpay API initialization failed.'], 500);
            }
        // } catch (\Exception $e) {
        //     // Return error response if there is an exception
        //     return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        // }
    }

    
private function processSuccessfulPayment($request, $data)
{
    $orderStatus = ($data['status'] == 'authorized') ? 'PAYMENT_SUCCESS' : 'PAYMENT_FAILED';
    $orderId = $request->input('orderId');
    $invoiceNo = '000' . $orderId;

    $paymentData = [
        'paymentStatus' => '1',
        'orderId' => $orderId,
        'gatewayName' => 'razorpay',
        'currency' => $data['currency'],
        'state' => $data['status'],
        'responseCode' => $data['status'],
        'bankTransactionId' => $data['order_id'],
        'paymentOrderId' => $data['order_id'],
        'transtionId' => $data['id'],
        'transactionAmount' => $data['amount'] / 100,
        'transtionStatus' => '1',
        'transtionDate' => $data['created_at'],
    ];

    $orderData = [
        'paymentStatus' => '1',
        'invoiceNo' => $invoiceNo,
        'paymentGateway' => 'razorpay',
    ];

    try {
        DB::table('tbl_order')->where('orderId', $orderId)->update($orderData);
        DB::table('tbl_payment')->where('paymentOrderId', $data['order_id'])->update($paymentData);

        if ($orderStatus == 'PAYMENT_SUCCESS') {
            $orderD = DB::table('tbl_order')->where('orderId', $orderId)->get();

            if (count($orderD) > 0) {
                $fileName = 'invoice_' . $orderId . '.pdf';
                $domain_url = $request->getSchemeAndHttpHost();
                $invoicePath = $domain_url . '/public/invoice/' . $fileName;

                if ($orderD[0]->email_send == 0) {
                    SendInvoiceEmail::dispatch($orderD[0], $invoicePath);

                    DB::table('tbl_order')->where('orderId', $orderId)->update([
                        'email_send' => 1,
                        'invoicePath' => $invoicePath,
                        'invoiceNo' => $fileName,
                    ]);
                }

                if (
                    $orderD[0]->orderFrom == 'application-form16' || 
                    $orderD[0]->autoMail == 0
                ) {
                    $ccEmails = ['mishramayank7007@gmail.com'];
                    $bccEmails = ['account@myitronline.com','mayankm738@gmail.com','vinayjaiswal@myitronline.com'];

                    SendOrderConfirmationEmail::dispatch($ccEmails, $bccEmails, $orderId);
                }
            }
        }

        return response()->json(['message' => 'Payment successful', 'status' => 1]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
}

}
