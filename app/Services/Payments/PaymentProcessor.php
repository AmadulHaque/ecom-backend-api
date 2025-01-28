<?php

namespace App\Services\Payments;

use App\Models\Order;

interface PaymentProcessor
{
    public function process(Order $order, array $data = []);
}
