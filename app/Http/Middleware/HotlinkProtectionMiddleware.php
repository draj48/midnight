<?php

namespace App\Http\Middleware;

use Closure;

class HotlinkProtectionMiddleware
{
    public function handle($request, Closure $next)
    {

        // Referer boşsa veya referer youtube.com ise devam et
        $referer = $request->headers->get('referer');
        $allowedDomain = url('/'); // Kendi alan adınızı buraya girin

        // Referer boşsa veya referer kendi alan adınızdaysa devam et
        if (empty($referer) || parse_url($referer, PHP_URL_HOST) === $_SERVER['SERVER_NAME']) {
            return $next($request);
        }

        // Hotlink tespit edildiğinde buraya ulaşılır
        return response('Hotlink protection', 403);
    }
}
