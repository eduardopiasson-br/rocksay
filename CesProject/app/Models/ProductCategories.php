<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'abstract',
        'status',
        'image',
        'position',
        'user_id',
    ];

    /**
     * As os Produtos associados a esta categoria.
     */
    public function products()
    {
        return $this->belongsToMany('App\Products');
    }
}
