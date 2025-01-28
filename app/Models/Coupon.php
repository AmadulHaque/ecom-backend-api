<?php

namespace App\Models;

use App\Enums\CommonType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'coupon_merchants');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_coupons');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_coupons');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'coupon_products');
    }

    public function type()
    {
        return $this->belongsTo(CouponType::class, 'coupon_type_id');
    }

    public function productVariants()
    {
        return $this->hasMany(CouponProductVariant::class, 'coupon_id', 'id');
    }

    public function couponUsages()
    {
        return $this->hasMany(CouponUsage::class, 'coupon_id', 'id');
    }

    public function getTypeLabel($filed)
    {

        return CommonType::label()[$this->$filed->value];
    }

    protected $casts = [
        'product_type' => CommonType::class,
        'category_type' => CommonType::class,
        'brand_type' => CommonType::class,
        'merchant_type' => CommonType::class,

    ];
}
