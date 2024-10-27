<?php

namespace App\Enums;

enum AddressType: string
{
    case HOT = 'hot';
    case COLD = 'cold';
    case EXTERNAL = 'external';
}
