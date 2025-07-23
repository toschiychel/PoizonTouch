<?php

namespace App\Http\Requests\AdminPanel\Order;

use App\Enums\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SearchRequest extends FormRequest
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
    public function rules()
    {
        return [
            'order_id' => 'nullable|integer|exists:orders,id',
            'order_status' => ['nullable', 'string', new Enum(OrderStatus::class)],
            'email' => 'nullable|email|exists:users,email',
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.integer' => 'Номер заказа должен быть целым числом.',
            'order_id.exists' => 'Выбранный номер заказа не существует.',
            'order_status.string' => 'Статус платежа должен быть строкой.',
            'order_status.in' => 'Статус платежа должен быть одним из: ожидает, оплачен, отправлен, неудачен, возвращен.',
            'email.email' => 'Введите корректный email.',
            'email.exists' => 'Пользователь с такой почтой не найден.',
        ];
    }

    public function validationData(): array
    {
        return $this->query->all();
    }
}
