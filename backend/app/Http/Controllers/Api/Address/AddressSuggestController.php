<?php

namespace App\Http\Controllers\Api\Address;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AddressSuggestController extends Controller
{
        public function suggest(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:3',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Token d6aec6cd02d9b929df7603f9f13f7c7a88aa76cb',
            'Content-Type'  => 'application/json',
        ])->post('https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address', [
            'query' => $request->input('query'),
        ]);

        return response()->json($response->json());
    }
}
