<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PENDING = 1;
    case APPROVED = 2;
    case PROCESSING = 3;
    case DELIVERED = 4;
    case CANCELLED = 5;
    case RETURN_REQUEST = 6;
    case RETURNED = 7;
    case REFUNDED = 8;
    case READY_TO_SHIP = 9;
    case PARTIAL_DELIVERED = 10;
    case UNKNOWN = 11;

    public static function getStatusLabels(): array
    {
        return [
            self::PENDING->value => 'Pending',
            self::APPROVED->value => 'Approved',
            self::PROCESSING->value => 'Processing',
            self::DELIVERED->value => 'Delivered',
            self::CANCELLED->value => 'Cancelled',
            self::RETURN_REQUEST->value => 'Return Request',
            self::RETURNED->value => 'Returned',
            self::REFUNDED->value => 'Refunded',
            self::READY_TO_SHIP->value => 'Ready to Ship',
        ];
    }

    public static function status_by_color(): array
    {
        return [
            self::PENDING->value => 'alert-warning',
            self::PROCESSING->value => 'alert-info',
            self::APPROVED->value => 'alert-success',
            self::DELIVERED->value => 'alert-success',
            self::DELIVERED->value => 'alert-success',
            self::CANCELLED->value => 'alert-danger',
            self::RETURN_REQUEST->value => 'alert-warning',
            self::RETURNED->value => 'alert-danger',
            self::REFUNDED->value => 'alert-success',
        ];
    }

    public static function getProductStatusLabels(): array
    {
        return [
            self::PENDING->value => 'Pending', // 1
            self::APPROVED->value => 'Approved',
            self::PROCESSING->value => 'Processing', // 3
            self::CANCELLED->value => 'Cancelled', // 5
            self::DELIVERED->value => 'Delivered', // 4
            self::RETURN_REQUEST->value => 'Return Requested', // 6
            self::RETURNED->value => 'Returned', // 7
            self::REFUNDED->value => 'Refunded', // 8
        ];
    }
}
