<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
{
    protected const ALLOWED_LOCALIZATIONS = ['en', 'ar'];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // api
        $localization = $request->header('Accept-Language');
        if ($localization) {
            $localization = in_array($localization, self::ALLOWED_LOCALIZATIONS, true) ? $localization : 'en';
            app()->setLocale($localization);
        }
        // web
        if (session()->has('locale')) {
            App::setlocale(session()->get('locale'));
        }

        return $next($request);
    }
}
