<?php

namespace App\Models;

use App\Media\HasMedia;
use App\Media\Mediable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model implements Mediable
{
    use HasFactory, HasMedia;

    protected $fillable = ['name', 'slug', 'status', 'added_by', 'image'];

    protected $hidden = ['media'];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
        $this->attributes['slug'] = Str::slug($value);
    }

    public function setImageAttribute($file)
    {
        if ($file) {
            if ($this->media()->where('collection_name', 'images')->first()) {
                $this->deleteMedia($this->media()->where('collection_name', 'images')->first()->id);
            }
            $this->addMedia($file, 'images', ['tags' => '']);
        }
    }

    public function getImageAttribute()
    {
        return $this->getFirstUrl('images');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'category_coupons');
    }

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
