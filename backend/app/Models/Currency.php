<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';
    protected $guarded = false;

    protected $casts = [
        'fetched_at' => 'datetime',
    ];
}
