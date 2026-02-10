<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SendRentReceiptMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $data;
    protected $pdfPath;

    public function __construct($email, $data, $pdfPath)
    {
        $this->email = $email;
        $this->data = $data;
        $this->pdfPath = $pdfPath;
    }

    public function handle()
    {
        // Log the incoming data to check if everything is received correctly
        // Log::info('SendRentReceiptMail job started');
        // Log::info('Email: ' . $this->email);
        // Log::info('PDF Path: ' . $this->pdfPath);
        // Log::info('Data: ' . json_encode($this->data));

        $data = $this->data;    
        $data['title'] = 'Rent receipts from Myitronline';
        $data['subject'] = 'Your rent receipts generated successfully from Myitronline';
        $receiptId = $data['SaveRentReceiptData']->uniqueId;
        // Log to ensure the PDF path is being received correctly
        // Log::info('Preparing to send email with PDF attachment from path: ' . $this->pdfPath);

        // Resolve the correct storage path
        $pdfFullPath = $this->pdfPath;
        // $pdfFullPath = public_path('uploads/rent-receipt/' . basename($this->pdfPath));

        // Log to verify the full path
        // Log::info('Full PDF path: ' . $pdfFullPath);
        $pdfFullPath = public_path('uploads/rent-receipt/MYITR-' . $receiptId . '.pdf');
        // Check if the PDF file exists before attaching it
        if (!file_exists($pdfFullPath)) {
            Log::error('PDF file does not exist at path: ' . $pdfFullPath);
            return; // Exit the job if the file doesn't exist
        }

        // Log before sending the email
        Log::info('Sending email to ' . $this->email);

        // Send email using Laravel's Mail facade
        try {
            Mail::send('mailer.rent', $data, function ($message) use ($data, $pdfFullPath) {
                $message->to($this->email)
                    ->cc('info@myitronline.com')
                    ->cc('kgvarshney@gmail.com')
                    ->cc('mayankm738@gmail.com')
                    ->subject($data['title'])
                    ->attach($pdfFullPath); // Attach the generated PDF from storage
            });
            Log::info('Email sent successfully to ' . $this->email);
        } catch (\Exception $e) {
            // Catch any errors that happen during email sending
            Log::error('Error sending email: ' . $e->getMessage());
        }
    }
}
