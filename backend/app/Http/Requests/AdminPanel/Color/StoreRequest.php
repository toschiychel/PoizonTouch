<?php

namespace App\Http\Requests\AdminPanel\Color;

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
            'title' => 'required|string',
            'hex' => [
                'required',
                'string',
                'unique:colors',
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$|^(rgb|rgba)(s*(d{1,3}s*,s*){2}d{1,3}s*(,s*(0|1|0?.d+))?s*)$/', // Проверка на корректность HEX, RGB/RGBA
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.regex' => 'Должен соответствовать формату HEX, RGB/RGBA',
            'title.not_regex' => 'Название не должно содержать лишних пробелов'
        ];
    }
}
