<?php

namespace App\Http\Controllers\AdminPanel\Color;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\Color\StoreRequest;
use App\Models\Color;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {   
        $data = $request->validated();
        $color = Color::firstOrCreate($data);
        return redirect()->route('color.index');
    }
}
