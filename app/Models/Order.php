<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, HasUuids;
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'reference',
        'payment_status',
        'coupon_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function OrderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function shippingAddress()
    {
        return $this->hasOne(ShippingAddress::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function shippingFee()
    {
        return $this->hasOneThrough(ShippingAddress::class, ShippingAddress::class);
    }

    public function country()
    {
        return $this->hasOneThrough(Country::class, ShippingFee::class, 'id', 'id', 'id', 'country_id');
    }
}
