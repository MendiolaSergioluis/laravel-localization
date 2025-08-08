import { usePage } from '@inertiajs/vue3';

/**
 * Translation helper function.
 * Looks up the translation string for the given key from the Inertia page props.
 * Optionally replaces placeholders in the translation with values from the replacements object.
 *
 * @param key - The translation key (e.g., 'dashboard.greeting')
 * @param replacements - An object with replacement values for placeholders (e.g., { name: 'Sergio' })
 * @returns The translated string with replacements applied, or the key if not found
 */
export default function __(key: string, replacements: Record<string, string> = {}): string {
    // Get the translation string from the current page's props, or use the key as fallback
    let translation = usePage().props.translations[key] || key;

    // Replace placeholders in the translation string with values from replacements
    Object.keys(replacements).forEach((replacement) => {
        translation = translation.replace(`:${replacement}`, replacements[replacement]);
    });

    return translation;
}
