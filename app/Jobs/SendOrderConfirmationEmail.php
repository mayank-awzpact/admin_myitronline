<?php

namespace App\Jobs;

use App\Mail\OrderConfirmationMail;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;



class SendOrderConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ccEmails;
    protected $bccEmails;
    protected $orderId;



    public function __construct($ccEmails = [], $bccEmails = [], $orderId)
    {
        $this->ccEmails = $ccEmails;
        $this->bccEmails = $bccEmails;
        $this->orderId = $orderId;
    }


    public function handle()
    {
        try {
            // Query the orders with orderId
            $orders = DB::table('tbl_order')
                ->where('orderId', $this->orderId)
                ->get();

            foreach ($orders as $order) {
                // Get the form data from tbl_form16
                if (is_null($order->form16_id)) {
                    continue;
                }
                // $formData = DB::table('tbl_form16')
                //     ->where('uniqueId', $order->form16_id)
                //     ->first();

                $filePaths = [];

                // Check if form16_id is a string or number like ref_1717420461
                if (preg_match('/^ref_\d+$/', $order->form16_id)) {
                    // Fetch pdfFilePath from tbl_upload_form16
                    $uploadFormData = DB::table('tbl_upload_form16')
                        ->where('refrence_id', $order->form16_id)
                        ->first();

                    if ($uploadFormData) {
                        $path = $uploadFormData->pdfFilePath;
                        $cleanPath = str_replace(['\\', 'https://myitronline.com/public/uploads/'], '', $path);
                        $filePath = public_path('uploads/' . $cleanPath);

                        // Ensure the file exists before adding to the list
                        if (!file_exists($filePath)) {
                            throw new Exception('Form16 PDF not found: ' . $filePath);
                        }

                        $filePaths[] = $filePath;
                    } else {
                        throw new Exception('No entry found in tbl_upload_form16 for form16_id: ' . $order->form16_id);
                    }
                } else {
                    // Handle the standard form16 entries from tbl_form16
                    $formData = DB::table('tbl_form16')
                    ->where('uniqueId', $order->form16_id)
                    ->first();

                    if ($formData) {
                        // Decode the JSON array of file paths
                        $paths = json_decode($formData->pdfFilePath, true);

                        if (json_last_error() !== JSON_ERROR_NONE) {
                            throw new Exception('Invalid JSON in pdfFilePath: ' . json_last_error_msg());
                        }

                        foreach ($paths as $path) {
                            $cleanPath = str_replace(['\\', 'https://myitronline.com/storage/'], '', $path);
                            $filePath = storage_path('app/public/' . $cleanPath);

                            // Ensure the file exists before adding to the list
                            if (!file_exists($filePath)) {
                                throw new Exception('Form16 PDF not found: ' . $filePath);
                            }

                            $filePaths[] = $filePath;
                        }
                    }
                }

                // Construct full file path for the Invoice PDF
                $invoicePath = public_path('invoice/' . 'invoice_' . $order->orderId . '.pdf');

                // Ensure the invoice file exists before sending the email
                if (!file_exists($invoicePath)) {
                    throw new Exception('Invoice PDF not found: ' . $invoicePath);
                }

                // Prepare data to be sent in the email
                $orderData = [
                    'order_id' => $order->orderId,
                    'first_name' => $order->fname,
                    'last_name' => $order->lname,
                    'email' => $order->email,
                    'father_name' => $formData ? $formData->father_name : '',
                    'dob' => $formData ? $formData->dob : '',
                    'pan_number' => $formData ? $formData->pan_number : '',
                    'full_address' => $formData ? $formData->full_address : '',
                    'account_number' => $formData ? $formData->account_number : '',
                    'ifsc_code' => $formData ? $formData->ifsc_code : '',
                    'bank_name' => $formData ? $formData->bank_name : '',
                    'account_type' => $formData ? $formData->account_type : '',
                    'pdfPassword' => $formData ? $formData->pdfPassword : '',
                    'UploadFilePath' => $filePaths,
                    'invoicePath' => $invoicePath,
                ];

                // Send email using the Mailable
                $mail = Mail::to($order->email);

                if (!empty($this->ccEmails)) {
                    $mail->cc($this->ccEmails);
                }

                if (!empty($this->bccEmails)) {
                    $mail->bcc($this->bccEmails);
                }

                // Send the email using the OrderConfirmationMail Mailable class
                $mail->send(new OrderConfirmationMail($orderData));

                // Update the order to mark the email as sent
                DB::table('tbl_order')
                    ->where('orderId', $order->orderId)
                    ->update(['autoMail' => 1]);
            }
        } catch (Exception $e) {
            // Log the error
            Log::error('Error in SendOrderConfirmationEmail job: ' . $e->getMessage());

            // Optionally, you can re-throw the exception to let Laravel handle it
            // throw $e;
        }
    }



    public function failed(\Exception $exception)
    {
        Log::error('SendOrderConfirmationEmail Job Failed', [
            'exception' => $exception->getMessage(),
        ]);
    }
}
