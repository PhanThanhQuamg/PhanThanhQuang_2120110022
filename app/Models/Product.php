<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ProductImage;

class Product extends Model
{
    use HasFactory;
    protected   $table = 'ptq_product';

    //quan hệ 1 nhiều
    public function productimg(): hasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
}
