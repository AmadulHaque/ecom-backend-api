<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ShopSetting extends Model
{
    use HasFactory;

    // You may want to use $fillable instead of $guarded for security reasons.
    protected $guarded = [];

    // The boot method should be static as it is a part of Eloquent lifecycle
    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($model) {
            // Clear cache when a new setting is created
            Cache::forget('settings');
        });

        static::updated(function ($model) {
            // Clear cache when a setting is updated
            Cache::forget('settings');
        });

        static::deleted(function ($model) {
            // Clear cache when a setting is deleted
            Cache::forget('settings');
        });
    }
}
