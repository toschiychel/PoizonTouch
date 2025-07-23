<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderContactInfo extends Model
{
    protected $fillable = [
        'order_id', 'first_name', 'last_name', 'phone', 'email', 'address', 'note'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
