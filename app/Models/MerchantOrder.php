<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['status_label', 'status_bg_color'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(OrderPayment::class);
    }

    public function getStatusLabelAttribute()
    {
        $statuses = OrderStatus::getStatusLabels() ?? [];

        return $statuses[$this->status_id] ?? 'Unknown';
    }

    public function getStatusBgColorAttribute()
    {
        $statuses = OrderStatus::status_by_color() ?? [];

        return $statuses[$this->status_id] ?? 'alert-warning';
    }
}
