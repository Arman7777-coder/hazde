<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
            
            // Ensure is_active always has a value
            if (!isset($category->is_active)) {
                $category->is_active = false;
            }
        });

        static::updating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    // 分类可以包含多个产品
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // 分类可以有多个过滤器
    public function filters()
    {
        return $this->hasMany(Filter::class);
    }
}