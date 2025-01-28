<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryCreateRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static $PENDING = '1';

    public static $APPROVED = '2';

    public static $REJECTED = '3';

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
