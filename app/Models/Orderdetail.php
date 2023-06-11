<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Orderdetail extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected   $table = 'ptq_Orderdetail';

    public function sanpham(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    public function productimg(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id');
    }
}
