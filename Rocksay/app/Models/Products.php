<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'price',
        'price_promo',
        'prazo',
        'abstract',
        'sizes',
        'image',
        'units',
        'status',
        'photo_name',
        'user_id'
    ];

    /**
     * As categorias associadas a este produto.
     */
    public function categories()
    {
        return $this->belongsToMany(ProductCategories::class, 'categories_as_products', 'product_id', 'category_id');
    }
}
