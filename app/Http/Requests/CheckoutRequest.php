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
            'phone' => "nullable|string|max:20",
            'notes' => "nullable|string|max:255",
            'terms' => "required|accepted",
        ];
        return array_merge($addressRules,$checkoutRules);
    }

    public function update()
    {
        parent::update();
        if ($this->has('phone')){
            $this->user()->update([
                'phone' => $this->input('phone'),
            ]);
        }
    }
}
