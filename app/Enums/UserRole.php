<?php

namespace App\Enums;

enum UserRole: string
{
    case OWNER = 'owner';
    case ADMIN = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::OWNER => 'Owner',
            self::ADMIN => 'Admin',
        };
    }
}
