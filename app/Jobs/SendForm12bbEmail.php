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
use PDF;

class SendForm12bbEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $data;
    protected $pdfPath;

    /**
     * Create a new job instance.
     *
     * @param array $data_array
     * @param int $receiptId
     */
    public function __construct($email, $pdfPath)
    {
        $this->email = $email;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        // Define your data for the email
        $data = [
            'title' => 'Your Form 12BB from Myitronline Generated Successfully',
            'subject' => 'Thank you for Choosing Service on Myitronline',
        ];

        // Path to the PDF file
        $pathToPdf = storage_path('app/' . $this->pdfPath);

        // Send email using Laravel's Mail facade
        Mail::send('mailer.form12bb_tpl', $data, function ($message) use ($data, $pathToPdf) {
            $message->to($this->email)
                ->cc('info@myitronline.com')
                ->cc('kgvarshney@gmail.com')
                ->cc('admin@myitronline.com')
                ->subject($data['title'])
                ->attach($pathToPdf); // Attach the generated PDF from storage
        });
    }
}
