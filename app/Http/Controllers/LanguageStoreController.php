<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lang\Lang;

/**
 * LanguageStoreController
 * 
 * This controller handles language switching requests from the frontend.
 * It's an invokable controller (single action) that processes the language
 * selection from the dropdown and stores it in the user's session.
 * 
 * Request Flow:
 * 1. User selects language in frontend dropdown
 * 2. JavaScript sends POST request to route('language.store')
 * 3. This controller validates and stores the language choice
 * 4. SetLanguage middleware uses stored language on next request
 * 
 * Route: POST /languate
 * Expected request data: { language: 'en'|'es'|'it'|'pt' }
 */
class LanguageStoreController extends Controller
{
    /**
     * Handle the incoming request to change the application's language.
     *
     * This invokable method:
     * 1. Receives language code from the frontend (via select dropdown)
     * 2. Validates the language code using our Lang enum for security
     * 3. Stores the validated language in the session for persistence
     * 4. Redirects back so the SetLanguage middleware applies the change
     *
     * @param  \Illuminate\Http\Request  $request Contains 'language' parameter
     * @return \Illuminate\Http\RedirectResponse Redirects back to previous page
     */
    public function __invoke(Request $request)
    {
        // Validate and extract the language code from the request
        // $request->language contains the selected language code (e.g., 'es', 'en')
        // Lang::tryFrom() safely attempts to create a Lang enum from the input
        // If the input is invalid (not in our enum), tryFrom() returns null
        // ?->value safely gets the enum value if valid, null if tryFrom failed
        // ?? config('app.locale') provides fallback to default language if invalid
        $locale = Lang::tryFrom($request->language)->value ?? config('app.locale');

        // Store the validated language choice in the user's session
        // Key 'language' matches what SetLanguage middleware looks for
        // This persists across requests until the session expires or user changes it
        session()->put('language', $locale);

        // Redirect back to the previous page (where the user made the selection)
        // The next request will trigger SetLanguage middleware to apply the new locale
        // User will see the page in their newly selected language
        return back();
    }
}
