<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    /** @use HasFactory<\Database\Factories\ShippingAddressFactory> */
    use HasFactory, HasUuids;
    protected $fillable = [
        'user_id',
        'order_id',
        'country_id',
        'shipping_fee_id',
        'address',
        'city',
        'phone_number',
        'state',
        'zip_code'
    ];

    public function country()
    {
        return $this->hasOne(Country::class);
    }

    public function shippingFee()
    {
        return $this->belongsTo(ShippingFee::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
