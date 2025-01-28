<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountChart extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function account_type()
    {
        return $this->belongsTo(AccountType::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
