<?php

namespace App\Http\Controllers\AdminPanel\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('delivery.index', [
            'deliveries' => Delivery::paginate(10),
        ]);
    }
}
