<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['status_label', 'status_bg_color'];

    public function merchant()
    {
        return $this->belongsTo(MerchantOrder::class, 'merchant_order_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function product_variant()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id', 'id');
    }

    public function itemCase()
    {
        return $this->hasOne(OrderItemCase::class, 'order_item_id', 'id');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'order_item_id', 'id');
    }

    public function getStatusLabelAttribute()
    {
        $statuses = OrderStatus::getProductStatusLabels() ?? [];

        return $statuses[$this->status_id] ?? 'Unknown';
    }

    public function getStatusBgColorAttribute()
    {
        $statuses = OrderStatus::status_by_color() ?? [];

        return $statuses[$this->status_id] ?? 'alert-warning';
    }
}
