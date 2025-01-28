<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static $PURCHASE_TYPE_ORDERED = 1;

    public static $PURCHASE_TYPE_Unordered = 2;
}
