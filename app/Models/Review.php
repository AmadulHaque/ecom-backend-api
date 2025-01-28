<?php

namespace App\Models;

use App\Media\HasMedia;
use App\Media\Mediable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model implements Mediable
{
    use HasFactory , HasMedia;

    protected $guarded = ['id'];

    protected $appends = ['images'];

    protected $hidden = ['media'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setImagesAttribute($files)
    {
        if ($files) {
            foreach ($files as $file) {
                $this->addMedia($file, 'images');
            }
        }
    }

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])->format('d M Y');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }

    public function getImagesAttribute()
    {
        return $this->getUrl('images');
    }
}
