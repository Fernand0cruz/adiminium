<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
            'increment_product' => ['array'],
            'increment_product.product_id' => ['required_with:increment_product', 'exists:products,id'],
            'increment_product.quantity' => ['required_with:increment_product', 'integer', 'min:1'],

            'add_product' => ['array'],
            'add_product.product_id' => ['required_with:add_product', 'exists:products,id'],
            'add_product.quantity' => ['required_with:add_product', 'integer', 'min:1'],

            'decrement_product' => ['array'],
            'decrement_product.product_id' => ['required_with:decrement_product', 'exists:products,id'],
            'decrement_product.quantity' => ['required_with:decrement_product', 'integer', 'min:1'],

            'delete_product' => ['array'],
            'delete_product.product_id' => ['required_with:delete_product', 'exists:products,id'],
        ];
    }
}
