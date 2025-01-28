<?php

namespace App\Enums;

enum PayoutStatus: int
{
    case PENDING = 1;
    case INPROGRESS = 2;
    case APPROVED = 3;
    case REJECTED = 4;

    public static function getLabel(): array
    {
        return [
            self::PENDING->value => 'Pending',
            self::INPROGRESS->value => 'In Progress',
            self::APPROVED->value => 'Approved',
            self::REJECTED->value => 'Rejected',
        ];
    }

    // bg color

    public static function getBgColor(): array
    {
        return [
            self::PENDING->value => 'bg-warning',
            self::INPROGRESS->value => 'bg-info',
            self::APPROVED->value => 'bg-success',
            self::REJECTED->value => 'bg-danger',
        ];
    }
}
