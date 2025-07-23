<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'deliveries';
    protected $guarded = false;

    public static function getDefault(): self
    {
        return static::firstOrFail();
    }
}
