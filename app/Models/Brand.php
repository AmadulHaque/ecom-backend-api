<?php

namespace App\Models;

use App\Media\HasMedia;
use App\Media\Mediable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model implements Mediable
{
    use HasFactory, HasMedia;

    protected $guarded = [];

    protected $appends = ['image'];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function setImageAttribute($file)
    {
        if ($file) {
            $this->addMedia($file, 'images', [
                'tags' => 'featured,thumbnail',
            ]);
        }
    }

    public function getImageAttribute()
    {
        return $this->getUrl('images');
    }
}
