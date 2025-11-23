<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerRating extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin_id',
        'seller_id',
        'rating',
        'notes',
    ];

    /**
     * Get the admin who set the rating
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get the seller who received the rating
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}