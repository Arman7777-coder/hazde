<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'max_products',
        'max_images_per_product',
        'can_set_price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'max_products' => 'integer',
        'max_images_per_product' => 'integer',
        'can_set_price' => 'boolean'
    ];

    // 一个套餐可以被多个卖家订阅
    public function subscriptions()
    {
        return $this->hasMany(SellerSubscription::class, 'plan_id');
    }
}