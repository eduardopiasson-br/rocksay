<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogGalleries extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'text_top',
        'text_bottom',
        'image',
        'in_text',
        'position',
        'status',
        'user_id',
        'blog_id'
    ];
}
