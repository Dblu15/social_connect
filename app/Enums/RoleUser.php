<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RoleUser: string implements HasLabel
{
    case Admin = 'admin';
    case User = 'user';
    public function getLabel(): ?string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::User => 'User',
        };
    }

    public static function toArray(): array
    {
        return array_column(RoleUser::cases(),'value');
    }
}
