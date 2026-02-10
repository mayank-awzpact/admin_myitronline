<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $locale = Session::get('locale', config('app.locale'));

        if (!in_array($locale, ['en', 'hi'])) {
            $locale = config('app.locale'); // Fallback to default
        }

        App::setLocale($locale);
        Session::put('locale', $locale); // Ensure session is updated

        return $next($request);
    }
}
