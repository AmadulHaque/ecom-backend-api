<?php

namespace App\Models;

use App\Media\HasMedia;
use App\Media\Mediable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubCategory extends Model implements Mediable
{
    use HasFactory, HasMedia;

    protected $fillable = ['name', 'slug', 'category_id', 'status', 'added_by', 'image'];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
        $this->attributes['slug'] = Str::slug($value);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subchilds()
    {
        return $this->hasMany(SubCategoryChild::class);
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
