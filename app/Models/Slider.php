<?php

namespace App\Models;

use App\Enums\SliderType;
use App\Media\HasMedia;
use App\Media\Mediable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model implements Mediable
{
    use HasFactory , HasMedia;

    protected $guarded = [];

    protected $appends = ['full_image', 'small_image', 'label'];

    protected $hidden = ['media'];

    public function getFullImageAttribute()
    {
        $image = $this->getFirstUrl('web_image');
        $app_url = env('APP_URL');
        $app_url_test = env('APP_URL_TEST');
        if ($image && $app_url && $app_url_test) {
            return str_replace($app_url, $app_url_test, $image);
        }

        return $image;
    }

    public function getSmallImageAttribute()
    {
        $image = $this->getFirstUrl('mobile_image');
        $app_url = env('APP_URL');
        $app_url_test = env('APP_URL_TEST');
        if ($image && $app_url && $app_url_test) {
            return str_replace($app_url, $app_url_test, $image);
        }

        return $image;
    }

    public function setFullImageAttribute($file)
    {
        if ($file) {
            if ($this->media()->where('collection_name', 'web_image')->first()) {
                $this->deleteMedia($this->media()->where('collection_name', 'web_image')->first()->id);
            }

            $this->addMedia($file, 'web_image', ['tags' => '']);
        }
    }

    public function setSmallImageAttribute($file)
    {
        if ($file) {
            if ($this->media()->where('collection_name', 'mobile_image')->first()) {
                $this->deleteMedia($this->media()->where('collection_name', 'mobile_image')->first()->id);
            }

            $this->addMedia($file, 'mobile_image', ['tags' => '']);
        }
    }

    public function getLabelAttribute()
    {
        return SliderType::getLabel($this->slider_type);
    }

    protected $casts = [
        'slider_type' => SliderType::class,
    ];
}
