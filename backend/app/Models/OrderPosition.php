<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPosition extends Model
{
    protected $table = 'order_positions';
    protected $guarded = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getImageUrlAttribute()
    {
        return url('storage/' . $this->preview_image_path);
    }
}
