<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (url()->previous() !== route('products.show', Product::find($this->product_id))) {
            return false;
        }
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
            'body' => 'nullable|string',
            'rating' => 'required|integer|min:1|max:5',
            'product_id' => 'required|integer|exists:products,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'rating.min' => 'A rating must be between 1 and 5',
            'rating.max' => 'A rating must be between 1 and 5',
        ];
    }
}
