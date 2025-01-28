<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'report_details',
        'status',
        'added_by',
    ];


    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }


    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function getStatusAttribute($value)
    {
        return ucfirst($value);
    }
}
