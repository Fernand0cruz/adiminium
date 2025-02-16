<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:1|max:10000',
            'stock_quantity' => 'required|integer|min:1|max:2500',
        ];
    }
    public function messages()
    {
        return [
            'price.min' => 'The price must be at least R$ 1.00.',
            'price.max' => 'The price cannot be greater than R$ 10,000.00.',
        ];
        
    }
}
