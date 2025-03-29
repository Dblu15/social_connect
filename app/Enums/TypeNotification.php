<?php

namespace App\Enums;

enum TypeNotification: string
{
    case Like = 'like';
    case Comment = 'comment';
    case Share = 'share';
    case Follow = 'follow';

    public function getLable(): string
    {
        return match ($this){
            self::Like => 'like',
            self::Comment => 'comment',
            self::Share => 'share',
            self::Follow => 'follow',
        };
    }

    public static function toArray(): array
    {
        return array_column(TypeNotification::cases(),'value');
    }
}
