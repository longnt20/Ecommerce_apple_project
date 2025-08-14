<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'category_id',
        'thumbnail',
        'gallery',
        'default_price',
        'visibility',
        'status'
    ];
    protected $casts = [
        'gallery' => 'array', // Lưu và đọc gallery dạng array
        'default_price' => 'decimal:2'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
