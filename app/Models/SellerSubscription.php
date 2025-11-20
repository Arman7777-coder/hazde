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

    // 订阅属于一个用户（可能为空）
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 订阅属于一个套餐
    public function plan()
    {
        return $this->belongsTo(SellerPlan::class);
    }

    // 范围查询：查找有效的付费订阅
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }
    
    // 检查用户是否已关联到此订阅
    public function hasUser()
    {
        return !is_null($this->user_id);
    }
}