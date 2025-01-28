<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutBeneficiary extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function beneficiaryTypes()
    {
        return $this->belongsTo(PayoutBeneficiaryTypes::class, 'payout_beneficiary_type_id');
    }

    public function mobileWallet()
    {
        return $this->belongsTo(PayoutBeneficiaryMobileWallet::class, 'payout_beneficiary_mobile_wallet_id');
    }

    public function bank()
    {
        return $this->belongsTo(PayoutBeneficiaryBank::class, 'payout_beneficiary_bank_id');
    }
}
