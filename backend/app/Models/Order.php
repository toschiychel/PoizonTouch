<?php

namespace App\Models;

use App\Enums\OrderPaymentStatus;
use App\Enums\OrderStatus;
use App\Events\Order\OrderCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $table = 'orders';
    protected $guarded = false;

    protected $casts = [
        'payment_status' => OrderPaymentStatus::class,
        'status' => OrderStatus::class,
    ];

    public function positions()
    {
        return $this->hasMany(OrderPosition::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contact()
    {
        return $this->hasOne(OrderContactInfo::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_position')
            ->where('type', 'product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function deliveryStatus()
    {
        return $this->hasOne(DeliveryStatus::class);
    }

    public function status()
    {
        return $this->hasOne(OrderStatus::class);
    }
}
