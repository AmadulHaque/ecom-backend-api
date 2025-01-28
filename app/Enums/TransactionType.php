<?php

namespace App\Enums;

enum TransactionType: int
{
    case DEPOSIT = 1;
    case WITHDRAW = 2;
    case FINE = 3;
    case REFUND = 4;

    public function getLabel(): string
    {
        return [
            self::DEPOSIT->value => 'Deposit',
            self::WITHDRAW->value => 'Withdraw',
            self::FINE->value => 'Fine',
            self::REFUND->value => 'Refund',
        ];
    }
}
