<?php

namespace App\Http\Controllers\AdminPanel\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;

class DestroyController extends Controller
{
    public function __invoke(Delivery $delivery)
    {
        $delivery->delete();
        return redirect()->route('delivery.index');
    }
}
