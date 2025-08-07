<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Lang\Lang; // Assuming Lang is an enum or class that handles language codes

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = Lang::tryFrom(session()->get('language', config('app.locale')))?->value ?? config('app.locale');
        
        app()->setLocale($locale);

        return $next($request);
    }
}
