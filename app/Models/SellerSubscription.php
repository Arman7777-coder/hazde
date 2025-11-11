<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'start_date',
        'end_date',
        'payment_status',
        'payment_method',
        'transaction_id'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    // 订阅属于一个用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 订阅属于一个套餐
    public function plan()
    {
        return $this->belongsTo(SellerPlan::class);
    }
}