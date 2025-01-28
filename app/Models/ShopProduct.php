<?php

namespace App\Models;

use App\Enums\ShopProductStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['status_label', 'status_color'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    // ProductHoldStatus
    public function productHoldStatus()
    {
        return $this->hasOne(ProductHoldStatus::class, 'shop_product_id', 'id');
    }

    public function scopeActive($query)
    {
        // return $this->status == ShopProductStatus::APPROVED;
        return $query->where('status', ShopProductStatus::APPROVED);
    }

    public function getStatusLabelAttribute()
    {
        $status = ShopProductStatus::label();

        return $status[$this->status];
    }

    public function getStatusColorAttribute()
    {
        $status = ShopProductStatus::status_by_color();

        return $status[$this->status];
    }

    public $cast = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
}
