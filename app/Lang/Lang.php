<?php

namespace App\Lang;

/**
 * Language Enum
 * 
 * This enum defines all supported languages in the application.
 * It serves multiple purposes:
 * 1. Central definition of available languages
 * 2. Type safety for language operations
 * 3. Validation of language codes
 * 4. Providing user-friendly labels for the frontend
 * 
 * Usage examples:
 * - Lang::EN->value returns 'en'
 * - Lang::tryFrom('es') returns Lang::ES or null if invalid
 * - Lang::cases() returns all available language cases
 * - Lang::EN->label() returns 'English'
 */
enum Lang: string
{
    // Language cases with their ISO 639-1 codes
    // These codes must match the folder names in lang/ directory
    case EN = 'en';  // English - default language
    case ES = 'es';  // Spanish (Español)
    case IT = 'it';  // Italian (Italiano)  
    case PT = 'pt';  // Portuguese (Português)

    /**
     * Get the user-friendly label for each language.
     * 
     * Returns the language name in its native script/language.
     * This is what users see in the language selector dropdown.
     * 
     * @return string The native name of the language
     */
    public function label(): string
    {
        return match ($this) {
            self::EN => 'English',    // English name in English
            self::ES => 'Español',    // Spanish name in Spanish
            self::IT => 'Italiano',   // Italian name in Italian
            self::PT => 'Português',  // Portuguese name in Portuguese
        };
    }
}
