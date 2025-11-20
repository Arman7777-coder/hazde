<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnavailableDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'unavailable_date'
    ];

    protected $casts = [
        'unavailable_date' => 'date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}