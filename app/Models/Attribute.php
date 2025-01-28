<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function options()
    {
        return $this->hasMany(AttributeOption::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
