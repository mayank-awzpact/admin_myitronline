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

    // The 'api' limiter now covers every route in routes/api.php, so it needs enough
    // headroom for a normal page load on the storefront (several calls per view).
    // The tight limits stay on the auth / OTP endpoints below.
    $apiLimit = (int) env('API_RATE_LIMIT_PER_MINUTE', 60);
    $apiLimit = $apiLimit > 0 ? $apiLimit : 60;

    RateLimiter::for('api', function (Request $request) use ($apiLimit) {
        return Limit::perMinute($apiLimit)->by($request->user()?->id ?: $request->ip());
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

    // Guard for the endpoints that actually send a mail (signup OTP, resend OTP,
    // forgot password). Keyed by the target email as well as the IP: the abuse in
    // storage/logs/mail.log fired repeat OTPs at a single address on 2026-08-30 and
    // 2026-09-05, which an IP-only limit would not have stopped.
    RateLimiter::for('otp', function (Request $request) {
        $email = strtolower(trim((string) $request->input('email')));
        $target = $email !== '' ? 'mail:' . $email : 'ip:' . $request->ip();

        return [
            Limit::perMinute(5)->by('otp-ip:' . $request->ip()),
            Limit::perMinute(2)->by('otp-target:' . $target),
            Limit::perDay(20)->by('otp-target-day:' . $target),
        ];
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
