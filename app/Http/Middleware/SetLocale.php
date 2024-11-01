<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = Session::get('locale', 'en');
        App::setLocale($locale);

        Log::info("Locale in middleware:", ['locale' => $locale]); // Log locale

        return $next($request);
    }
}
