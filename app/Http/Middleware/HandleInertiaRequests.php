<?php

namespace App\Http\Middleware;

use App\Lang\Lang;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
use App\Http\Resources\LanguageResource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    /**
     * Define the props that are shared by default.
     * These props will be available in all Vue components through $page.props
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],

            // Current application locale (e.g., 'en', 'es', 'it', 'pt')
            // Set by the SetLanguage middleware from session or config default
            'language' => app()->getLocale(),

            // Available languages for the language selector dropdown
            // Transforms the Lang enum cases into a collection with 'value' and 'label'
            'languages' => LanguageResource::collection(Lang::cases()),

            // All translation strings for the current locale
            // This loads ALL language files and makes them available in frontend
            // Uses lazy loading (function) to avoid loading on every request
            // 
            // OPTIMIZATION: Cache implementation for better performance
            // To implement caching for translations (future enhancement):
            // 
            // 'translations' => function () {
            //     $locale = app()->getLocale();
            //     $cacheKey = "translations.{$locale}";
            //     
            //     return Cache::remember($cacheKey, 3600, function () use ($locale) {
            //         // Current translation loading logic goes here
            //     });
            // }
            'translations' => function () {
                // Get the language folder path based on current locale
                // e.g., /path/to/project/lang/en/ or /path/to/project/lang/es/
                $languageFolder = base_path('lang/' . app()->getLocale());

                // Check if the language folder exists
                if (!File::exists($languageFolder)) {
                    // Option 1: Return an empty array
                    return [];

                    // Option 2: If the folder doesn't exist, try to load the fallback locale
                    // $fallbackFolder = base_path('lang/' . config('app.fallback_locale'));
                    // if (File::exists($fallbackFolder)) {
                    //     $files = File::allFiles($fallbackFolder);
                    //     return collect($files)->flatMap(function ($file){
                    //         return Arr::dot(
                    //             File::getRequire($file->getRealPath()),
                    //             $file->getBasename('.' . $file->getExtension()) . '.'
                    //         );
                    //     });
                    // }
                    // // If fallback folder also doesn't exist, return empty array
                    // return [];
                }

                // Get all .php files from the language folder
                // These are files like auth.php, pagination.php, validation.php
                $files = File::allFiles($languageFolder);

                // Transform all language files into a flat associative array
                return collect($files)->flatMap(function ($file) {
                    // Arr::dot() converts nested arrays to dot notation
                    // e.g., ['auth' => ['failed' => 'message']] becomes ['auth.failed' => 'message']
                    return Arr::dot(
                        // Load the PHP file and get its return array
                        File::getRequire($file->getRealPath()),
                        // Use filename as prefix: auth.php becomes 'auth.'
                        $file->getBasename('.' . $file->getExtension()) . '.'
                    );
                });
            },

            // Ziggy configuration for client-side routing
            'ziggy' => fn() => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}
