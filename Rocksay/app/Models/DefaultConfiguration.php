<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultConfiguration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner',
        'cnpj',
        'address',
        'link_address',
        'footer_text',
        'phone',
        'whatsapp',
        'telegram',
        'instagram',
        'facebook',
        'email',
        'email_two',
        'wellcome_message',
        'image',
        'user_id',
    ];

}
