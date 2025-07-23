<?php

namespace App\Http\Requests\AdminPanel\Order\Position;

use App\Enums\PaymentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateRequest extends FormRequest
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
            'linkPositions.*.id' => 'required|integer|exists:order_positions,id',
            'linkPositions.*.title' => 'required|string',
            'linkPositions.*.link_url' => 'required|string',
            'linkPositions.*.cny_price' => 'required|integer',
            'linkPositions.*.weight' => 'required|numeric',
            'linkPositions.*.commission_percent' => 'nullable|integer|required_without:linkPositions.*.commission_fixed',
            'linkPositions.*.commission_fixed' => 'nullable|integer|required_without:linkPositions.*.commission_percent',
        ];
    }
}
