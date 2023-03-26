<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends AddressUpdateRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        //validate address and checkout fields

        $addressRules = parent::rules();
        $checkoutRules = [
            'phone' => "required|string|max:20",
            'notes' => "required|string|max:255",
            'terms' => "required|accepted",
        ];
        return array_merge($addressRules,$checkoutRules);
    }
}
