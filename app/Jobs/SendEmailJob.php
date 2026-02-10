<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $otp;

    /**
     * Create a new job instance.
     *
     * @param string $email
     * @param int $otp
     * @return void
     */
    public function __construct($email, $otp)
    {
        $this->email = $email;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            'email' => $this->email,
            'otp' => $this->otp,
            'title' => 'HRA App reset password',
            'subject' => 'Thank you  MyITROnline Team',
        ];

        // Send email
        Mail::send('mailer.common_mail_tpl', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['email'])
                    ->subject($data['title']);
        });
    }
}
