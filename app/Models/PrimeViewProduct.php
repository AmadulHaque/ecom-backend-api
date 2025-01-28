<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrimeViewProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'prime_view_product';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function prime_view()
    {
        return $this->belongsTo(PrimeView::class);
    }
}
