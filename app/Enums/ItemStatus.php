<?php

namespace App\Enums;

enum ItemStatus: int
{
    case PENDING = 0;
    case APPROVED = 1;
    case REJECTED = 2;
    case COMPLETED = 3;
    case PROCESSING = 4;
    case DECLINED = 5;
    case REFUNDED = 6;

    public static function getLabel(): array
    {
        return [
            self::PENDING->value => 'Pending',
            self::APPROVED->value => 'Approved',
            self::REJECTED->value => 'Rejected',
            self::COMPLETED->value => 'Completed',
            self::PROCESSING->value => 'Processing',
            self::DECLINED->value => 'Declined',
            self::REFUNDED->value => 'Refunded',
        ];
    }
}
