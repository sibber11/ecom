<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'status' => 'required|string|in:' . implode(',', array_keys(Order::STATUSES)),
            'payment_status' => 'required|string|in:'. implode(',', array_keys(Order::PAYMENT_STATUSES))
        ];
    }

    public function messages()
    {
        return [
            'status.in' => 'Status must be one of the following: ' . implode(',', array_keys(Order::STATUSES)),
            'payment_status.in' => 'Payment status must be one of the following: ' . implode(',', array_keys(Order::PAYMENT_STATUSES))
        ];
    }
}
