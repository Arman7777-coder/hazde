<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'wedding_date',
        'message',
        'is_read',
        'is_replied',
    ];

    protected $casts = [
        'wedding_date' => 'date',
        'is_read' => 'boolean',
        'is_replied' => 'boolean',
    ];
}