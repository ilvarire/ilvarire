<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /** @use HasFactory<\Database\Factories\ContactFactory> */
    use HasFactory;

    protected $fillable = [
        'address',
        'phone',
        'email',
        'facebook_link',
        'tiktok_link',
        'instagram_link',
        'x_link'
    ];
}
