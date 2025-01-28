<?php

namespace App\Models;

use App\Enums\ItemStatus;
use App\Media\HasMedia;
use App\Media\Mediable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemCase extends Model implements Mediable
{
    use HasFactory, HasMedia;

    protected $guarded = [];

    protected $appends = ['images', 'status_label'];

    protected $hidden = ['media', 'images'];

    public function order_item()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }

    public function setImagesAttribute($files)
    {
        if ($files) {
            foreach ($files as $file) {
                $this->addMedia($file, 'images');
            }
        }
    }

    public function getImagesAttribute()
    {
        return $this->getMedia('images');
    }

    public function getStatusLabelAttribute()
    {
        return ItemStatus::getLabel()[$this->status] ?? 'Unknown';
    }
}
