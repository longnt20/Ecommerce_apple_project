<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'description',
        'image',
        'status',
    ];
    protected $dates = ['deleted_at'];
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    // Quan hệ con
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
