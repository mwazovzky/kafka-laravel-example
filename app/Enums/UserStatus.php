<?php

namespace App\Enums;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case BLOCKED = 'blocked';
    case DEACTIVATED = 'deactivated';
}