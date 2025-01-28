<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Models\OrderPayment;

class PaymentService
{
    public function getAllPayments($request)
    {
        $search = $request->search;
        $type = $request->input('type', 'division');
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);

        return OrderPayment::query()
            ->with([
                'order',
                'merchant',
            ])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('order', function ($query) use ($search) {
                    $query->where('tracking_id', 'like', "%{$search}%");
                })->orWhere('tran_id', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page)->withQueryString();
    }

    public function paymentStatusChange($request, $id)
    {
        $payment = OrderPayment::find($id);
        if (! $payment) {
            return redirect()->back()->with('message', 'Payment not found');
        }
        if (! in_array($request->status, PaymentStatus::getValues())) {
            return redirect()->back()->with('message', 'Invalid status');
        }

        try {
            $payment->payment_status = $request->status;
            $payment->save();
            if ($request->status == PaymentStatus::APPROVED->value) {
                // $this->isPaymentApproved($payment);
            }

            return redirect()->back()->with('message', 'Payment status updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'Something went wrong');
        }
    }

    public function getPaymentById($id)
    {
        return OrderPayment::with([
            'order',
            'merchant',
        ])->where('tran_id', $id)->first();
    }

    public function isPaymentApproved($payment)
    {
        // merchant balance update
        $payment->merchant->balance += $payment->amount;
        $payment->merchant->save();

    }
}
