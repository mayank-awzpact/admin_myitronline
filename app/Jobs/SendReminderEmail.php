<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data['blog'] = $this->data;//print_r($customData);die;
        $subscribedUsers = DB::table('tbl_blog_lead')->select('email')->get();//print_r($subscribedUsers);die;
        foreach ($subscribedUsers as $user) {
            $data['email'] = $user->email;
            $data["title"]='Welcome to our newsletter';
            $data["subject"]='Thank you for Choose Service on Apnokaca';
            Mail::send('mailer.reminder_tpl', $data, function ($message) use ($data) {
                $message->to($data["email"], $data["email"])
                ->subject($data["title"]);
                // ->attachData($pdf->output(), "invoice.pdf");
            });
        }
    }
}
