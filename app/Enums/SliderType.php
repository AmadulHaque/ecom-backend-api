<?php

namespace App\Enums;

enum SliderType: int
{
    case ROOT = 1;
    case SHOP = 2;

    public static function getLabel($getLabel): string
    {
        return match ($getLabel) {
            self::ROOT => 'Slider Root',
            self::SHOP => 'Slider Shop',
            default => 'Select type',
        };
    }
}
