<?php

namespace App\Http\Requests\AdminPanel\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    // protected $stopOnFirstFailure = true;

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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
            'name' => 'required|string',
            'surname' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'role' => 'string'
        ];
    }

    public function messages(): array
    {
        return [
            
        ];
    }
}
