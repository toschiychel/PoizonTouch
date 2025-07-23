<?php

namespace App\Http\Requests\AdminPanel\Product;

use Illuminate\Foundation\Http\FormRequest;

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
            'title' => 'required|string',
            'description' => 'required|string',
            'content' => 'required|string',
            'count' => 'required|integer',
            'preview_image' => 'file',
            'price' => 'required|integer',
            'is_published' => 'string',
            'category_id' => 'required|integer',
            'tags' => 'required|array',
            'colors' => 'required|array',
            'images' => 'nullable|array',
            'weight' => 'nullable|numeric',
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
