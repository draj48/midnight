<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class RedirectToInstaller
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route = Route::getRoutes()->match($request);
        $currentroute = $route->getName();
        if (env('APP_ENV') == 'install' AND !$request->is('install/*')) {
            return redirect()->route('install.index');
        }

        return $next($request);
    }
}
