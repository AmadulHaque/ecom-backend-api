<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['status_label', 'status_bg_color'];

    public function order()
    {
        return $this->belongsTo(MerchantOrder::class, 'merchant_order_id', 'id');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }

    public function getStatusLabelAttribute()
    {
        return PaymentStatus::getStatusLabels()[$this->payment_status->value];
    }

    public function getStatusBgColorAttribute()
    {
        $statuses = PaymentStatus::status_by_color() ?? [];

        return $statuses[$this->status_id] ?? 'alert-warning';
    }

    public $casts = [
        'payment_status' => PaymentStatus::class,
    ];
}
