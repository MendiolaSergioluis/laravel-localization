import { Config } from 'ziggy-js';

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export interface Language {
    value: string;
    label: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
    language: string;
    languages: Language[];
    translations: Record<string, string>;
    ziggy: Config & { location: string };
};
