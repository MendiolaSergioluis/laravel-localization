import { Config } from 'ziggy-js';

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
    language: string;
    languages: [
        {
            value: string;
            label: string;
        }
    ];
    ziggy: Config & { location: string };
};
