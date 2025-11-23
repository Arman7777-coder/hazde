<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'slug',
        'description',
        'details',
        'location',
        'price',
        'price_type',
        'status',
        'rejection_reason',
        'is_active',
        'view_count',
        'pdf_document_path'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'view_count' => 'integer'
    ];

    // 产品属于一个卖家
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 产品属于一个分类
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 产品可以有多个图片
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    
    public function likes()
    {
        return $this->hasMany(ProductLike::class);
    }
    
    public function unavailableDates()
    {
        return $this->hasMany(ProductUnavailableDate::class);
    }
    
    // 获取主图
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }
    
    // 产品可以有多个筛选器值
    public function filterValues()
    {
        return $this->hasMany(ProductFilterValue::class);
    }
}