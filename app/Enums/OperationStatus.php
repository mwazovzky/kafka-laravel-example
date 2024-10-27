<?php

namespace App\Enums;

enum OperationStatus: string
{
    case CREATED = 'created';
    case COMPLETED = 'confirmed';
    case CANCELLED = 'cancelled';
}
