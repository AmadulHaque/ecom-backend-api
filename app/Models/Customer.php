<?php

namespace App\Models;

use App\Media\HasMedia;
use App\Media\Mediable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model implements Mediable
{
    use HasFactory, HasMedia;

    protected $guarded = [];

    protected $appends = ['image'];

    public function customer_type()
    {
        return $this->belongsTo(CustomerType::class);
    }

    public function setImageAttribute($file)
    {
        if ($file) {
            $this->addMedia($file, 'images', ['tags' => '']);
        }
    }

    public function getImageAttribute()
    {
        return $this->getUrl('images')[0];
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
