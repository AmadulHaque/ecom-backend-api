<?php

namespace App\Models;

use App\Enums\PayoutStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'status_label',
    ];

    public function payoutBeneficiary()
    {
        return $this->belongsTo(PayoutBeneficiary::class, 'payout_beneficiary_id');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }

    public function getStatusLabelAttribute()
    {
        return [
            'value' => PayoutStatus::getLabel()[$this->status],
            'bg_color' => PayoutStatus::getBgColor()[$this->status],
        ];
    }

    public $cast = [
        'status' => PayoutStatus::class,
    ];
}
