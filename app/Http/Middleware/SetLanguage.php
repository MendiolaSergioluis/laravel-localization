<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Lang\Lang; // Our custom enum that defines available languages

/**
 * SetLanguage Middleware
 * 
 * This middleware runs on every web request to set the application's locale
 * based on the user's language preference stored in the session.
 * 
 * Execution order:
 * 1. StartSession middleware creates/loads the session
 * 2. SetLanguage middleware (this) reads language from session and sets locale
 * 3. HandleInertiaRequests middleware shares data (including current locale) with frontend
 */
class SetLanguage
{
    /**
     * Handle an incoming request and set the application locale.
     * 
     * This method:
     * 1. Retrieves the user's preferred language from session
     * 2. Validates the language using our Lang enum
     * 3. Sets the application locale for this request
     * 4. Falls back to default config locale if invalid
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get language from session, fallback to config default if not set
        // session()->get('language', config('app.locale')) returns the stored language or 'en'
        // Lang::tryFrom() validates if the language code exists in our enum
        // ?->value gets the enum value safely (returns null if tryFrom failed)
        // ?? config('app.locale') provides final fallback if validation failed
        $locale = Lang::tryFrom(session()->get('language', config('app.locale')))?->value ?? config('app.locale');
        
        // Set the application locale for this request
        // This affects all translation functions: __(), trans(), etc.
        // The locale will be used to load the correct language files from lang/ folder
        app()->setLocale($locale);

        // Continue to the next middleware in the pipeline
        return $next($request);
    }
}
