<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_desktop',
        'image_mobile',
        'whatsapp',
        'facebook',
        'instagram',
        'site',
        'start_date',
        'end_date',
        'position',
        'status',
        'user_id',
    ];
}
