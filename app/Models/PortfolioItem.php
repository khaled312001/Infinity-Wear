<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'gallery',
        'client_name',
        'completion_date',
        'category',
        'is_featured',
        'sort_order'
    ];

    protected $casts = [
        'gallery' => 'array',
        'completion_date' => 'date',
        'is_featured' => 'boolean',
    ];
}