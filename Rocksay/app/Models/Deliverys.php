<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliverys extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'icon',
        'position',
        'status',
        'user_id',
    ];
}
