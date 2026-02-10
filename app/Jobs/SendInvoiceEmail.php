<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use PDF;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class SendInvoiceEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $invoicePath;

    public function __construct($order, $invoicePath)
    {
        $this->order = $order;
        $this->invoicePath = $invoicePath;
    }

    public function handle()
    {
        try {
            $data = [
                'userDetail' => $this->order,
                'invoicePath' => $this->invoicePath,
                'title' => 'Payment successful for Myitronline',
                'subject' => 'Thank you for Choosing Service on Myitronline',
            ];

            $data['invoiceNo'] = $data['userDetail']->invoiceNo;
            $orderId = $data['userDetail']->orderId;

            // Generate invoice PDF
            $pdf = PDF::loadView('mailer.invoice_tpl', $data);
            $path = public_path('invoice');
            $fileName = 'invoice_' . $orderId . '.pdf';
            $pdf->save($path . '/' . $fileName);

            // Attempt to decode additional files
            $additionalFiles = [];
            $temporaryFiles = [];
            try {
                if (!empty($data['userDetail']->invoicePath)) {
                    $additionalFiles = json_decode($data['userDetail']->invoicePath, true);
                }
            } catch (\Exception $ex) {
                Log::error('Error decoding invoicePath: ' . $ex->getMessage());
            }
// Log::info('Sending email with data:', $data);

            // Send email
            try {
            Mail::send('mailer.email_tpl', $data, function ($message) use ($data, $path, $fileName, $additionalFiles, &$temporaryFiles) {
                $message->to($data["userDetail"]->email)
                        ->subject($data["title"])
                        ->attach($path . '/' . $fileName);

                // Attach additional files from URLs
                if (is_array($additionalFiles) && !empty($additionalFiles)) {
                    foreach ($additionalFiles as $fileUrl) {
                        $response = Http::get($fileUrl);

                        if ($response->ok()) {
                            $temporaryPath = tempnam(sys_get_temp_dir(), 'attachment');
                            File::put($temporaryPath, $response->body());

                            $message->attach($temporaryPath, [
                                'as' => basename($fileUrl),
                                'mime' => 'application/pdf',
                            ]);

                            $temporaryFiles[] = $temporaryPath;
                        } else {
                            Log::error("Failed to download attachment: $fileUrl");
                        }
                    }
                }
            });
} catch (\Exception $e) {
    Log::error('Email sending failed: '.$e->getMessage());
    Log::error('Trace: '.$e->getTraceAsString());
}
            // Cleanup temporary files
            foreach ($temporaryFiles as $tempFile) {
                if (file_exists($tempFile)) {
                    unlink($tempFile);
                }
            }
        } catch (\Exception $e) {
            Log::error('Invoice email failed: ' . $e->getMessage());
        }
    }
}
