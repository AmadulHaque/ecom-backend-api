<?php

namespace App\Models;

use App\Enums\DeliveryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = ['delivery_type_label'];

    public function merchantOrders()
    {
        return $this->hasMany(MerchantOrder::class);
    }

    public function orderItems()
    {
        return $this->hasManyThrough(OrderItem::class, MerchantOrder::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function customer_location()
    {
        return $this->belongsTo(Location::class, 'customer_location_id', 'id');
    }

    public function getDeliveryTypeLabelAttribute()
    {
        return DeliveryType::getTypeLabels()[$this->delivery_type];
    }

    public function getCreatedAtAttribute()
    {
        return date('Y-m-d H:i:A', strtotime($this->attributes['created_at']));
    }
}
