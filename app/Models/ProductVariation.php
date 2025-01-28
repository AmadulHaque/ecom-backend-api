<?php

namespace App\Models;

use App\Media\HasMedia;
use App\Media\Mediable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model implements Mediable
{
    use HasFactory,  HasMedia;

    protected $guarded = [];

    protected $appends = ['image'];

    protected $hidden = ['media'];

    public function stockInventory()
    {
        return $this->hasOne(StockInventory::class);
    }

    public function variationAttributes()
    {
        return $this->hasMany(VariationAttribute::class);
    }

    public function variations()
    {
        return $this->hasMany(VariationAttribute::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageAttribute()
    {
        return $this->getFirstUrl('image');
    }
}
