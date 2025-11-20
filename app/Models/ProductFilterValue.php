<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFilterValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'filter_id',
        'filter_option_id',
        'value'
    ];

    protected $casts = [
        'product_id' => 'integer',
        'filter_id' => 'integer',
        'filter_option_id' => 'integer'
    ];

    /**
     * 获取值所属的产品
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * 获取值所属的筛选器
     */
    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }

    /**
     * 获取值所属的筛选器选项
     */
    public function filterOption()
    {
        return $this->belongsTo(FilterOption::class);
    }
}