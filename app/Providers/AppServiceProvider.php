<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
   public function boot()
{
    date_default_timezone_set('Asia/Kolkata');
Event::listen(MessageSending::class, function (MessageSending $event) {
    $message = $event->message;
    $toEmails = [];
    foreach ($message->getTo() ?? [] as $addressObj) {
        if ($addressObj instanceof \Symfony\Component\Mime\Address) {
            $toEmails[] = $addressObj->getAddress();
        }
    }
    $toLine = count($toEmails) > 0 ? implode(', ', $toEmails) : 'Unknown';
  
    Log::channel('mail_log')->info("📧 Sending Mail");
    Log::channel('mail_log')->info("To: {$toLine}");
    Log::channel('mail_log')->info("Subject: " . $message->getSubject());
    Log::channel('mail_log')->info("Triggered from URL: " . (request()->headers->get('referer') ?? request()->fullUrl()));
});

}
}
