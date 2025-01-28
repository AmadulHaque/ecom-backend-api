<?php

namespace App\Enums;

enum PaymentStatus: int
{
    case PENDING = 1;
    case SUCCESS = 2;
    case APPROVED = 3;
    case CANCELLED = 4;
    case FAILED = 5;

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getStatusLabels(): array
    {
        return [
            self::PENDING->value => 'Pending',
            self::SUCCESS->value => 'Success',
            self::APPROVED->value => 'Approved',
            self::CANCELLED->value => 'Cancelled',
            self::FAILED->value => 'Failed',
        ];
    }

    public static function status_by_color(): array
    {
        return [
            self::PENDING->value => 'alert-warning',
            self::SUCCESS->value => 'alert-info',
            self::APPROVED->value => 'alert-success',
            self::CANCELLED->value => 'alert-danger',
            self::FAILED->value => 'alert-warning',
        ];
    }
}
