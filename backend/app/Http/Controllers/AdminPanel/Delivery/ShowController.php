<?php

namespace App\Http\Controllers\AdminPanel\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(Delivery $delivery)
    {
        return view('delivery.show', [
            'delivery' => $delivery
        ]);
    }
}
