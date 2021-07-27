<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'text',
        'icon',
        'position',
        'status',
        'user_id',
    ];
}
