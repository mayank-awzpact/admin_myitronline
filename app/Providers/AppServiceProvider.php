<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;

class AppServiceProvider extends ServiceProvider
{
   public function boot()
{
    date_default_timezone_set('Asia/Kolkata');

    // Rate limiters for hacking / brute-force protection (10 requests per minute - configurable via RATE_LIMIT_PER_MINUTE in .env)
    $limit = (int) env('RATE_LIMIT_PER_MINUTE', 10);
    $limit = $limit > 0 ? $limit : 10;

    RateLimiter::for('api', function (Request $request) use ($limit) {
        return Limit::perMinute($limit)->by($request->user()?->id ?: $request->ip());
    });

    RateLimiter::for('login', function (Request $request) use ($limit) {
        return Limit::perMinute($limit)->by($request->ip());
    });

    RateLimiter::for('admin', function (Request $request) use ($limit) {
        return Limit::perMinute($limit)->by($request->user()?->id ?: $request->ip());
    });

    RateLimiter::for('sensitive', function (Request $request) use ($limit) {
        return Limit::perMinute($limit)->by($request->user()?->id ?: $request->ip());
    });

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
