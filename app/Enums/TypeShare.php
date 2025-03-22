<?php

namespace App\Enums;

enum TypeShare: string
{
    case Profile = 'profile';
    case Group = 'group';
    case Page = 'page';

    public function getLable(): ?string
    {
        return match ($this){
            self::Profile => 'Profile',
            self::Group => 'Group',
            self::Page => 'Page',
        };
    }

    public static function toArray(): array
    {
        return array_column(TypeShare::cases(), 'value');
    }
}
