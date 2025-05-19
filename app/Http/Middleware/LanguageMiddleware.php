<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        } elseif(empty(session()->has('locale'))) {
            App::setLocale(config('settings.language'));
        }else {
            App::setLocale(config('app.fallback_locale'));
        }
        return $next($request);
    }
}
