<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSpec extends Model
{
     protected $fillable = ['product_id', 'spec_name', 'spec_value'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
