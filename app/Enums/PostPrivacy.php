<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PostPrivacy: string implements HasLabel
{
    case Public = 'public';
    case Friends = 'friends';
    case Private = 'private';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Public => 'Public',
            self::Friends => 'Friends',
            self::Private => 'Private',
        };
    }

    public static function toArray(): array
    {
        return array_column(PostPrivacy::cases(),'value');
    }
}
