<?php

namespace App\Models;

use App\Enums\MerchantStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'phone', 'shop_address', 'shop_name', 'shop_url', 'shop_status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function shop_products()
    {
        return $this->hasMany(ShopProduct::class);
    }


    public function orders()
    {
        return $this->hasMany(MerchantOrder::class);
    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }

    public function status_label()
    {
        return MerchantStatus::label($this->shop_status);
    }

    public function status_color()
    {
        return MerchantStatus::color($this->shop_status);
    }

    public function reports()
    {
        return $this->hasMany(MerchantReport::class);
    }

    public $casts = [
        'created_at' => 'datetime:d-m-Y',
        'shop_status' => MerchantStatus::class,
    ];
}
