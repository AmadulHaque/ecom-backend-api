<?php

namespace App\Services\Payments;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SslCommerzPayment implements PaymentProcessor
{
    public function process(Order $order, array $data = [])
    {
        $post_data = [
            'tran_id' => $order->invoice_id,
            'total_amount' => $order->total_amount,
            'currency' => 'BDT',
            'cus_name' => $order->customer_name,
            'cus_email' => 'example@example.com',
            'cus_add1' => $order->customer_address,
            'cus_country' => 'Bangladesh',
            'cus_phone' => $order->customer_number,
            'ship_name' => $order->customer_name,
            'ship_add1' => $order->customer_address,
            'ship_city' => $order->customer_address,
            'ship_country' => 'Bangladesh',
            'shipping_method' => 'NO',
            'product_name' => 'products',
            'product_category' => 'Goods',
            'product_profile' => 'physical-goods',
        ];

        try {
            DB::beginTransaction();
            $merchantOrders = $order->merchantOrders()->get();
            foreach ($merchantOrders as $merchantOrder) {
                $tranId = getInvoiceNo('order_payments', 'tran_id', 'SSL');
                $merchantOrder->payments()->create([
                    'merchant_id' => $merchantOrder->merchant_id,
                    'tran_id' => $tranId,
                    'amount' => $merchantOrder->total_amount,
                    'payment_method' => PaymentMethod::SSLCOMMERZ,
                    'payment_status' => PaymentStatus::PENDING,
                    'payment_ref' => $data['payment_ref'] ?? null,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return ['status' => 'error', 'message' => $e->getMessage()];
        }
        $sslC = new SslCommerzNotification;
        $payment_options = $sslC->makePayment($post_data, 'checkout', 'json');

        // if (!is_array($payment_options)) {
        //     return ['status' => 'error', 'message' => 'Failed to initiate payment'];
        // }

        return [
            'status' => 'success',
            'message' => 'SSlCommerz payment initiated',
            'data' => $payment_options,
        ];
    }

    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order = Order::where('invoice_id', $tran_id)->first();
        if (! $order) {
            Log::error('Order not found for transaction ID: '.$tran_id);

            return ['status' => 'error', 'message' => 'Order not found.'];
        }

        try {
            DB::beginTransaction();

            $merchantOrders = $order->merchantOrders()->get();
            foreach ($merchantOrders as $merchantOrder) {
                $merchantOrder->payments()->update([
                    'payment_status' => PaymentStatus::SUCCESS,
                ]);
            }

            DB::commit();
            Log::info('Payment successful for transaction ID: '.$tran_id);

            return ['status' => 'success', 'message' => 'Payment successful.'];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment success handling failed: '.$e->getMessage());

            return ['status' => 'error', 'message' => 'Payment success handling failed.'];
        }
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');
        Log::error('Payment failed.', [
            'transaction_id' => $tran_id,
            'request_data' => $request->all(),
        ]);

        $order = Order::where('invoice_id', $tran_id)->first();
        if ($order) {
            try {
                DB::beginTransaction();

                $merchantOrders = $order->merchantOrders()->get();
                foreach ($merchantOrders as $merchantOrder) {
                    $merchantOrder->payments()->update([
                        'payment_status' => PaymentStatus::FAILED,
                    ]);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error handling payment failure: '.$e->getMessage());
            }
        }
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        Log::warning('Payment canceled.', [
            'transaction_id' => $tran_id,
            'request_data' => $request->all(),
        ]);

        $order = Order::where('invoice_id', $tran_id)->first();
        if ($order) {
            try {
                DB::beginTransaction();

                $merchantOrders = $order->merchantOrders()->get();
                foreach ($merchantOrders as $merchantOrder) {
                    $merchantOrder->payments()->update([
                        'payment_status' => PaymentStatus::CANCELLED,
                    ]);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error handling payment cancellation: '.$e->getMessage());
            }
        }
    }

    public function ipn(Request $request)
    {
        Log::info('IPN received.', [
            'request_data' => $request->all(),
        ]);

        $tran_id = $request->input('tran_id');
        $order = Order::where('invoice_id', $tran_id)->first();

        if ($order) {
            try {
                DB::beginTransaction();

                $merchantOrders = $order->merchantOrders()->get();
                foreach ($merchantOrders as $merchantOrder) {
                    $merchantOrder->payments()->update([
                        'payment_status' => PaymentStatus::SUCCESS,
                    ]);
                }

                DB::commit();
                Log::info('IPN processed successfully for transaction ID: '.$tran_id);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error processing IPN: '.$e->getMessage());
            }
        } else {
            Log::warning('IPN received for unknown transaction ID: '.$tran_id);
        }
    }
}
