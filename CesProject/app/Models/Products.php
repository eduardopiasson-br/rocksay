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
        'photo_name',
        'highlight',
        'user_id'
    ];

    /**
     * As categorias associadas a este produto.
     */
    public function categories()
    {
        return $this->belongsToMany('App\ProductCategories');
    }
}
