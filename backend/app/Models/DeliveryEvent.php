<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryEvent extends Model
{
        protected $fillable = [
        'delivery_status_id',
        'status',
        'description',
        'location',
        'happened_at',
    ];

    protected $casts = [
        'happened_at' => 'datetime',
    ];

    public function deliveryStatus()
    {
        return $this->belongsTo(DeliveryStatus::class);
    }
}
