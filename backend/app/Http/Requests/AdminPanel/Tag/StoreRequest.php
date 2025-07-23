<?php

namespace App\Http\Requests\AdminPanel\Tag;

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
            'title' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'unique:tags',
                'regex:/^[А-ЯЁ][а-яё\s]*$/u', // Начинается с заглавной буквы и состоит только из русских букв и пробелов
                'not_regex:/\s{2,}/', // Не содержит лишних пробелов
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.regex' => 'Название должно начинаться с заглавной буквы и состоять только из русских букв',
            'title.not_regex' => 'Название не должно содержать лишних пробелов'
        ];
    }
}
