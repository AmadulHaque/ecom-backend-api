<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponProductVariant extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id', 'id');
    }

    public function variations()
    {
        return $this->hasManyThrough(
            VariationAttribute::class,
            ProductVariation::class,
            'id',
            'product_variation_id',
            'product_variation_id',
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
