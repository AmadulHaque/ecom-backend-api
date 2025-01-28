<?php

namespace App\Services\Payments;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;

class CodPayment implements PaymentProcessor
{
    public function process(Order $order, array $data = [])
    {
        try {
            $merchantOrders = $order->merchantOrders()->get();
            foreach ($merchantOrders as $merchantOrder) {
                $tranId = getInvoiceNo('order_payments', 'tran_id', 'COD');
                $merchantOrder->payments()->create([
                    'merchant_id' => $merchantOrder->merchant_id,
                    'tran_id' => $tranId,
                    'amount' => $merchantOrder->total_amount,
                    'payment_method' => PaymentMethod::COD,
                    'payment_status' => PaymentStatus::PENDING,
                    'payment_ref' => $data['payment_ref'] ?? null,
                ]);
            }

            return ['status' => 'success', 'message' => 'Cash on Delivery selected'];
        } catch (\Throwable $th) {
            return ['status' => 'error', 'message' => $th->getMessage()];
        }
    }
}
