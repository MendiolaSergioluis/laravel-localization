<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * LanguageResource
 * 
 * This resource transforms Lang enum instances into a JSON format
 * suitable for frontend consumption, particularly for the language selector.
 * 
 * The resource converts each Lang enum case into an object with:
 * - 'value': The language code (e.g., 'en', 'es') for form submissions
 * - 'label': The native language name (e.g., 'English', 'Español') for display
 * 
 * Usage: LanguageResource::collection(Lang::cases())
 * Output: [
 *   {"value": "en", "label": "English"},
 *   {"value": "es", "label": "Español"},
 *   ...
 * ]
 */
class LanguageResource extends JsonResource
{
    /**
     * Transform the Lang enum into an array for JSON serialization.
     * 
     * This method is called for each Lang enum case when using
     * LanguageResource::collection() to transform all language options.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // The enum value - used as the option value in forms/selects
            // This is what gets sent to the server when user selects a language
            'value' => $this->value,
            
            // The human-readable label - used for display in the UI
            // Calls the label() method on the Lang enum to get native name
            'label' => $this->label(),
        ];
    }
}
