<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'products' => ['required', 'array', 'min:1'],
            'products.*.id' => ['integer', 'exists:products,id'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
            'products.*.title' => ['required', 'string'],
            'products.*.price' => ['integer', 'min:1'],
            'products.*.preview_image' => ['string'],
            'products.*.link_url' => ['string'],
            'products.*.calculated' => ['boolean'],
            'products.*.type' => ['string', 'required'],
            'products.*.price_cny' => ['integer', 'nullable'],
            'products.*.weight' => ['numeric', 'nullable'],
    
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'note' => ['nullable', 'string'],
            'email' => ['required', 'string', 'email'],
            'address' => ['required', 'string'],
            'total_price' => ['required', 'integer', 'min:1'],
        ];
    }
}
