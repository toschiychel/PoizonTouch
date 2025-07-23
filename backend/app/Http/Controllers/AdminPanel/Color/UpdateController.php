<?php

namespace App\Http\Controllers\AdminPanel\Color;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\Color\UpdateRequest;
use App\Models\Color;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Color $color)
    {  
        $data = $request->validated();
        $color->update($data);
        return redirect()->route('color.show', compact('color'));
    }
}
