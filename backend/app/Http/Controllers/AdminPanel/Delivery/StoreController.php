<?php

namespace App\Http\Controllers\AdminPanel\Delivery;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\Delivery\StoreRequest;
use App\Models\Delivery;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        Delivery::create($data);

        return redirect()->route('delivery.index');
    }
}
