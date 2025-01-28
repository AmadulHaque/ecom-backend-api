<?php

namespace App\Enums;

enum AddressStatus: string
{
    case ACTIVE = true;
    case IN_ACTIVE = false;
}
