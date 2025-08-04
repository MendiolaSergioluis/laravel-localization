<?php

namespace App\Lang;

enum Lang: string
{
    case EN = 'en';
    case ES = 'es';
    case IT = 'it';
    case PT = 'pt';

    public function label(): string
    {
        return match ($this) {
            self::EN => 'English',
            self::ES => 'Español',
            self::IT => 'Italiano',
            self::PT => 'Português',
        };
    }
}
