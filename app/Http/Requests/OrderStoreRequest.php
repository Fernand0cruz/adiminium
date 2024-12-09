<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
        $rules = [
            'client_id' => 'required|exists:users,id',
            'products_data' => 'required|array',
            'products_data.*.product_id' => 'required|exists:products,id',
            'products_data.*.price' => 'required|numeric|min:1|max:10000',
            'products_data.*.quantity' => 'required|integer|min:1',
        ];

        $products = $this->input('products_data');

        if ($products) {
            foreach ($products as $index => $product) {
                $productModel = Product::find($product['product_id']);

                if ($productModel) {
                    $availableStock = $productModel->stock_quantity ?? 0;

                    $rules["products_data.{$index}.quantity"] = [
                        'required',
                        'integer',
                        'min:1',
                        'max:' . $availableStock,
                    ];
                } 
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'products_data.*.quantity.max' => 'The quantity for product cannot be greater than :max.',
        ];
    }
}
