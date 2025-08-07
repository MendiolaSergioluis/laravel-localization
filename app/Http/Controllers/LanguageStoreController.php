<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lang\Lang;

class LanguageStoreController extends Controller
{
    /**
     * Handle the incoming request to change the application's language.
     *
     * This method receives a language code from the request, validates it using the Lang enum,
     * and stores the selected language in the session. The application will use this value
     * to set the locale for the user in subsequent requests (if you have the SetLocale middleware).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        // Try to get a valid locale from the Lang enum using the value from the request.
        // If the value is not valid, use the default locale from the config.
        $locale = Lang::tryFrom($request->language)->value ?? config('app.locale');

        // Store the selected locale in the session so it can be used in future requests.
        session()->put('language', $locale);

        // Redirect the user back to the previous page.
        return back();
    }
}
