<?php

namespace App\Services;

use App\Enums\PayoutStatus;
use App\Models\Payout;

class PayoutRequestService
{
    public function getPayoutRequests($request)
    {
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        $date = $request->input('date', '');
        $merchant_id = $request->input('merchant_id', '');
        $status = $request->input('status', '');

        $requests = Payout::query()
            ->with([
                'merchant',
                'payoutBeneficiary',
                'payoutBeneficiary.bank',
                'payoutBeneficiary.beneficiaryTypes',
                'payoutBeneficiary.mobileWallet',
            ])
            ->when($merchant_id, function ($query) use ($merchant_id) {
                return $query->where('merchant_id', $merchant_id);
            })
            ->when($date, function ($query) use ($date) {
                $query->whereDate('created_at', $date);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('status', 'asc')
            ->paginate($perPage, ['*'], 'page', $page);

        return $requests;
    }

    public function getPayoutRequestById($id)
    {
        return Payout::with([
            'merchant',
            'payoutBeneficiary',
            'payoutBeneficiary.bank',
            'payoutBeneficiary.beneficiaryTypes',
            'payoutBeneficiary.mobileWallet',
        ])->find($id);
    }

    public function updateStatus($request, $id)
    {
        $payoutRequest = Payout::find($id);
        if ($payoutRequest->status != PayoutStatus::APPROVED && $request->status == PayoutStatus::APPROVED->value) {
            $payoutRequest->merchant->balance -= $payoutRequest->amount;
            $payoutRequest->merchant->save();
        }
        if ($payoutRequest->status == PayoutStatus::APPROVED && $request->status != PayoutStatus::APPROVED->value) {
            $payoutRequest->merchant->balance += $payoutRequest->amount;
            $payoutRequest->merchant->save();
        }
        $payoutRequest->status = $request->status;
        $payoutRequest->save();

    }
}
