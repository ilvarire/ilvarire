<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /** @use HasFactory<\Database\Factories\CountryFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'code'
    ];

    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class);
    }

    public function shippingFee()
    {
        return $this->hasMany(ShippingFee::class);
    }
}
