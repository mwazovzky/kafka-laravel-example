<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case CREATED = 'created';
    case CONFIRMED = 'confirmed';
    case CANCELLED = 'cancelled';
}
