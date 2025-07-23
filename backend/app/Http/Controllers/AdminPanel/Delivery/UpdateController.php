<?php

namespace App\Http\Controllers\AdminPanel\Delivery;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\Delivery\UpdateRequest;
use App\Models\Delivery;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Delivery $delivery)
    {
        $data = $request->validated();
        $delivery->update($data);
        return redirect()->route('delivery.show', $delivery->id);
    }
}
