<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'video',
        'image',
        'start_post',
        'end_post',
        'autor',
        'font',
        'font_link',
        'button',
        'button_text',
        'button_link',
        'highlight',
        'status',
        'user_id',
    ];
}
