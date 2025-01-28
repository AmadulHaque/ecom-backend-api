<?php

namespace App\Models;

use App\Media\HasMedia;
use App\Media\Mediable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements Mediable
{
    use HasFactory, HasMedia;

    protected $guarded = [];

    protected $hidden = ['media', 'reviews', 'pivot'];

    protected $appends = ['image', 'is_variant', 'specification', 'thumbnail', 'rating_avg', 'rating_count'];

    public static $PRODUCT_TYPE_SINGLE = 1;

    public static $PRODUCT_TYPE_VARIANT = 2;

    public static $SELLING_TYPE_RETAIL = 1;

    public static $SELLING_TYPE_WHOLESALE = 2;

    public function setImageAttribute($file)
    {
        if ($file) {
            $this->addMedia($file, 'images', ['tags' => '']);
        }
    }

    public function getImageAttribute()
    {
        return $this->getUrl('images');
    }

    public function shopProduct()
    {
        return $this->hasOne(ShopProduct::class);
    }

    public function getThumbnailAttribute()
    {
        return $this->getFirstUrl('thumbnail');
    }

    public function getIsVariantAttribute()
    {
        return $this->product_type_id == 1 ? false : true;
    }

    public function getSpecificationAttribute(): string
    {
        return '';
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function primeViews()
    {
        return $this->belongsToMany(PrimeView::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function productDetail()
    {
        return $this->hasOne(ProductDetails::class, 'product_id', 'id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function subCategoryChild()
    {
        return $this->belongsTo(SubCategoryChild::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function addedByUser()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // implement review rating
    public function getRatingAvgAttribute()
    {
        return $this->reviews->avg('rating') ?: 0;
    }

    public function getRatingCountAttribute()
    {
        return $this->reviews->count();
    }

    protected $casts = [
        'created_at' => 'datetime:Y M D/d H:i:s A',
    ];

    /*
        product variations manage start
    */

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function variationAttributes()
    {
        return $this->hasManyThrough(
            VariationAttribute::class,
            ProductVariation::class,
            'product_id', // Foreign key on `product_variations` table
            'product_variation_id', // Foreign key on `variation_attributes` table
            'id', // Local key on `products` table
            'id' // Local key on `product_variations` table
        );
    }
}
