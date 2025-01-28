<?php

namespace App\Models;

use App\Media\HasMedia;
use App\Media\Mediable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubCategoryChild extends Model implements Mediable
{
    use HasFactory, HasMedia;

    protected $fillable = ['name', 'slug', 'sub_category_id', 'status', 'added_by', 'image'];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
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
}
