<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'filter_id',
        'name',
        'value',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean'
    ];

    /**
     * 获取选项所属的过滤器
     */
    public function filter()
    {
        return $this->belongsTo(Filter::class, 'filter_id');
    }
}